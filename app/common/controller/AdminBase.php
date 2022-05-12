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
namespace app\common\controller;

use app\BaseController;
use app\Request;

/*
 * @Autor: zs
 * @Date: 2021-05-24 17:28:41
 * @LastEditors: zs
 * @LastEditTime: 2021-05-25 17:40:22
 */
class AdminBase extends BaseController
{

    protected $model = null;

    protected $adminId;

    protected $relationSearch = false;

    /**
     * 不导出的字段信息
     * @var array
     */
    protected $noExportFields = ['delete_time', 'update_time'];

    use \app\admin\traits\Crud;
    /**
     * 初始化方法
     */
    protected function initialize()
    {
        parent::initialize();
        $this->adminId = request()->adminId;

    }

    /**
     * 构建请求参数
     * @param array $excludeFields 忽略构建搜索的字段
     * @return array
     */
    protected function buildTableParames()
    {

        $page = $this->request->get('page', 1);
        $limit = $this->request->get('limit', 15);
        $filters = $this->request->get('filter', '{}');
        $ops = $this->request->get('op', '{}');
        $sort = $this->request->get("sort", "");
        $order = $this->request->get("order", "");
        $filters = json_decode($filters, true);
        $ops = json_decode($ops, true);
        $where = [];
        //排序
        $sortArr = ['id' => 'DESC'];
        if ($sort && $order) {
            $sortArr = [$sort => $order, 'id' => 'DESC'];
        }
        $this->request->get(['page' => $page]);
        // 表名称
        $tableName = humpToLine(lcfirst($this->model->getName()));

        foreach ($filters as $key => $val) {
            if ($val === "") {
                continue;
            }
            $op = isset($ops[$key]) && !empty($ops[$key]) ? $ops[$key] : '%*%';
            if ($this->relationSearch && count(explode('.', $key)) == 1) {
                $key = "{$tableName}.{$key}";
            }
            switch (strtolower($op)) {
                case '=':
                    $where[] = [$key, '=', $val];
                    break;
                case '%*%':
                    $where[] = [$key, 'LIKE', "%{$val}%"];
                    break;
                case '*%':
                    $where[] = [$key, 'LIKE', "{$val}%"];
                    break;
                case '%*':
                    $where[] = [$key, 'LIKE', "%{$val}"];
                    break;
                case '%like%':
                    $where[] = [$key, 'LIKE', "%{$val}%"];
                    break;
                case 'like%':
                    $where[] = [$key, 'LIKE', "{$val}%"];
                    break;
                case '%like':
                    $where[] = [$key, 'LIKE', "%{$val}"];
                    break;
                case 'range':
                    //  [$beginTime, $endTime] = explode(' - ', $val);
                    $where[] = [$key, '>=', $val[0]];
                    $where[] = [$key, '<=', $val[1]];
                    break;
                default:
                    $where[] = [$key, $op, "%{$val}"];
            }
        }
        return [$limit, $where, $sortArr];
    }

}
