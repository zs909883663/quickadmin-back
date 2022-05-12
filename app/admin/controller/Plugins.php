<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use Exception;
use PDO;
use think\App;
use think\facade\Log;
use util\File;

/**
 * Plugins控制器
 */
class Plugins extends AdminBase
{

    protected $model = null;

    protected $validate = null;

    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = new \app\admin\model\Plugins();

        $this->validate = \app\admin\validate\Plugins::class;
    }

    /**
     * 列表
     */
    function list() {
        try {
            $header[] = "apitoken:" . input("apitoken");
            $data = api_post("/qaapi/plugins/index", input(), $header);
            if (!isset($data['code'])) {
                return error('系统错误');
            }
            if (!$data['code']) {
                return error($data['msg']);
            }
            $list = $data['data'];
            $newList = [];
            foreach ($list as $k => $v) {
                $row = $v;
                $row['installed'] = false;
                $row['is_config'] = false;
                $path = get_back_addons_path() . DIRECTORY_SEPARATOR . $v['name'] . DIRECTORY_SEPARATOR;
                $info_path = $path . "info.ini";
                $config_path = $path . "config.php";
                is_file($info_path) && $row['installed'] = true;
                is_file($config_path) && $row['is_config'] = true;
                $newList[$k] = $row;
            }
            $newData['data'] = $newList;
            $newData['count'] = $data['count'];
            $newData['code'] = $data['code'];
            $newData['msg'] = $data['msg'];
            return json($newData);
        } catch (\Exception $e) {
            Log::error("list error:" . $e);
            return error("列表获取失败！");
        }

    }

    /**
     * 分类
     */
    public function categoryList()
    {
        return json(api_post("/qaapi/plugins/categoryList", $this->request->post()));
    }

    /**
     * 卸载
     */
    public function uninstall()
    {
        try {
            $name = input('name', '');
            if (!$name) {
                return error('参数不能为空！');
            }
            //删除菜单
            $class = get_addons_class($name);
            if (class_exists($class)) {
                $addon = new $class($this->app);
                if (method_exists($addon, 'deleteMenu')) {
                    $addon->deleteMenu();
                }
            }
            $backPath = get_back_addons_path() . "/{$name}";
            $frontBase = config('app.front');
            $frontPath = "../../{$frontBase}/src/views/addons/{$name}";
            if (is_dir($backPath)) {
                File::delDirAndFile($backPath);
            }
            if (is_dir($frontPath)) {
                File::delDirAndFile($frontPath);
            }

        } catch (\Exception $e) {
            Log::error("uninstall error:" . $e);
            return error("卸载成功！");
        }
        return success("卸载成功！");
    }
    /**
     * 下载
     */
    public function install()
    {

        $header[] = "apitoken:" . input("apitoken");
        $row = api_post("/qaapi/plugins/install", $this->request->post(), $header);
        if (!isset($row['code'])) {
            return error('系统错误');
        }
        if ($row['code'] != 1) {
            return result($row['code'], $row['msg']);
        }
        $name = $row['data']['plugin']['name'];
        $backBasePath = get_back_addons_path();
        $backPath = $backBasePath . "/{$name}";
        $frontBase = config('app.front');
        $frontPath = "../../{$frontBase}/src/views/addons/{$name}";

        try {
            $backZip = $row['data']['back_zip'];
            $frontZip = $row['data']['front_zip'];
            if (!$frontBase) {
                Log::error("请配置前端项目名称");
                return error("请配置前端项目名称");
            }
            $frontBasePath = "../../{$frontBase}/src/views/addons";
            if ($frontZip && !is_dir($frontBasePath)) {
                Log::error("前端插件路径不存在");
                return error("安装插件失败：前端插件路径不存在");
            }

            if ($backZip) {
                // 后台代码创建文件
                File::create($backBasePath . '/back.zip', base64_decode($backZip));
                // 后台执行解压
                File::extract($backBasePath . '/back.zip', $backBasePath);
            }
            if ($frontZip) {
                File::create($frontBasePath . '/front.zip', base64_decode($frontZip));
                // 后台执行解压
                File::extract($frontBasePath . '/front.zip', $frontBasePath);
            }
            // 依赖的sql
            if (is_file($backBasePath . "/{$name}/install.sql")) {
                $sql = file_get_contents(($backBasePath . "/{$name}/install.sql"));
                $sql = str_replace('__PREFIX__', env('database.prefix'), $sql);
                $info = "mysql:dbname=" . env('database.database') . ";host=" . env('database.hostname') . "";
                $db = new PDO($info, env('database.username'), env('database.password'));
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
                $db->exec($sql);
            }
            //到前端目录执行npm
            if (is_file($backBasePath . "/{$name}/npm.ini")) {
                $npm_shell = file_get_contents(($backBasePath . "/{$name}/npm.ini"));
                chdir("../../{$frontBase}/");
                exec($npm_shell . " 2>&1", $output, $res);
                if ($res != 0) {
                    Log::error("插件安装--npm--结果：" . $res . "， 返回值：" . print_r($output, true));
                    throw new Exception("插件安装失败：npm执行出错");
                }

            }
            //执行composer
            if (is_file($backBasePath . "/{$name}/composer.ini")) {
                $composer_shell = file_get_contents(($backBasePath . "/{$name}/composer.ini"));
                chdir("../");
                exec($composer_shell . " 2>&1", $output, $res);
                if ($res != 0) {
                    Log::error("插件安装--composer--结果：" . $res . "， 返回值：" . print_r($output, true));
                    throw new Exception("插件安装失败：composer执行出错");
                }

            }
            //执行菜单

            $class = get_addons_class($name);
            if (class_exists($class)) {
                $addon = new $class($this->app);
                if (method_exists($class, "menuInit")) {
                    $addon->menuInit();
                }
            }

        } catch (\Exception $e) {
            Log::error("插件安装失败！" . $e);
            if (is_dir($backPath)) {
                File::delDirAndFile($backPath);
            }
            if (is_dir($frontPath)) {
                File::delDirAndFile($frontPath);
            }
            return error($e->getMessage());
        }

        return success("安装插件成功！");
    }

    /**
     * 修改插件配置
     */
    public function config()
    {
        $name = input("name");
        $config = get_addons_all_config($name);

        if ($this->request->isPost()) {
            $data = $this->request->post('data');
            //$data=json_decode($data,true);
            if (!$data) {
                $data = $this->request->post('data');
            }
            if ($data) {
                foreach ($config as &$v) {
                    if (isset($data[$v['name']])) {
                        $v['value'] = $data[$v['name']];
                    }
                }
            }
            try {

                set_addons_config($name, $config);
                return success('更新插件配置成功！');
            } catch (\Exception $e) {
                Log::error("更新插件配置失败！" . $e);
                return error($e->getMessage());
            }
        }
        return success('获取插件配置成功！', $config);
    }

}
