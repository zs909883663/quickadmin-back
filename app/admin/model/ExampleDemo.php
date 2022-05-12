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
class ExampleDemo extends BaseModel
{
// 追加属性
    protected $append = [
        'week_text',
        'flag_text',
        'genderdata_text',
        'actdata_text',
        'switch_text',
        'status_text',
    ];

    public function getWeekList()
    {
        return ['1' => '周一', '2' => '周二', '3' => '周三', '4' => '周四', '5' => '周五', '6' => '周六', '7' => '周日'];
    }

    public function getFlagList()
    {
        return ['1' => '热门', '2' => '最新', '3' => '推荐'];
    }

    public function getGenderdataList()
    {
        return ['1' => '男', '2' => '女', '3' => '未知'];
    }

    public function getActdataList()
    {
        return ['1' => '徒步', '2' => '读书会', '3' => '自驾游'];
    }

    public function getStatusList()
    {
        return ['1' => '正常', '2' => '隐藏'];
    }

    public function getSwitchList()
    {
        return ['0' => '关', '1' => '开'];
    }

    public function getWeekTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['week']) ? $data['week'] : '');
        $list = $this->getWeekList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getFlagTextAttr($value, $data)
    {
      
        $value = $value ? $value : (isset($data['flag']) ? $data['flag'] : '');
        $valueArr =is_array($value) ? $value: explode(',', $value);
        $list = $this->getFlagList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    public function getGenderdataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['genderdata']) ? $data['genderdata'] : '');
        $list = $this->getGenderdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getActdataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['actdata']) ? $data['actdata'] : '');
        $valueArr = is_array($value) ? $value: explode(',', $value);
        $list = $this->getActdataList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getSwitchTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['switch']) ? $data['switch'] : '');
        $list = $this->getSwitchList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function category()
    {
        return $this->belongsTo('\app\admin\model\ExampleCategory', 'category_id', 'id');
    }
}
