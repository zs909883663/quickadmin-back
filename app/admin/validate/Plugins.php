<?php

namespace app\admin\validate;

use think\Validate;

class Plugins extends Validate
{

     protected $rule =   [
        
        'title'=>'require',
        'description'=>'require',   
    ];

    protected $scene = [
        'edit'  =>  [],
    ]; 
}