<?php

namespace app\admin\validate;

use think\Validate;

class PluginsCategory extends Validate
{

     protected $rule =   [
        
        'name'=>'require',
        'status'=>'require',   
    ];

    protected $scene = [
        'edit'  =>  [],
    ]; 
}