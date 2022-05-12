<?php

namespace util;

use app\admin\model\SystemMenu;

class Menu
{
    /**
     * 默认生产的菜单放到
     */
    public static function getAddonParent()
    {
        /**
         * 获取插件一级菜单
         */
        $addonParent = SystemMenu::where('path', 'addons')
            ->where('type', 1)
            ->where('component', 'Layout')
            ->find();
        if (!$addonParent) {
            $addonParent = new SystemMenu();
            $addonParent->type = 1;
            $addonParent->pid = 0;
            $addonParent->title = "插件";
            $addonParent->icon = "zip";
            $addonParent->path = "addons";
            $addonParent->component = "Layout";
            $addonParent->status = 1;
            $addonParent->save();
        }
        return $addonParent;
    }
    /**
     * 创建菜单
     * @param array $menu
     * @param mixed $parent 父类的name或pid
     */
    public static function initMenu($menu = [])
    {
        /**
         * 获取插件一级菜单
         */
        $addonParent = self::getAddonParent();
        $pid = $addonParent['id'];
        $dataList = [];
        foreach ($menu as $v) {
            $firstMenu = new SystemMenu();
            $firstMenu->type = $v['type'];
            $firstMenu->pid = $pid;
            $firstMenu->title = $v['title'];
            $firstMenu->icon = $v['icon'];
            $firstMenu->path = $v['path'];
            $firstMenu->component = $v['component'];
            $firstMenu->status = 1;
            $firstMenu->save();
            foreach ($v['sublist'] as $val) {
                $data = $val;
                $data['pid'] = $firstMenu['id'];
                $data['create_time'] = time();
                $data['status'] = 1;
                $data['update_time'] = time();
                $dataList[] = $data;
            }
        }
        $menu_model = new SystemMenu();
        $menu_model->saveAll($dataList);
    }

    public static function deleteMenu($menu)
    {
        foreach ($menu as $v) {
            $firstMenu = SystemMenu::where('path', $v['path'])->where('component', $v['component'])->find();
            if ($firstMenu) {
                $firstMenu->delete();
                foreach ($v['sublist'] as $val) {
                    SystemMenu::where('pid', $firstMenu['id'])->where('permission', $val['permission'])->delete();
                }
            }
        }
    }

}
