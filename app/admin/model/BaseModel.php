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

use think\Model;

/*
 * @Description: 模型基类
 * @Autor: zs
 * @Date: 2021-05-25 16:12:33
 * @LastEditors: zs
 * @LastEditTime: 2021-05-25 16:14:10
 */
class BaseModel extends Model
{
    /**
     * 自动时间戳类型
     *
     */
    //protected $autoWriteTimestamp = true;
    protected $autoWriteTimestamp = 'datetime';
    /**
     * 添加时间
     *
     */
    protected $createTime = 'create_time';

    /**
     * 更新时间
     *
     */
    protected $updateTime = 'update_time';
}
