<?php
/**
 * 
 * ibagou.com
 * ============================================================================
 * 版权所有: ibagou.com
 * 网站地址: http://www.ibagou.com/
 * ----------------------------------------------------------------------------
 * ============================================================================
 * Author: wsq(wansq@ylwkj.com)
 * Date: 14-11-27 下午9:10
 */

namespace app\core\base;

use Yii;
use yii\web\UploadedFile;
use yii\base\Component;
use app\core\helpers\ArrayHelper;
use app\core\helpers\Image;


class VideoUpload extends Component{

    const EVENT_AFTER_UPLOAD = 'afterUpload';

    /**
     * @name 上传类型
     */
    public $res;

    public $fullPath;

    public $path;

    public $fileName;

    public $originPath;

    public $ext;

    public $title;

    public $mid; //图片存在数据库中的id

    public $size;

    public $use;

    public $res_id;

    public $backPath;//图片的备份目录

    /**
     * @name 上传实例
     */
    public $uploader;

    public $originName = 'origin';

    private static $_instance;  


    public static function getInstance($model, $fileName, $res="common", $res_id=null)
    {
        $up = new self;
        $up->uploader = UploadedFile::getInstance($model, $fileName);

        if (!$up->uploader) {
            return false ;
        }

        $up->res = $res;
        $up->res_id = $res_id;
        $up->setPathName();
        return $up;
    }

    public static function getInstanceByName($name, $res='common', $res_id=null)
    {
        $up = new self;
        $up->uploader = UploadedFile::getInstanceByName($name);
        if (!$up->uploader) {
            return false ;
        }
        $up->res = $res;
        $up->res_id = $res_id;
        $up->setPathName();
        return $up;
    }

    public static function getFileInstanceByName($name, $res='common', $res_id=null)
    {
        $up = new self;
        $up->uploader = UploadedFile::getInstanceByName($name);
        if (!$up->uploader) {
            return false ;
        }
        $up->res = $res;
        $up->res_id = $res_id;
        $up->setFilePathName();
        return $up;
    }






    /**
     * @name 保存文件
     */
    // public function save()
    // {

    //     if (!$this->uploader) {
    //         return ;//没有上传文件
    //     }

    //     if ($this->isTooBig()) {
    //         die('img is to big');
    //     }

    //     if ($this->notAllow()) {
    //         die('file not allowed');
    //     }

    //     $filePath = $this->getFilePath();

    //     if (!is_dir(dirname($filePath))) {
    //         @mkdir(dirname($filePath), 0777, true) or die(dirname($filePath) . ' no permission to write');
    //     }
        
    //     if ($this->uploader->saveAs($filePath) !== false) {
            
    //         $info = [
    //             'path' => $this->path,
    //             'fileName' => $this->fileName,
    //             'ext'  => $this->ext,
    //             'res' => $this->res,
    //             'title' => $this->title,
    //             'filePath' => $filePath,
    //             'use' => $this->use ? $this->use : null
    //         ];


    //         $event = new UploadEvent($info);

    //         // $img_config = $this->getConfig();
    //         $img_config = Image::getConfig($this->res);

    //         if (isset($img_config['water'])) {//水印
    //             if ($img_config['water_mod'] == 'image') {
    //                 $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'water'], null, false);
    //             } else {
    //                 $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'textWater'], null, false);
    //             }
    //         }

    //         $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
            
    //         // $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);

    //         $this->trigger(self::EVENT_AFTER_UPLOAD, $event);
    //     }
    // }

    /**
     * @name 保存图片之外的其它文件
     */
    public function saveFile()
    {
        if (!$this->uploader) {
            return ;//没有上传文件
        }

//        $filePath = '@app/web' . '/upload/file/'.date('Y')  . date('m') . '/' .$this->fileName;
//        $filePath = Yii::getAlias($filePath);

        $filePath = $this->getFilePath();

        if (!is_dir(dirname($filePath))) {
            @mkdir(dirname($filePath), 0777, true) or die(dirname($filePath) . ' no permission to write');
        }

        if ($this->uploader->saveAs($filePath, false) !== false) {

            $info = [
                'path' => $this->path,
                'fileName' => $this->fileName,
                'ext'  => $this->ext,
                'res' => $this->res,
                'title' => $this->title,
                'filePath' => $filePath,
                'use' => $this->use ? $this->use : null,
                'res_id' => $this->res_id ? $this->res_id : null
            ];

        }

    }

