<?php

namespace app\admin\controller\system;

use app\common\controller\AdminBase;
use think\App;
use think\facade\Log;

/**
 * menu控制器
 */
class Menu extends AdminBase
{

    protected $model = null;

    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\SystemMenu();

    }

    /**
     * 添加
     */
    public function add()
    {
        $post = $this->request->post();
        try {
            if ($post['type'] == 1) {
                if ($post['pid'] == 0) {
                    $post['component'] = "Layout";
                } else {
                    $post['component'] = "ParentView";
                }

            }
            //path 如果不是外链 判断是否唯一
            $path = isset($post['path']) ? $post['path'] : "";
            if ($path && stripos($path, 'http') === false) {
                $count = $this->model->where('path', $path)->count();
                if ($count > 0) {
                    return error('路由地址已存在,换个试试！');
                }
            }
            $result = $this->model->save($post);
            if ($result) {
                return success('添加成功！');
            }
            return error('添加失败');
        } catch (\Exception $e) {
            return error('添加失败:' . $e->getMessage());
        }

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
        if ($post['type'] == 1) {
            if ($post['pid'] == 0) {
                $post['component'] = "Layout";
            } else {
                $post['component'] = "ParentView";
            }
        }
        try {
            //path 如果不是外链 判断是否唯一
            $path = isset($post['path']) ? $post['path'] : "";
            if ($path && stripos($path, 'http') === false) {
                $count = $this->model->where('path', $path)->where('id', '<>', $post['id'])->count();
                if ($count > 0) {
                    return error('路由地址已存在,换个试试！');
                }
            }
            $result = $row->save($post);
            if ($result) {
                return success('保存成功！');
            }
            return error('保存失败');
        } catch (\Exception $e) {
            Log::error("--------:" . $e);
            return error('保存失败');
        }

        return success('ok', $row);
    }

    /**
     * 获取所有菜单(无层级)
     */

    public function index()
    {
        $status = $this->request->post('status');
        $menu_type = $this->request->post('menu_type'); //1：目录 2：菜单 3：按钮权限  4：目录+菜单 不传取所有
        $where = [];
        if ($status) {
            $where['status'] = $status;
        }
        if ($menu_type) {
            if ($menu_type == 4) {
                $where[] = ['type', '<', 3];
            }
            if ($menu_type < 4) {
                $where['type'] = $menu_type;
            }
        }
        $count = $this->model->where($where)->count();
        $list = $this->model->where($where)->order('weigh desc,id asc')->select();
        $data = [
            'code' => 1,
            'msg' => 'ok',
            'count' => $count,
            'data' => $list,
        ];
        return json($data);
    }
    /**
     * 数据删除
     */
    public function delete($id)
    {

        $row = $this->model->find($id);
        if ($row->isEmpty()) {
            return error('数据不存在');
        }
        $count = $this->model->where('pid', $id)->count();
        if ($count > 0) {
            return error('请先删除子菜单/字权限');
        }
        try {
            $save = $row->delete();

        } catch (\Exception $e) {
            return error('删除失败');
        }
        return $save ? success('删除成功！') : error('删除失败');

    }

    /**
     * 查找
     */
    public function find($id)
    {
        $row = $this->model->find($id);
        unset($row['create_time']);
        unset($row['update_time']);
        if (empty($row)) {
            return error('数据不存在');
        }
        return success('ok', $row);
    }
}
