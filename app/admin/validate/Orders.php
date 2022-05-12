<?php

namespace app\admin\validate;

use think\Validate;

class Orders extends Validate
{

    protected $rule = [

        'total' => 'require',
        'remark' => 'require',
        'status' => 'require',
    ];

    protected $scene = [
        'edit' => [],
    ];
}
