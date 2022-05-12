<?php
// +----------------------------------------------------------------------
// | quickadmin框架 [ quickadmin框架 ]
// +----------------------------------------------------------------------
// | 版权所有 2020~2022 南京新思汇网络科技有限公司
// +----------------------------------------------------------------------
// | 官方网站: https://www.quickadmin.top
// +----------------------------------------------------------------------
// | Author: zs <909883663@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\traits;

use think\exception\ValidateException;
use think\facade\Log;
use util\Excel;

/**
 * crud 复用类
 * @Autor: zs
 * @Date: 2021-05-25 17:34:23
 * @LastEditors: zs
 * @LastEditTime: 2021-05-25 17:35:59
 */
trait Crud
{
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
        try {
            $this->validate && validate($this->validate)->check($post);
            $result = $this->model->save($post);
            if ($result) {
                return success('添加成功！');
            }
            return error('添加失败');
        } catch (ValidateException $e) {

            return error($e->getError());
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
        if ($this->request->isPost()) {
            $post = $this->request->post();
            try {
                $this->validate && validate($this->validate)->scene('edit')->check($post);
                $result = $row->save($post);
                if ($result) {
                    return success('保存成功！');
                }
                return error('保存失败');
            } catch (ValidateException $e) {
                return error($e->getError());
            } catch (\Exception $e) {
                Log::error("--------:" . $e);
                return error('保存失败');
            }
        }
        return success('ok', $row);
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
        return success('ok', $row);
    }
    /**
     * 状态启用、禁用
     */
    public function status($id, $status)
    {
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
        try {
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
                ->limit(100)
                ->select();
            return success("", $data);
        } catch (\Exception $e) {
            Log::error("--------:" . $e);
            $this->error('获取数据失败');
        }

    }

    /**
     * 下拉列表分页
     */
    public function selectPage()
    {

        try {
            $page = $this->request->get('page', 1);
            $limit = $this->request->get('limit', 15);
            $show_id = $this->request->get('show_id', 'id'); //前端显示的value
            $query_field = $this->request->get('query_field', 'name'); //查询的参数名称
            $show_field = $this->request->get('show_field', 'name'); //前端显示的label
            $keyword = $this->request->get('keyword', ''); //查询的参数值

            $query_value = $this->request->get('query_value', ''); //编辑查询检索的值
            $where = [];
            if ($query_value) {
                $where[] = [$show_id, '=', $query_value];
            }
            if ($keyword) {
                $where[] = [$query_field, 'LIKE', "%{$keyword}%"];
            }
            $fields = $show_id . ',' . $show_field;
            $count = $this->model
                ->where($where)
                ->count();
            $datalist = $this->model
                ->field($fields)
                ->where($where)
                ->page($page, $limit)
                ->select();
            $list = [];
            foreach ($datalist as $index => $item) {
                $result = [
                    $show_id => isset($item[$show_id]) ? $item[$show_id] : '',
                    $show_field => isset($item[$show_field]) ? $item[$show_field] : '',
                ];
                $list[] = $result;
            }
            $data = [
                'code' => 1,
                'msg' => '',
                'count' => $count,
                'data' => $list,
            ];
            return json($data);
        } catch (\Exception $e) {
            Log::error("--------:" . $e);
            $this->error('获取数据失败');
        }

    }
    /**
     * 导出
     */
    public function export()
    {
        list($limit, $where, $sortArr) = $this->buildTableParames();
        $fields = $this->request->get('fields');
        $fields = json_decode($fields, true);

        $header = [];
        foreach ($fields as $vo) {
            $header[] = [$vo['comment'], $vo['field']];
        }
        $tableName = $this->model->getName();
        $list = $this->model
            ->where($where)
            ->limit(100000)
            ->order($sortArr)
            ->select()
            ->toArray();
        $fileName = "export_" . $tableName . "_" . time();
        return Excel::exportData($list, $header, $fileName, 'xlsx');
    }
}