    /**
     * @name 保存图片，新改的,为每张缩略图加水印
     */
    public function save()
    {
        if (!$this->uploader) {
            return ;//没有上传文件
        }

        if ($this->isTooBig()) {
            die('img is to big');
        }

        if ($this->notAllow()) {
            die('file not allowed');
        }

        $filePath = $this->getFilePath();

        if (!is_dir(dirname($filePath))) {
            @mkdir(dirname($filePath), 0777, true) or die(dirname($filePath) . ' no permission to write');
        }
        
        if ($this->uploader->saveAs($filePath, false) !== false) {
            
            $info = [
                'path' => $this->path,
                'fileName' => $this->fileName,
                'ext'  => $this->ext,
                'res' => $this->res,
                'title' => $this->title,
                'filePath' => $filePath,
                'use' => $this->use ? $this->use : null,
                'res_id' => $this->res_id ? $this->res_id : null
            ];


            $event = new UploadEvent($info);
            // $img_config = Image::getConfig($this->res);


            $backPath = $this->getBackPath();

            if (!is_dir(dirname($backPath))) {
                @mkdir(dirname($backPath), 0777, true) or die(dirname($backPath) . ' no permission to write');
            }
            $this->uploader->saveAs($backPath, true);


            if (self::isImage($filePath)) {
                $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb'], null, false);
            }

            $this->trigger(self::EVENT_AFTER_UPLOAD, $event);


            

            //原图copy到其它位置
            // $ori_arr = explode('/', $filePath, 2);
            // p($ori_arr);die;
        }
    }

    public static function upload($tmp_name, $path, $res="common", $res_id=null) 
    {
        $up = new self;

        $up->res = $res;
        $up->res_id = $res_id;

        if(!is_file($tmp_name)) {
            echo '临时文件不存在';
            return false;
        }

        $info = self::getImageInfo($tmp_name);
        $type = isset($info['type']) ? $info['type'] : '';
        $up->path = dirname($path);
        $up->fileName = basename($path);
        $up->ext = $info['type'];
        $up->title = basename($path);
        $up->size = $info['size'];


        if(empty($type)) {
            $up->error = '不能识别图片的类型';
            return false;
        }

        $filePath = \Yii::getAlias('@app/web' . $path);

        // 移动目录
        if (!is_dir(dirname($filePath))) {
            @mkdir(dirname($filePath), 0777, true) or die(dirname($filePath) . ' no permission to write');
        }

        @copy($tmp_name, $filePath);

        $info = [
            'path' => $up->path,
            'fileName' => $up->fileName,
            'ext'  => $up->ext,
            'res' => $up->res,
            'title' => $up->title,
            'filePath' => $path,
            'use' => $up->use ? $up->use : null,
            'res_id' => $up->res_id ? $up->res_id : null
        ];


        $event = new UploadEvent($info);

        $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
        $up->trigger(self::EVENT_AFTER_UPLOAD, $event);

        return $up->getInfo();
    }


    public static function base64($base64, $path, $res="common", $res_id=null)
    {
        $base64_body = substr(strstr($base64,','),1);
        $img= base64_decode($base64_body );

        $up = new self;

        $up->res = $res;
        $up->res_id = $res_id;



        $up->path = dirname($path);
        $up->fileName = basename($path);
        $up->ext = 'png';
        $up->title = basename($path);
        $up->size = strlen($img)/1024;



        $filePath = \Yii::getAlias('@app/web' . $path);

        // 目录
        if (!is_dir(dirname($filePath))) {
            @mkdir(dirname($filePath), 0777, true) or die(dirname($filePath) . ' no permission to write');
        }

        file_put_contents($filePath, $img);


        $info = [
            'path' => $up->path,
            'fileName' => $up->fileName,
            'ext'  => $up->ext,
            'res' => $up->res,
            'title' => $up->title,
            'filePath' => $path,
            'use' => $up->use ? $up->use : null,
            'res_id' => $up->res_id ? $up->res_id : null
        ];


        $event = new UploadEvent($info);

        $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
        $up->trigger(self::EVENT_AFTER_UPLOAD, $event);

        return $up->getInfo();

    }

