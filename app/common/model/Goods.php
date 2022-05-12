<?php

namespace app\common\model;

use app\common\model\BaseModel;


class Goods extends BaseModel
{

    protected $name = "goods";
    // 追加属性
    protected $append = [
                'status_text', ];
    protected $deleteTime= false;
    

    
    public function goodsCategory()
    {
        return $this->belongsTo('\app\common\model\GoodsCategory', 'category_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo('\app\common\model\District', 'district_id', 'id');
    }

    
    public function getStatusList()
    {
        return ['1'=>'下架','2'=>'上架',];
    }

    
    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}