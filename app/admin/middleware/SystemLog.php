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

use app\admin\model\SystemLog as ModelSystemLog;
use util\Token;

/*
 *系统日志中间件
 * @Date: 2021-05-26 13:59:06
 * @LastEditors: zs
 * @LastEditTime: 2021-05-26 13:59:28
 */

class SystemLog
{
    public function handle($request, \Closure $next)
    {

        if ($request->isPost()) {
            $method = strtolower($request->method());
            $token = $request->header('token');
            $url = $request->url();
            $ip = getRealIP();
            $params = $request->param();
            $adminId = Token::userId($token);
            $adminId = $adminId ? $adminId : 0;
            if ($adminId > 0) {
                $data = [
                    'admin_id' => $adminId,
                    'url' => $url,
                    'method' => $method,
                    'ip' => $ip,
                    'content' => json_encode($params, JSON_UNESCAPED_UNICODE),
                    'useragent' => $_SERVER['HTTP_USER_AGENT'],
                    'create_time' => date("Y-m-d H:i:s",time()),
                ];
                $modelSystemLog = new ModelSystemLog();
                $modelSystemLog->save($data);
            }
        }
        return $next($request);
    }

}
