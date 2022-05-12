<?php
/*
 * @Autor: zs
 * @Date: 2021-05-26 09:12:32
 * @LastEditors: zs
 * @LastEditTime: 2021-05-26 15:43:45
 */
// +----------------------------------------------------------------------
// | quickadmin框架 [ quickadmin框架 ]
// +----------------------------------------------------------------------
// | 版权所有 2020~2022 南京新思汇网络科技有限公司
// +----------------------------------------------------------------------
// | 官方网站: https://www.quickadmin.top
// +----------------------------------------------------------------------
// | Author: zs <909883663@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\App;

/*
 * @Description: Do not edit
 * @Date: 2021-05-25 14:57:43
 */
class Systemlog extends AdminBase
{
    protected $model = null;

    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new \app\admin\model\SystemLog();
    }
    /**
     * 添加
     */
    public function add()
    {
        $post = $this->request->post();
        try {
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

}
