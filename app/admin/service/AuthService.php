<?php
namespace app\admin\service;

use think\facade\Db;

/**
 * 权限验证服务
 * Class AuthService
 * @package app\common\service
 */
class AuthService
{

    /**
     * 用户ID
     * @var null
     */
    protected $adminId = null;
    /**
     * 权限组
     */
    protected $groupIds = [];
    /**
     * 默认配置
     * @var array
     */
    protected $config = [];

    /***
     * 构造方法
     * AuthService constructor.
     * @param null $adminId
     */
    public function __construct($admin_id = null, $group_ids = [])
    {
        $this->adminId = $admin_id;
        $this->groupIds = $group_ids;
        $this->config = config('auth');
        return $this;
    }

    /**
     * 检测菜单权限
     * @param null $node
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkMenu($menu_id = null)
    {
        //超级管理员
        if (in_array($this->config['super_admin_group_id'], $this->groupIds) || $this->config['auth_on'] == false) {
            return true;
        }
        // 判断权限验证开关
        if ($this->config['auth_on'] == false) {
            return true;
        }
        // 用户验证
        $adminInfo = Db::name('system_admin')
            ->where('id', $this->adminId)
            ->find();
        if (empty($adminInfo) || $adminInfo['status'] != 1) {
            return false;
        }
        // 判断该节点是否允许访问
        $allNode = $this->getAdminMenuId();

        if (in_array($menu_id, $allNode)) {
            return true;
        }
        return false;
    }

    /**
     * 检测按钮权限
     * @param null $node
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkPermission($node = null)
    {
        //超级管理员
        if (in_array($this->config['super_admin_group_id'], $this->groupIds) || $this->config['auth_on'] == false) {
            return true;
        }
        // 判断权限验证开关
        if ($this->config['auth_on'] == false) {
            return true;
        }
        // 判断是否需要获取当前节点
        if (empty($node)) {
            $node = $this->getCurrentNode();
        } else {
            $node = $this->parseNodeStr($node);
        }
        $nodeInfo = Db::name('system_menu')
            ->where(['permission' => $node])
            ->find();
        if (empty($nodeInfo)) {
            return false;
        }
        // 用户验证
        $adminInfo = Db::name('system_admin')
            ->where('id', $this->adminId)
            ->find();
        if (empty($adminInfo) || $adminInfo['status'] != 1) {
            return false;
        }
        // 判断该节点是否允许访问
        $allNode = $this->getAdminPermission();

        if (in_array($node, $allNode)) {
            return true;
        }
        return false;
    }

    /**
     * 获取当前节点
     * @return string
     */
    public function getCurrentNode()
    {
        $node = $this->parseNodeStr(request()->root() . '/' . request()->controller() . '/' . request()->action());
        return $node;
    }

    /**
     * 获取当前管理员所有菜单/权限id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminMenuId()
    {
        return $this->getMenuColumns('id');
    }

    public function getAdminPermission()
    {
        return $this->getMenuColumns('permission');
    }
    /**
     * 获取菜单的某列
     */
    public function getMenuColumns($column)
    {
        $menuIdList = [];
        $adminInfo = Db::name('system_admin')
            ->where([
                'id' => $this->adminId,
                'status' => 1,
            ])->find();
        if (!empty($adminInfo)) {
            $admin_groups = Db::name('system_group_admin')
                ->where([
                    'admin_id' => $this->adminId,
                ])->column('group_id');
            $buildGroupSql = Db::name('system_group')
                ->distinct(true)
                ->whereIn('id', $admin_groups)
                ->field('id')
                ->buildSql(true);
            $buildGroupMenuSql = Db::name('system_group_menu')
                ->distinct(true)
                ->where("group_id IN {$buildGroupSql}")
                ->field('menu_id')
                ->buildSql(true);
            $menuIdList = Db::name('system_menu')
                ->distinct(true)
                ->where("id IN {$buildGroupMenuSql}")
                ->column($column);
        }
        return $menuIdList;
    }
    /**
     * 获取用户所有按钮权限地址
     */
    public function getPermission()
    {
        $permissionList = [];
        //超级管理员
        if (in_array($this->config['super_admin_group_id'], $this->groupIds) || $this->config['auth_on'] == false) {
            $permissionList = Db::name('system_menu')->where('type', 3)->column('permission');
            return $permissionList;
        }

        $permissionList = [];
        $adminInfo = Db::name('system_admin')
            ->where([
                'id' => $this->adminId,
                'status' => 1,
            ])->find();
        $admin_groups = Db::name('system_group_admin')
            ->where([
                'admin_id' => $this->adminId,
            ])->column('group_id');
        if (!empty($adminInfo)) {
            $buildGroupSql = Db::name('system_group')
                ->distinct(true)
                ->whereIn('id', $admin_groups)
                ->field('id')
                ->buildSql(true);
            $buildGroupMenuSql = Db::name('system_group_menu')
                ->distinct(true)
                ->where("group_id IN {$buildGroupSql}")
                ->field('menu_id')
                ->buildSql(true);
            $permissionList = Db::name('system_menu')
                ->distinct(true)
                ->where("type", 3)
                ->where("id IN {$buildGroupMenuSql}")
                ->column('permission');
        }
        return $permissionList;
    }

    /**
     * 驼峰转下划线规则
     * @param string $node
     * @return string
     */
    public function parseNodeStr($node)
    {
        $array = explode('/', $node);
        foreach ($array as $key => $val) {
            if ($key == 0) {
                $val = explode('.', $val);
                foreach ($val as &$vo) {
                    $vo = humpToLine(lcfirst($vo));
                }
                $val = implode('.', $val);
                $array[$key] = $val;
            }
        }
        $node = implode('/', $array);
        return $node;
    }

}
