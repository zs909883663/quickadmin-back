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
namespace addons;

use app\admin\service\AuthService;
use app\BaseController;
use util\Token;

/*
 * @Autor: zs
 * @Date: 2021-05-24 17:28:41
 * @LastEditors: zs
 * @LastEditTime: 2021-05-25 17:40:22
 */
class pluginsBase extends BaseController
{
    /**
     * 无需登录的方法,也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedAuth = [];

    /**
     * 初始化方法
     */
    protected function initialize()
    {
        parent::initialize();
        $action = $this->request->action();
        $permission = $this->request->root . "/" . parseNodeStr($this->request->controller() . '/' . $this->request->action());
        //是否需要登录
        $adminId = 0;
        $group_ids = [];
        if (!in_array($action, $this->noNeedLogin)) {
            $token = $this->request->header('token');
            if (!$token) {
                addonresult(4001, 'token失效');
            }
            $admin = Token::admin($token);
            $adminId = isset($admin['id']) ? $admin['id'] : 0;
            if (!$adminId) {
                addonresult(4001, 'token失效');
            }
            $group_ids = isset($admin['group_ids']) ? $admin['group_ids'] : [];
        }

        $config = config('auth');
        //鉴权
        if (!in_array($action, $this->noNeedLogin) && !in_array($action, $this->noNeedAuth) && $adminId && !in_array($adminId, $config['super_admin_ids'])) {
            $authservice = new AuthService($adminId);
            $check = $authservice->checkPermission($permission, $group_ids);
            if (!$check) {
                addonresult(4002, '无权限访问！');
            }
        }
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
                case 'range':
                    [$beginTime, $endTime] = explode(' - ', $val);
                    $where[] = [$key, '>=', strtotime($beginTime)];
                    $where[] = [$key, '<=', strtotime($endTime)];
                    break;
                default:
                    $where[] = [$key, $op, "%{$val}"];
            }
        }
        return [$limit, $where, $sortArr];
    }
}
