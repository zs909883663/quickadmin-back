<?php

namespace app\admin\controller\system;

use app\admin\model\SystemGroup;
use app\admin\model\SystemGroupAdmin;
use app\admin\validate\SystemAdmin;
use app\common\controller\AdminBase;
use think\App;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

/**
 * 系统管理员控制器
 */
class Admin extends AdminBase
{

    protected $model = null;

    protected $relationSearch = false;

    protected $prefix = "qu_";

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\SystemAdmin();
        $this->prefix = env('database.prefix');
    }

    /**
     * 列表
     */
    public function index()
    {
        list($limit, $where, $sortArr) = $this->buildTableParames();
        $list = $this->model
            ->where($where)
            ->order($sortArr)
            ->paginate($limit);
        $systemGroups = SystemGroup::where('status', 1)->column('id,name');
        $groupName = [];
        foreach ($systemGroups as $k => $v) {
            $groupName[$v['id']] = $v['name'];
        }
        foreach ($list as $k => $v) {
            $group_arr = Db::table("{$this->prefix}system_group_admin")
                ->alias('sga')
                ->field('sg.name')
                ->leftJoin("{$this->prefix}system_group sg", 'sga.group_id=sg.id')
                ->where('sga.admin_id', $v['id'])
                ->select();

            $group_text = "";
            $i = 0;
            foreach ($group_arr as $key => $val) {
                $group_text = $i == 0 ? $val['name'] : $group_text . "," . $val['name'];
                $i++;
            }
            $v['group_text'] = $group_text;
            unset($v['password']);
        }
        $data = [
            'code' => 1,
            'msg' => '',
            'count' => $list->total(),
            'data' => $list->items(),
        ];
        return json($data);
    }
    /**
     * 添加
     */
    public function add()
    {
        $post = $this->request->post();
        Db::startTrans();
        try {
            validate(SystemAdmin::class)->check($post);
            $post['password'] = md5($post['password']);
            $this->model->save($post);
            $row = $this->model->where('username', $post['username'])->find();
            // $group_ids=explode(',',$post['group_ids']);
            $group_ids = $post['group_ids'];
            $groupadmin = [];
            foreach ($group_ids as $v) {
                $groupadmin[] = ['admin_id' => $row['id'], 'group_id' => $v];
            }
            $groupadminModel = new SystemGroupAdmin();
            $groupadminModel->saveAll($groupadmin);
            Db::commit();
            return success('添加成功！');
        } catch (ValidateException $e) {
            return error($e->getError());

        } catch (\Exception $e) {
            Db::rollback();
            Log::error("--------:" . $e);
            return error('添加失败:' . $e->getMessage());
        }

    }

    /**
     * 查找
     */
    public function find($id)
    {
        $row = $this->model->find($id);
        if (empty($row)) {
            return error('数据不存在');
        }
        $groups = SystemGroupAdmin::where('admin_id', $row['id'])->column('group_id');
        $row['group_ids'] = $groups;
        return success('ok', $row);
    }

    /**
     * 修改
     *
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        if (empty($row)) {
            return error('数据不存在');
        }

        $post = $this->request->post();
        Db::startTrans();
        try {
            validate(SystemAdmin::class)->scene('edit')->check($post);
            if (isset($post['password']) && $post['password'] != "") {
                $post['password'] = md5($post['password']);
            } else {
                unset($post['password']);
            }
            $row->save($post);
            $groupadminModel = new SystemGroupAdmin();
            $groupadminModel->where('admin_id', $row['id'])->delete();
            //$group_ids=explode(',',$post['group_ids']);
            $group_ids = $post['group_ids'];
            $groupadmin = [];
            foreach ($group_ids as $v) {
                $groupadmin[] = ['admin_id' => $row['id'], 'group_id' => $v];
            }
            $groupadminModel->saveAll($groupadmin);
            Db::commit();
            return success('添加成功！');
        } catch (ValidateException $e) {
            return error($e->getError());
        } catch (\Exception $e) {
            Db::rollback();
            Log::error("--------:" . $e);
            return error('保存失败');
        }

        return success('ok', $row);

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
        if (in_array("1", $ids) || in_array(1, $ids)) {
            return error('当前管理员不可以删除!');
        }
        try {
            $save = $row->delete();
            SystemGroupAdmin::where('admin_id', 'in', $ids)->delete();
        } catch (\Exception $e) {
            return error('删除失败');
        }
        return $save ? success('删除成功！') : error('删除失败');

    }

}
