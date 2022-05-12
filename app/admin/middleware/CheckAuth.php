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

namespace app\admin\middleware;

use app\admin\service\AuthService;
use think\Request;
use util\Token;

/*
 *权限校验中间件
 * @Date: 2021-05-26 13:59:06
 * @LastEditors: zs
 * @LastEditTime: 2021-05-26 13:59:28
 */

class CheckAuth
{
    public function handle(Request $request, \Closure $next)
    {
        $auth_config = config('auth');
        $action = $request->action();

        $system_no_auth_function = ['selectPage', 'selectList']; //不需要鉴权的系统方法
        $controller = parse_lower($request->controller());

        $node = $request->root() . "/" . parseNodeStr($request->controller() . '/' . $action);

        if (isset($auth_config['is_demo']) && $auth_config['is_demo']) {
            if ($request->isPost() && (in_array($action, ['add', 'edit', 'delete', 'authGroup', 'update', 'config']) || $node == "/admin/system.config/index")) {
                return result(0, '演示站点不可以修改');
            }
        }

        $token = $request->header('token');
        $admin = Token::admin($token);
        $admin_id = isset($admin['id']) ? $admin['id'] : 0;

        //验证权限
        if (!in_array($controller, $auth_config['no_login_controller']) && !in_array($node, $auth_config['no_login_node']) && !in_array($controller, $auth_config['no_auth_controller']) && !in_array($controller, $auth_config['no_auth_node']) && !in_array($action, $system_no_auth_function) && $admin_id) {
            $group_ids = isset($admin['group_ids']) ? $admin['group_ids'] : [];
            $authservice = new AuthService($admin_id, $group_ids);
            $check = $authservice->checkPermission($node);
            if (!$check) {
                return result(4002, '无权限访问！');
            }
        }
        if ($admin_id) {
            $request->adminId = $admin_id;
        }
        return $next($request);
    }

}
