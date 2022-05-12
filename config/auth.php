<?php

// +----------------------------------------------------------------------
// | 路由设置
// +----------------------------------------------------------------------

return [
    //jwt配置
    'jwt' => [
        'key' => '7zikSjhM',
        'expire' => 3600,
        'keeplogin_expire' => 86400,
    ],

    'auth_on' => true, // 权限开关
    'super_admin_ids' => [1, 2], // 超级管理员
    'super_admin_group_id' => 1, // 超级管理员权限组
    // 不需要验证登录的控制器
    'no_login_controller' => [
        'ajax',
    ],

    // 不需要验证登录的方法
    'no_login_node' => [
        '/admin/passport/userinfo',
        '/admin/passport/index',
        '/admin/passport/logout',
    ],

    // 不需要验证权限的控制器
    'no_auth_controller' => [],

    // 不需要验证权限的方法
    'no_auth_node' => [],

];
