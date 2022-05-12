<?php
namespace app\admin\controller\onlinecurd;

use app\admin\model\SystemMenu;
use app\admin\model\SystemOnlinecurd;
use app\common\controller\AdminBase;
use onlinecurd\BuildOnlineCurd;
use think\facade\Db;
use think\facade\Log;

/**
 * 在线生成代码
 *
 */
class Index extends AdminBase
{

    public $model;
    protected $menuList = ['index' => '列表', 'add' => '添加', 'find' => '查看', 'edit' => '编辑', 'delete' => '删除', 'export' => '导出'];
    /**
     * 初始化方法
     */
    protected function initialize()
    {
        parent::initialize();
        $this->model = new SystemOnlinecurd();
    }
    /**
     * 列表
     */
    public function index()
    {
        list($limit, $where, $sortArr) = $this->buildTableParames();

        $list = $this->model
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

    /**
     * 获取所有表
     */
    public function getTables()
    {
        $tableList = [];
        $list = Db::query("SHOW TABLES");
        foreach ($list as $row) {
            $tableList[reset($row)] = reset($row);
        }
        return json(['code' => 1, 'msg' => 'ok', 'data' => $tableList]);
    }
    /**
     * 获取主表字段信息
     */
    public function getMainTableRow()
    {
        $table = input('table');
        if (!$table) {
            return error('表不能为空！');
        }
        try {
            $build = new BuildOnlineCurd();
            $data = $build->getMainTableRow($table);
            return json(['code' => 1, 'msg' => 'ok', 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('获取主表信息失败:' . $e);
            return error($e->getMessage());
        }

    }

    /**
     * 获取表
     */
    public function getSubTableRow()
    {

        $sub_table = input('table');
        if (!$sub_table) {
            return error('从表不能为空！');
        }
        try {
            $build = new BuildOnlineCurd();
            $data = $build->getSubTableRow($sub_table);
            return json(['code' => 1, 'msg' => 'ok', 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('获取从表信息失败:' . $e);
            return error($e->getMessage());
        }
    }
    /**
     * 提交自动生成
     */
    public function save()
    {
        $id = input('id');
        $form = input('form');
        if (!$form) {
            return error("表单信息不能为空!");
        }
        $table_name = $form['table_name'];
        $table_comment = $form['table_comment'];
        $is_force = isset($form['is_force']) ? $form['is_force'] : false;
        $is_menu = isset($form['is_menu']) ? $form['is_menu'] : false;
        $fieldlist = isset($form['fieldlist']) ? $form['fieldlist'] : [];
        $relations = isset($form['relations']) ? $form['relations'] : [];
        $menu_pid = isset($form['menu_pid']) ? $form['menu_pid'] : 0;
        $back_module = isset($form['model_path']) ? $form['model_path'] : "admin"; //后台是哪个项目
        $model_path = isset($form['model_path']) ? $form['model_path'] : "common";
        $relation_table = "";
        $i = 0;
        foreach ($relations as $k => $v) {
            $relation_table = $i == 0 ? $v['table_name'] : $relation_table . "," . $v['table_name'];
            $i++;
        }

        try {
            $build = (new BuildOnlineCurd())
                ->setBackModule($back_module)
                ->setTable($table_name)
                ->setTableComment($table_comment)
                ->setFieldlist($fieldlist)
                ->setRelations($relations)
                ->setModelPath($model_path)
                ->setForce($is_force);

            $build = $build->render();
            $result = $build->create();

            /**
             * 菜单生成start
             */
            if ($is_menu) {
                $controllerUrl = $result['controllerUrl'];
                $viewFilename = $result['viewFilename'];
                $index_component = "{$viewFilename}/index";
                $index_path = str_replace('/', '_', $index_component);
                $indexRow = SystemMenu::where('component', $index_component)->find();
                if (!$indexRow) {
                    $indexRow = new SystemMenu();
                    $indexRow->type = 2;
                    $indexRow->pid = $menu_pid;
                    $indexRow->title = $table_comment;
                    $indexRow->icon = "code";
                    $indexRow->path = $index_path;
                    $indexRow->component = $index_component;
                    $indexRow->save();
                }
                $pid = $indexRow['id'];
                foreach ($this->menuList as $k => $v) {
                    $bt_url = "/admin/{$controllerUrl}/{$k}";
                    $btRow = SystemMenu::where('permission', $bt_url)->find();
                    if (!$btRow) {
                        $btRow = new SystemMenu();
                        $btRow->type = 3;
                        $btRow->pid = $pid;
                        $btRow->title = $v;
                        $btRow->icon = "code";
                        $btRow->permission = $bt_url;
                        $btRow->save();
                    }
                }
            }

            /**
             * 菜单生成end
             */

            //onlinecurd记录
            $filename = "";
            $i = 0;
            foreach ($result['fileList'] as $k => $v) {
                $filename = $i == 0 ? $v : $filename . "," . $v;
                $i++;
            }
            $versionnum = 1;
            $onlineModel = null;
            if ($id) {
                $onlineModel = SystemOnlinecurd::where('id', $id)->find();
            }

            if (!$onlineModel) {
                $onlineModel = new SystemOnlinecurd();
            } else {
                $versionnum = $onlineModel['version'] + 1;
            }

            $onlineModel->table = $table_name;
            $onlineModel->comment = $table_comment;
            $onlineModel->filename = $filename;
            $onlineModel->params = json_encode(input('form'), JSON_FORCE_OBJECT);
            $onlineModel->relation_table = $relation_table;
            $onlineModel->status = 1;
            $onlineModel->version = $versionnum;
            $onlineModel->save();
            return json(['code' => 1, 'msg' => '代码生成成功！', 'data' => []]);
        } catch (\Exception $e) {
            Log::write("++++++++++++++++++++" . $e);
            $versionnum = 1;
            $onlineModel = null;
            if ($id) {
                $onlineModel = SystemOnlinecurd::where('id', $id)->find();
            }

            if (!$onlineModel) {
                $onlineModel = new SystemOnlinecurd();
            } else {
                $versionnum = $onlineModel['version'] + 1;
            }
            $onlineModel = new SystemOnlinecurd();
            $onlineModel->table = $table_name;
            $onlineModel->comment = $table_comment;
            $onlineModel->filename = "";
            $onlineModel->params = json_encode(input('form'), JSON_FORCE_OBJECT);
            $onlineModel->relation_table = $relation_table;
            $onlineModel->status = 0;
            $onlineModel->version = $versionnum;
            $onlineModel->save();
            return json(['code' => 0, 'msg' => $e->getMessage(), 'data' => []]);
        }

    }
}
