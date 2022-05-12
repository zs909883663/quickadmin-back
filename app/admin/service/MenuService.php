<?php

namespace app\admin\service;

use think\facade\Db;

class MenuService
{

    /**
     * 管理员ID
     * @var integer
     */
    protected $adminId;

    protected $config = [];

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
        $this->config = config('auth');
        return $this;
    }

    /**
     * 获取后台菜单树信息
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMenuTree()
    {
        $menuTreeList = $this->buildMenuTree(0, $this->geteMenuDataByAdmin($this->adminId));
        return $menuTreeList;
    }

    /**
     * 获取所有菜单数据
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function getMenuData()
    {
        $menuData = Db::name('system_menu')
            ->field('id,path,component,pid,title,icon,type,tag_type,tag_value')
            ->where([
                ['status', '=', '1'],
                ['type', '<>', 3],
            ])
            ->order([
                'weigh' => 'desc',
                'id' => 'asc',
            ])
            ->select();
        return $menuData;
    }
    /**
     * 获取管理员菜单列表
     */
    protected function geteMenuDataByAdmin($adminId)
    {
        $admin_groups = Db::name('system_group_admin')
            ->where([
                'admin_id' => $this->adminId,
            ])->column('group_id');
        //超级管理员
        if (in_array($this->config['super_admin_group_id'], $admin_groups) || $this->config['auth_on'] == false) {
            return $this->getMenuData();
        }

        // 用户验证
        $adminInfo = Db::name('system_admin')
            ->where('id', $adminId)
            ->find();
        if (empty($adminInfo) || $adminInfo['status'] != 1) {
            return [];
        }

        $group_menu = Db::name('system_group_menu')
            ->where('group_id', 'in', $admin_groups)
            ->field(['menu_id'])
            ->select();
        $group_menus = [];
        foreach ($group_menu as $v) {
            array_push($group_menus, $v['menu_id']);
        }
        $menuList = Db::name('system_menu')
            ->where('status', 1)
            ->where('id', 'in', $group_menus)
            ->select();
        return $menuList;
    }
    /**
     *权限菜单
     */
    protected function buildMenuTree($pid, $menuList)
    {
        $treeList = [];
        foreach ($menuList as &$v) {
            if ($pid == $v['pid']) {
                $menu = $v;
                if ($menu['pid'] == 0 && !(preg_match('/(http:\/\/)|(https:\/\/)/i', $menu['path']))) {
                    $s = substr($menu['path'], 0, 1);
                    if ($s != "/") {
                        $menu['path'] = "/" . $menu['path'];

                    } else {}
                    $menu['alwaysShow'] = true;
                }
                unset($menu['id']);
                unset($menu['pid']);
                if ($v['type'] == 1) {
                    $menu['redirect'] = "noRedirect";
                }
                $meta['title'] = $menu['title'];
                $meta['icon'] = $menu['icon'];
                if ($menu['tag_type'] && $menu['tag_value']) {
                    $meta['tag'] = ['value' => $menu['tag_value'], 'type' => $menu['tag_type']];
                }
                $menu['name'] = $this->upperString($menu['path']);
                $menu['meta'] = $meta;
                unset($meta);
                unset($menu['title']);
                unset($menu['icon']);
                unset($menu['tag_type']);
                unset($menu['tag_value']);
                $child = $this->buildMenuTree($v['id'], $menuList);
                if (!empty($child)) {
                    $menu['children'] = $child;
                    $menu['redirect'] = $child[0]['path'];
                }
                if (($v['type'] == 2 && $v['pid'] == 0) || ($v['type'] == 1 && (preg_match('/(http:\/\/)|(https:\/\/)/i', $menu['path'])))) {
                    unset($menu['alwaysShow']);

                    $child = $menu;
                    if ($v['type'] == 2) {
                        $child['path'] = str_replace("/", "", $child['path']);
                    }

                    $menu['children'][0] = $child;
                    $menu['alwaysShow'] = false;
                    $menu['path'] = $menu['path'] . "_1";
                    $menu['component'] = "Layout";
                    $menu['type'] = 1;
                    $menu['name'] = $child['name'] . "_1";
                }
                if (!empty($v['component']) || !empty($child)) {
                    $treeList[] = $menu;
                }
            }
        }
        return $treeList;
    }

    /**
     * 获取角色组授权的菜单，权限
     */
    public function getAuthMenuData($group_id)
    {

        $buildGroupMenuSql = Db::name('system_group_menu')
            ->where('group_id', $group_id)
            ->field(['id' => 'gmid', 'menu_id'])
            ->buildSql(true);

        $menuList = Db::name('system_menu')
            ->alias('sm')
            ->join([$buildGroupMenuSql => 'sgm'], 'sm.id=sgm.menu_id', 'left')
            ->where('sm.status', 1)
            ->select();

        $nodeList = [];
        foreach ($menuList as $k => $v) {
            $node = $v;
            unset($node['gmid']);
            unset($node['menu_id']);
            $node['checked'] = !empty($v['gmid']);
            $nodeList[] = $node;
        }
        return $nodeList;
    }

    private function upperString($name)
    {
        $firstName = "";
        $arr = explode("/", $name);
        if (count($arr) > 1) {
            $firstName = $arr[1];
        } else {
            $firstName = $name;
        }
        return ucwords($firstName);
    }

}
