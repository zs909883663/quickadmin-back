<?php

namespace app\admin\controller\system;

use app\common\controller\AdminBase;
use think\App;
use think\facade\Log;

/**
 * config控制器
 */
class Config extends AdminBase
{

    protected $model = null;

    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\SystemConfig();

    }
    /**
     *
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            try {
                foreach ($post as $key => $val) {
                    $this->model
                        ->where('name', $key)
                        ->update([
                            'value' => $val,
                        ]);
                }
            } catch (\Exception $e) {
                Log::write("post config index error:" . $e);
                return error('保存失败');
            }
            return success('保存成功！');
        }
        try {
            $groupList = $this->model->getGroupList();
            foreach ($groupList as $k => $v) {
                $list = $this->model->field('name,title,value,remark')->where('group', $v['value'])->select();
                $detail = [];
                foreach ($list as $key => $val) {
                    /**
                     * 如果是上传类型的配置追加数据
                     */
                    if ($val['name'] == "upload_type") {
                        $val['extend'] = $this->ossArry();
                    }
                    $detail[$val['name']] = $val;
                }
                $groupList[$k]['detail'] = $detail;
            }
            return success('', $groupList);
        } catch (\Exception $e) {
            Log::write("get config index error:" . $e);
            return error('系统异常');
        }
    }

    public function getGroupList()
    {

        return success('', $this->model->getGroupList());
    }
    /**
     * oss有哪些方式
     */
    public function ossArry()
    {
        $addons = ['qiniu', 'alioss', 'cos'];
        foreach ($addons as $k => $v) {
            if (!get_addons_config_format($v)) {
                unset($addons[$k]);
            }
        }

        array_unshift($addons, 'local');
        return $addons;
    }
}
