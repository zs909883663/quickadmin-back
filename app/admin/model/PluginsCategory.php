<?php

namespace app\admin\model;

use app\admin\model\BaseModel;

class PluginsCategory extends BaseModel
{

    protected $name = "plugins_category";
    // 追加属性
    protected $append = [
                'status_text', ];

    
    
    public function getStatusList()
    {
        return [];
    }

    
    public function getStatusTextAttr($value,$data)
    {
         $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}