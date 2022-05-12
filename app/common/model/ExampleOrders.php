<?php

namespace app\common\model;

use app\common\model\BaseModel;

class ExampleOrders extends BaseModel
{

    protected $name = "example_orders";
    // 追加属性
    protected $append = [
        'status_text'];
    protected $deleteTime = false;

    public function getStatusList()
    {
        return ['1' => '未付款', '2' => '待发货', '3' => '待收货', '4' => '已完成'];
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}
