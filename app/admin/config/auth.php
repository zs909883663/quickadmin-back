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

    // 不需要验证登录的控制器
    'no_login_controller' => [
        'ajax',
        'test',
        'index',
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
    //是否是演示站点
    'is_demo' => false,
];
