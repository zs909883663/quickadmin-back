<?php

namespace app\common\model;

use app\common\model\BaseModel;


class District extends BaseModel
{

    protected $name = "district";
    // 追加属性
    protected $append = [
                'status_text', ];
    protected $deleteTime= false;
    

    
    
    public function getStatusList()
    {
        return ['0'=>'禁用','1'=>'正常',];
    }

    
    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}