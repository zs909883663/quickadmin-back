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
namespace app\admin\model;

use app\admin\model\BaseModel;

/*
 * @Autor: zs
 * @Date: 2021-05-25 16:21:16
 * @LastEditors: zs
 * @LastEditTime: 2021-05-25 16:21:18
 */
class SystemLog extends BaseModel
{
    // 关闭自动写入update_time字段
    protected $updateTime = false;

    public function admin()
    {
        return $this->belongsTo('app\admin\model\SystemAdmin', 'admin_id', 'id');
    }

}
