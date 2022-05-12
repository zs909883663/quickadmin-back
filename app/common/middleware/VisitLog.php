<?php

namespace app\common\middleware;

use Closure;
use think\facade\Log;
use think\Request;
use think\Response;

class VisitLog
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        /**
         * 记录访问信息
         * -IP 请求方式 请求url
         * -头部参数
         * -请求参数
         */
        $host = $request->ip() . ' ' . $request->method() . ' ' . $request->url(true);
        Log::write($host, 'HOST');
        Log::write($request->header(), 'HEADER');
        Log::write($request->param(), 'PARAM');
        return $next($request);

    }
}
