<?php

namespace app\admin\controller\system;

use app\admin\model\SystemGroupAdmin;
use app\admin\model\SystemGroupMenu;
use app\admin\service\MenuService;
use app\common\controller\AdminBase;
use think\App;
use think\facade\Log;

/**
 * 角色组控制器
 */
class Role extends AdminBase
{

    protected $model = null;
    protected $validate = null;
    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\SystemGroup();

    }

    /**
     * 授权数据
     */

    public function authData()
    {
        $id = $this->request->post('id');
        if (!$id) {
            return error('id不能为空');
        }
        $menuService = new MenuService(0);
        $menuList = $menuService->getAuthMenuData($id);
        return success('', $menuList);
    }

    /**
     * 授权角色组数据
     */
    public function authGroup()
    {
        $id = $this->request->post('id');
        $menu_ids = $this->request->post('menu_ids');
        if (!$id || !$menu_ids) {
            return error('参数不能为空');
        }
        $group = [];
        //$menuArr = explode(',', $menu_ids);
        $menuArr = $menu_ids;
        foreach ($menuArr as $k => $v) {
            $row['group_id'] = $id;
            $row['menu_id'] = $v;
            $group[] = $row;
        }
        try {
            $group_menu_model = new SystemGroupMenu();
            $group_menu_model->where('group_id', $id)->delete();
            $group_menu_model->saveAll($group);
        } catch (\Exception $e) {
            Log::error("--group authGroup error:---" . $e);
            return error('error');
        }
        return success('ok');
    }

    /**
     * 状态启用、禁用
     */
    public function status($id, $status)
    {
        if ($id == 1) {
            return error('超级管理员不可以修改！');
        }
        $row = $this->model->find($id);
        if (empty($row)) {
            return error('数据不存在');
        }
        $msg = $status == 0 ? "禁用" : "启用";
        try {
            $row->status = $status;
            $row->save();
            return success("状态{$msg}成功！");
        } catch (\Exception $e) {
            return error("状态{$msg}失败");
        }
    }
    /**
     * 数据删除
     */
    public function delete($id)
    {
        $ids = is_array($id) ? $id : explode(',', $id);
        $row = $this->model->where("id", "in", $ids)->select();
        if ($row->isEmpty()) {
            return error('数据不存在');
        }
        $save = 1;
        if (in_array("1", $ids) || in_array(1, $ids)) {
            return error('超级管理员不可以删除!');
        }
        try {
            $count = SystemGroupAdmin::where('group_id', 'in', $ids)->count();
            if ($count > 0) {
                return error('当前角色组下有管理员不能删除!');
            }
            $save = $row->delete();
        } catch (\Exception $e) {
            return error('删除失败');
        }
        return $save ? success('删除成功！') : error('删除失败');

    }

    /**
     * 下拉选择列表
     *
     */
    public function selectList()
    {
        try {
            $fields = input('fields');
            if (empty($fields)) {
                $fields = "id,name";
            }
            $data = $this->model
                ->field($fields)
                ->where('status', 1)
                ->limit(100)
                ->select();
            return success("", $data);
        } catch (\Exception $e) {
            Log::error("--------:" . $e);
            return error('获取数据失败');
        }

    }

}
