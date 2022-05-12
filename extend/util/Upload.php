<?php
namespace util;

use addons\alioss\util\Alioss;
use addons\cos\util\Tencentcos;
use addons\qiniu\util\Qiniuoss;
use think\facade\Event;
use think\facade\Filesystem;

/**
 * 本地文件上传文件
 */
class Upload
{
    public $config = [];
    public function __construct()
    {
        $this->config = config('upload');
    }
    /**
     * 上传
     */
    public function upload($file)
    {
        $name = $file->getOriginalName();
        $format = strrchr($name, '.');
        $filePath = $file->getRealPath();
        $fileName = date("Y") . date("m") . date("d") . uniqid() . $format;
        $upload_config = sysconfig('upload');

        $upload_type = $upload_config['upload_type'] ? $upload_config['upload_type'] : 'local';
        $res = null;
        if ($upload_type == "local") {
            $res = $this->localUpload($file);
        } elseif ($upload_type == "alioss") {
            $res = Alioss::instance()->upload($fileName, $filePath);
        } elseif ($upload_type == "qiniu") {
            $res = Qiniuoss::instance()->upload($fileName, $filePath);
        } elseif ($upload_type == "cos") {
            $res = Tencentcos::instance()->upload($fileName, $filePath);
        }

        if ($res['url']) {
            Event::listen('uploadFile', "app\admin\listener\Files");
            Event::trigger('uploadFile', [
                'upload_type' => $upload_type,
                'original_name' => $file->getOriginalName(),
                'mime_type' => $file->getOriginalMime(),
                'file_ext' => strtolower($file->getOriginalExtension()),
                'url' => $res['url'],
                'sha1' => $file->hash(),
                'file_size' => $file->getSize(),
            ]);
        }
        return $res;
    }
    /**
     * 本地文件
     */
    public function localUpload($file, $filename = "system")
    {
        try {
            $savename = Filesystem::disk('public')->putFile($filename, $file);

            $upload_config = sysconfig('upload');
            $domain = isset($upload_config['upload_url']) ? $upload_config['upload_url'] : '';
            if (!$domain) {
                return ['msg' => '请到后台配置管理-系统管理-上传配置中配置：本地图片路径', 'url' => ""];
            }
            $savepath = "/storage/";
            $url = $domain . $savepath . str_replace(DIRECTORY_SEPARATOR, '/', $savename);
            return ['msg' => '上传成功', 'url' => $url];
        } catch (\Exception $e) {
            return ['msg' => '上传失败', 'url' => ""];
        }

    }
}
