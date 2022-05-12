<?php

namespace app\admin\controller\system;

use app\common\controller\AdminBase;
use think\App;

/**
 * 日志控制器
 */
class Log extends AdminBase
{

    protected $model = null;

    protected $relationSearch = true;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\SystemLog();

    }

    /**
     * 列表
     */
    public function index()
    {
        list($limit, $where, $sortArr) = $this->buildTableParames();
        $list = $this->model
            ->with(['admin'])
            ->where($where)
            ->order($sortArr)
            ->paginate($limit);
        $data = [
            'code' => 1,
            'msg' => '',
            'count' => $list->total(),
            'data' => $list->items(),
        ];
        return json($data);
    }

}
