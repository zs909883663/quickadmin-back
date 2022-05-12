<?php

namespace app\common\model;

use app\common\model\BaseModel;


class Exp extends BaseModel
{

    protected $name = "exp";
    // 追加属性
    protected $append = [
                'status_text', ];
    protected $deleteTime= false;
    

    
    
    public function getStatusList()
    {
        return ['1'=>'上架','2'=>'下架','3'=>'售罄','4'=>'冻结',];
    }

    
    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}