<?php
declare (strict_types = 1);

namespace app\admin\listener;

use app\admin\model\SystemFiles;

class Files
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($param)
    {
        $systemFilse=new SystemFiles();
        $systemFilse->save($param);
    }
}
