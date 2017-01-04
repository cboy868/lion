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


class Upload extends Component{

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

    /**
     * @name 上传实例
     */
    public $uploader;

    public $originName = 'origin';

    private static $_instance;  

    // public static function getInstance()    
    // {    
    //     if(! (self::$_instance instanceof self) ) {    
    //         self::$_instance = new self();    
    //     }

    //     return self::$_instance;    
    // }

    public static function getInstance($model, $fileName, $res="common")
    {
        $up = new self;
        $up->uploader = UploadedFile::getInstance($model, $fileName);

        if (!$up->uploader) {
            return false ;
        }

        $up->res = $res;
        $up->setPathName();
        return $up;
    }

    public static function getInstanceByName($name, $res='common')
    {
        $up = new self;
        $up->uploader = UploadedFile::getInstanceByName($name);
        $up->res = $res;
        $up->setPathName();
        return $up;
    }


    /**
     * @name 保存文件
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
        
        if ($this->uploader->saveAs($filePath) !== false) {
            
            $info = [
                'path' => $this->path,
                'fileName' => $this->fileName,
                'ext'  => $this->ext,
                'res' => $this->res,
                'title' => $this->title,
                'filePath' => $filePath,
                'use' => $this->use ? $this->use : null
            ];
            $event = new UploadEvent($info);


            $img_config = $this->getConfig();

            if (isset($img_config['water'])) {//水印
                if ($img_config['water_mod'] == 'image') {
                    $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'water'], null, false);
                } else {
                    $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'textWater'], null, false);
                }
                
            }

            $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
            

            $this->on(self::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);

            $this->trigger(self::EVENT_AFTER_UPLOAD, $event);
        }
    }


    private function getFilePath()
    {
        $fullname = $this->fullPath;
        $rootPath = $_SERVER['DOCUMENT_ROOT'];

        if (substr($fullname, 0, 1) != '/') {
            $fullname = '/' . $fullname;
        }

        return $rootPath . $fullname;
    }

   
    /**
     * @name 取配置 目前在config/params.php中
     */
    public function getConfig($field=null)
    {
        $params = Yii::$app->params['image'];

        $current_params = Yii::$app->controller->module->params['image'];

        $configs = ArrayHelper::merge($params, $current_params);

        $current_config = $configs[$this->res] ? $configs[$this->res] : [];
        $config = array_merge($current_config, $configs['common']);

        if ($field) {
            return $config[$field];
            // return isset($config[$field]) ? $config[$field] : Yii::$app->params['image']['common'][$field];
        } else {
            return $config;
        }
    }

    /**
     * @name 获取全路径文件名
     */
    private function setPathName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->getConfig('imagePathFormat');
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
    }


    /**
     * @name 判断图片是否过大
     */
    private function isTooBig()
    {
        $maxSize = $this->getConfig('imageMaxSize')? $this->getConfig('imageMaxSize') : 2048000;

        $this->size = $this->uploader->size;

        return  $this->uploader->size > $maxSize;
    }

    /**
     * @name 判断文件类型是否允许上传
     */
    private function notAllow()
    {
        $allowFiels = $this->getConfig('imageAllowFiles');

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
            'size' => $this->size
        ];

        return $info;
    }

} 