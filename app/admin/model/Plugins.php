<?php

namespace app\admin\model;

use app\admin\model\BaseModel;

class Plugins extends BaseModel
{

    protected $name = "plugins";
    // 追加属性
    protected $append = [
                'status_text', ];

    
    public function pluginsCategory()
    {
        return $this->belongsTo('\app\admin\model\PluginsCategory', 'cate', 'id');
    }

    
    public function getStatusList()
    {
        return ['0'=>'隐藏','1'=>'显示',];
    }

    
    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}