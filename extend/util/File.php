<?php
// +----------------------------------------------------------------------
// | OneKeyAdmin [ Believe that you can do better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://onekeyadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: MUKE <513038996@qq.com>
// +----------------------------------------------------------------------
namespace util;

use ZipArchive;

/**
 * 文件组件
 */
class File
{
    /**
     * 创建文件
     * @param  string  $file 文件
     * @return bool
     */
    public static function create(string $file, $txt = ""): bool
    {
        $path = dirname($file);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $fopen = fopen($file, "w") or die('无法打开文件');
        if (!empty($txt)) {
            fwrite($fopen, $txt);
        }
        fclose($fopen);
        return true;
    }

    /**
     * 创建文件夹
     *
     * @param string $path 文件夹路径
     * @param int $mode 访问权限
     * @param bool $recursive 是否递归创建
     * @return bool
     */
    public static function dirMkdir($path = '', $mode = 0777, $recursive = true): bool
    {
        clearstatcache();
        if (!is_dir($path)) {
            mkdir($path, $mode, $recursive);
            return chmod($path, $mode);
        }
        return true;
    }

    /**
     * 文件存储类型
     * @param  array    $ext  文件后缀配置
     * @param  string   $name 文件名称
     * @return string
     */
    public static function getType(array $ext, string $name): string
    {
        $type = '';
        $suffix = pathinfo($name)['extension'];
        foreach ($ext as $key => $val) {
            if (strstr($val, $suffix)) {
                $type = $key;
            }

        }
        return $type;
    }

    /**
     * 文件大小,以GB、MB、KB、B输出
     * @param  int  $size  文件大小
     * @return string
     */
    public static function formatBytes(int $size): string
    {
        $units = [' B', ' KB', ' MB', ' GB', ' TB'];
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . $units[$i];
    }

    /**
     * 文件夹文件拷贝
     *
     * @param string $src 来源文件夹
     * @param string $dst 目的地文件夹
     * @return bool  返回状态
     */
    public static function dirCopy($src = '', $dst = ''): bool
    {
        if (empty($src) || empty($dst)) {
            return false;
        }

        $dir = opendir($src);
        self::dirMkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::dirCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        return true;
    }

    /**
     * 获取目录下所有文件
     * @param  string     $path  目录
     * @return array
     */
    public static function getDir(string $path, &$files = []): array
    {
        if (is_dir($path)) {
            $opendir = opendir($path);
            while ($file = readdir($opendir)) {
                if ($file != '.' && $file != '..') {
                    self::getDir($path . '/' . $file, $files);
                }
            }
            closedir($opendir);
        }
        if (!is_dir($path)) {
            $files[] = $path;
        }
        return $files;
    }

    /**
     * 删除目录及目录下所有文件或删除指定文件
     * @param str $path   待删除目录路径
     * @param int $delDir 是否删除目录
     * @return bool 返回删除状态
     */
    public static function delDirAndFile($path, $delDir = true): bool
    {
        if (is_dir($path)) {
            $handle = opendir($path);
            if ($handle) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != "." && $item != "..") {
                        is_dir("$path/$item") ? self::delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
                    }
                }
                closedir($handle);
                if ($delDir) {
                    return rmdir($path);
                }

            } else {
                if (file_exists($path)) {
                    return unlink($path);
                } else {
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    /**
     * 提取文件
     * @param  string  $zip  压缩包
     * @param  string  $to   路径
     * @param  array   $jump 跳过那些目录
     * @return bool
     */
    public static function extract(string $zip, string $to, array $jump = []): bool
    {
        // 执行解压
        if (is_file($zip)) {
            $zipArchive = new ZipArchive;
            if ($zipArchive->open($zip) === true) {
                for ($i = 0; $i < $zipArchive->numFiles; $i++) {
                    $entryInfo = $zipArchive->statIndex($i);
                    foreach ($jump as $k => $v) {
                        if (strpos($entryInfo["name"], $v) === 0) {
                            $zipArchive->deleteIndex($i);
                        }
                    }
                }
                $zipArchive->close();
                if ($zipArchive->open($zip) === true) {
                    $zipArchive->extractTo($to);
                    $zipArchive->close();
                    unlink($zip);
                } else {
                    return false;
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 修改系统config文件
     * @param $pat  配置前缀 $pat[0] = 参数前缀;
     * @param $rep  数据变量 $rep[0] = 要替换的内容;
     * @param $file 数据变量 $file 文件名;
     * @return bool 返回状态
     */
    public static function editConfig(array $pat, array $rep, string $file): bool
    {
        if (is_array($pat) and is_array($rep)) {
            for ($i = 0; $i < count($pat); $i++) {
                $pats[$i] = '/\'' . $pat[$i] . '\'(.*?),/';
                $reps[$i] = "'" . $pat[$i] . "'" . " => " . "'" . $rep[$i] . "',";
            }
            $string = file_get_contents($file);
            $string = preg_replace($pats, $reps, $string);
            file_put_contents($file, $string);
            return true;
        } else {
            return false;
        }
    }
}
