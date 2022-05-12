<?php

// +----------------------------------------------------------------------
// | quickadmin框架 [ quickadmin框架 ]
// +----------------------------------------------------------------------
// | 版权所有 2020~2022 南京新思汇网络科技有限公司
// +----------------------------------------------------------------------
// | 官方网站: https://www.quickadmin.icu
// +----------------------------------------------------------------------
// | Author: zs <909883663@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\service\MenuService;
use app\common\controller\AdminBase;
use think\facade\Log;
use util\Upload;

class Ajax extends AdminBase
{

    /**
     * 初始化后台接口地址
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function initIndex()
    {
        // $cacheData = Cache::get('initIndex_' . $this->adminId);
        // if (!empty($cacheData)) {
        //     return json($cacheData);
        // }
        $menuService = new MenuService($this->adminId);
        $data = [
            'siteConfig' => sysconfig('site'),
            'menuInfo' => $menuService->getMenuTree(),
        ];
        //Cache::tag('initIndex')->set('initIndex_' . $this->adminId, $data);
        return success('success', $data);
    }
    /**
     * 获取网站配置项
     */
    public function getConfig()
    {
        return success('success', sysconfig('site'));
    }
    /**
     * 上传文件
     */
    public function upload()
    {

        $file = $this->request->file('file');
        try {
            $upload = new Upload();
            $res = $upload->upload($file);
            if ($res['url']) {
                return success('ok', ['url' => $res['url']]);
            } else {
                return error($res['msg']);
            }
        } catch (\Exception $e) {
            Log::error("---ajax---upload--error:" . $e);
        }
        return error('上传文件失败');
    }

    /**
     * 获取验证码
     */

    public function getCaptcha()
    {
        return captchaimg();
    }

}