    protected static function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime']
            );
            return $info;
        } else {
            return false;
        }
    }


    private function getFilePath()
    {
        return Yii::getAlias('@app/web' . $this->fullPath);
    }

    private function getBackPath()
    {
        return Yii::getAlias('@app/web' . $this->backPath);
    }


    /**
     * @name 获取全路径文件名
     */
    private function setPathName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = self::getConfig('videoPathFormat');
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getExtension();
        $format = '/' . ltrim($format, '/');

        $this->ext = $ext;
        $this->path = dirname($format);
        $this->fileName = basename($format).'.'.$ext;
        $this->fullPath = $this->path .'/'. $this->fileName;
        $this->originPath = $this->path . '/' . $this->originName . '_' .$this->fileName;
        $this->title = $this->uploader->name;



        $base_arr = explode('/', $format, 3);
        $this->backPath = dirname('/' . $base_arr[1] . '/ori/' . $base_arr[2]). '/' . $this->fileName;
    }


    private function setFilePathName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = self::getFileConfig($this->res,'filePathFormat');
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = basename($this->uploader->name);
        $ext = substr($ext, strrpos($ext, '.'));

        $format = '/' . ltrim($format, '/');

        $this->ext = $ext;
        $this->path = dirname($format);
        $this->fileName = basename($format).$ext;
        $this->fullPath = $this->path .'/'. $this->fileName;
        $this->originPath = $this->path . '/' . $this->originName . '_' .$this->fileName;
        $this->title = $this->uploader->name;
    }

    public static function getFileConfig($res, $field=null)
    {
        $configs = Yii::$app->params['file'];

        $current_config = isset($configs[$res]) ? $configs[$res] : [];

        $config = array_merge($configs['common'], $current_config);

        if ($field) {
            if (!isset($config[$field])) {
                return false;
            }
            return $config[$field];
        } else {
            return $config;
        }
    }



    public static function getConfig($field=null)
    {
        $config = Yii::$app->params['video'];

        if ($field) {
            if (!isset($config[$field])) {
                return false;
            }
            return $config[$field];
        } else {
            return $config;
        }
    }

    /**
     * @name 判断图片是否过大
     */
    private function isTooBig()
    {
        // $maxSize = $this->getConfig('imageMaxSize')? $this->getConfig('imageMaxSize') : 2048000;

        $maxSize = self::getConfig('videoMaxSize');

        $this->size = $this->uploader->size;

        return  $this->uploader->size > $maxSize;
    }

    /**
     * @name 判断文件类型是否允许上传
     */
    private function notAllow()
    {
        // $allowFiels = $this->getConfig('imageAllowFiles');
        $allowFiels = self::getConfig('videoAllowFiles');

        $ext = $this->getExtension();

        return ! in_array('.' . $ext, $allowFiels);
    }

    private function getExtension()
    {
        return basename($this->uploader->type);
    }

    public function getInfo()
    {

        $info = [
            'path' => $this->path,
            'fileName' => $this->fileName,
            'ext'  => $this->ext,
            'res' => $this->res,
            'title' => $this->title,
            'mid' => $this->mid,
            'size' => $this->size,
            'res_id' => $this->res_id,
            'use' => $this->use
        ];

        return $info;
    }

    public static function isImage($filename) {
        $types = '.gif|.jpeg|.png|.bmp';
        //定义检查的图片类型
        if(file_exists($filename)) {
            $info = getimagesize($filename);
            $ext = image_type_to_extension($info['2']);
            return stripos($types,$ext);
        } else {
            return false;
        }
    }

} 