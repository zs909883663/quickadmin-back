<?php

namespace app\admin\controller\system;

use app\common\controller\AdminBase;
use think\App;

/**
 * 文件控制器
 */
class Files extends AdminBase
{

    protected $model = null;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new \app\admin\model\SystemFiles();
    }
}
