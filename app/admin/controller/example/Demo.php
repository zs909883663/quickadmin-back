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
namespace app\admin\controller\example;

use app\common\controller\AdminBase;
use think\App;
use think\exception\ValidateException;
use think\facade\Log;
use util\Excel;

/*
 * @Description: Do not edit
 * @Date: 2021-05-25 14:57:43
 */
class Demo extends AdminBase
{
    protected $model = null;
    protected $validate = null;

    protected $relationSearch = true;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new \app\admin\model\ExampleDemo();
        //$this->validate = \app\admin\validate\Demo::class;
    }
    /**
     * 列表
     */
    public function index()
    {

        list($limit, $where, $sortArr) = $this->buildTableParames();

        $list = $this->model
            ->withJoin('category', 'LEFT')
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

            if ($post['flag'] && is_array($post['flag'])) {
                $post['flag'] = implode(',', $post['flag']);
            }
            if ($post['actdata'] && is_array($post['actdata'])) {
                $post['actdata'] = implode(',', $post['actdata']);
            }
            if ($post['city'] && is_array($post['city'])) {
                $post['city'] = implode(',', $post['city']);
            }
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
     * 查找
     */
    public function find($id)
    {
        $row = $this->model->find($id);
        if ($row['flag']) {
            $arr = explode(",", $row['flag']);
            foreach ($arr as $k => $v) {
                $arr[$k] = $v * 1;
            }
            $row['flag'] = $arr;
        } else {
            $row['flag'] = [];
        }
        if ($row['actdata']) {

            $arr = explode(",", $row['actdata']);
            foreach ($arr as $k => $v) {
                $arr[$k] = $v * 1;
            }
            $row['actdata'] = $arr;
        } else {
            $row['actdata'] = [];
        }
        if ($row['city']) {
            $row['city'] = explode(',', $row['city']);
        } else {
            $row['city'] = [];
        }
        if (empty($row)) {
            return error('数据不存在');
        }
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

        if ($this->request->isPost()) {
            $post = $this->request->post();
            try {
                $this->validate && validate($this->validate)->check($post);
                if ($post['flag'] && is_array($post['flag'])) {
                    $post['flag'] = implode(',', $post['flag']);
                }
                if ($post['actdata'] && is_array($post['actdata'])) {
                    $post['actdata'] = implode(',', $post['actdata']);
                }
                if ($post['city'] && is_array($post['city'])) {
                    $post['city'] = implode(',', $post['city']);
                }
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
        if ($row['flag']) {
            $arr = explode(",", $row['flag']);
            foreach ($arr as $k => $v) {
                $arr[$k] = $v * 1;
            }
            $row['flag'] = $arr;
        } else {
            $row['flag'] = [];
        }
        if ($row['actdata']) {

            $arr = explode(",", $row['actdata']);
            foreach ($arr as $k => $v) {
                $arr[$k] = $v * 1;
            }
            $row['actdata'] = $arr;
        } else {
            $row['actdata'] = [];
        }
        if ($row['city']) {
            $row['city'] = explode(',', $row['city']);
        } else {
            $row['city'] = [];
        }
        if (empty($row)) {
            return error('数据不存在');
        }
        return success('ok', $row);
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
            ->withJoin('category', 'LEFT')
            ->where($where)
            ->limit(100000)
            ->order($sortArr)
            ->select()
            ->toArray();
        $fileName = "export_" . $tableName . "_" . time();
        return Excel::exportData($list, $header, $fileName, 'xlsx');
    }
}
