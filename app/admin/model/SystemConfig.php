<?php

namespace app\admin\model;

use app\admin\model\BaseModel;

class SystemConfig extends BaseModel
{

    protected $name = "system_config";

    public function getGroupList()
    {
        return [['tab' => '基础配置', 'value' => 'site'], ['tab' => '上传配置', 'value' => 'upload']];
    }

}
