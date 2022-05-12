<?php

namespace app\common\model;

use app\common\model\BaseModel;


class Tip extends BaseModel
{

    protected $name = "tip";
    // 追加属性
    protected $append = [
                'week_text', 
                'flag_text', 
                'genderdata_text', 
                'actdata_text', 
                'switch_text', 
                'status_text', ];
    protected $deleteTime= false;
    

    
    public function category()
    {
        return $this->belongsTo('\app\common\model\Category', 'category_id', 'id');
    }

    
    public function getWeekList()
    {
        return ['1'=>'星期一','2'=>'星期二','3'=>'星期三',];
    }

    public function getFlagList()
    {
        return ['1'=>'热门','2'=>'最新','3'=>'推荐',];
    }

    public function getGenderdataList()
    {
        return ['1'=>'男','2'=>'女','3'=>'未知',];
    }

    public function getActdataList()
    {
        return ['1'=>'徒步','2'=>'读书会','3'=>'自驾游',];
    }

    public function getSwitchList()
    {
        return ['0'=>'关','1'=>'开',];
    }

    public function getStatusList()
    {
        return ['0'=>'禁用','1'=>'正常',];
    }

    
    public function getWeekTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['week']) ? $data['week'] : '');
        $list = $this->getWeekList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getFlagTextAttr($value,$data)
    {
        $value = $value ? $value : (isset($data['flag']) ? $data['flag'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getFlagList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    public function getGenderdataTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['genderdata']) ? $data['genderdata'] : '');
        $list = $this->getGenderdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getActdataTextAttr($value,$data)
    {
        $value = $value ? $value : (isset($data['actdata']) ? $data['actdata'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getActdataList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    public function getSwitchTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['switch']) ? $data['switch'] : '');
        $list = $this->getSwitchList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}