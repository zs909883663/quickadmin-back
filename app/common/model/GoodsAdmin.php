<?php

namespace app\common\model;

use app\common\model\BaseModel;


class GoodsAdmin extends BaseModel
{

    protected $name = "goods_admin";
    // 追加属性
    protected $append = [];
    protected $deleteTime= false;
    

    
    public function goods()
    {
        return $this->belongsTo('\app\common\model\Goods', 'goods_id', 'id');
    }

    
    
}