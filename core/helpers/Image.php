<?php

namespace app\core\helpers;

use Yii;
use Imagine\Image\ManipulatorInterface;
// use yii\helpers\ArrayHelper;

class Image extends \yii\imagine\Image {

    const THUMB_DIR = 'thumb';
    /**
     * @name 缩略
     * 这里文件稍大时，可能会内存超出，之后再解决
     */
    public static function thumb($event)
    {

        $filePath = $event->filePath;

        $dir = dirname($filePath);

        $thumb_dir = str_replace('upload/image', 'upload/image/' . self::THUMB_DIR, $dir);

        $basename = basename($filePath);

        if (!isset($event->res)) {
            return ;
        }

        $thumb = self::getConfig($event->res, 'thumb');
        if (!$thumb || !is_array($thumb)) {
            return ;
        }

        $thumb = array_filter($thumb);

        if (!is_dir($thumb_dir)) {
            @mkdir($thumb_dir, 0777, true) or die($thumb_dir . ' no permission to write');
        }

        if (!is_array($thumb)) {
            self::water($event->res, $filePath);
            return false;
        }
        
        foreach ($thumb as $k => $v) {
            $v = str_replace('X', 'x', $v);
            $v = str_replace('*', 'x', $v);
            $size = explode('x', $v);

            if (!is_numeric($size[0]) || !is_numeric($size[1])) {
                continue;
            }
            $thumb_path = $thumb_dir. '/' . $size[0] .'x'. $size[1] . '@' . $basename;
            // self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb_path);
            self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($thumb_path);

            self::water($event->res, $thumb_path);
        }

        self::water($event->res, $filePath);

//        self::water($event->res, $event->filePath);//ManipulatorInterface::THUMBNAIL_OUTBOUND 时使用

        return true;
    }


    public static function getConfig($res, $field=null)
    {
        $configs = Yii::$app->params['image'];

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


    public static function water($res, $filePath)
    {
        $img_config = Image::getConfig($res);

        if (isset($img_config['water']) && $img_config['water']) {//水印
            if (!isset($img_config['water_mod'])) return null;

            if ($img_config['water_mod'] == 'image') {
                self::waterImg($res, $filePath);
            } else {
                self::waterText($res, $filePath);
            }
        }
    }


    public static function waterImg($res, $filePath)
    {
        $config = self::getConfig($res);

        //水印
        if (!isset($config['water_image'])) {
            return;
        }

        $watermark = $config['water_image'];
        $watermark = Yii::getAlias('@app/web' . $watermark);
        if (!is_file($watermark)) {
            return ;
        }

        $info = self::getPos($res, $filePath);

        if (!$info) {
            return ;
        }
        self::watermark($filePath, $watermark, [$info['x'], $info['y']])->save($filePath);
        return true;
    }



    public static function waterText($res, $filePath)
    {
        $config = self::getConfig($res);

        //水印
        $watermark = $config['water_text'];
        if (!$watermark) {
            return ;
        }
        $fontFile = Yii::getAlias('@app/web/static/font/simsun.ttc');

        $info = self::getPos($res, $filePath);

        if (!$info) {
            return null;
        }

        self::text($filePath, $watermark, $fontFile,[$info['x'], $info['y']], ['size'=>$info['fontsize']])->save($filePath);

        return true;
    }



    public static function getPos($res, $filePath)
    {
        if (!is_file($filePath)) return null;

        $fileSize = getimagesize($filePath);
        $config = self::getConfig($res);
        $font_size = 40;

        if ($config['min_width'] > $fileSize[0] || $config['min_height'] > $fileSize[1]) {
            return null;
        }

        //水印
        $watermark = $config['water_text'];
        if (!$watermark) {
            return null;
        }

        if ($config['water_mod'] == 'text'){
            //水印文字
            $watermark = $config['water_text'];
            if (!$watermark) {
                return null;
            }

            $len = self::utf8_strlen($watermark) * $font_size;
            $tmp = $fileSize[0]*9/10;

            $waterSize[0] = $tmp > $len ? $len : $tmp;
            $waterSize[1] = $font_size = $waterSize[0] / self::utf8_strlen($watermark) /1.25;

        } else {
            //水印图片
            $watermark = $config['water_image'];
            if (!$watermark) {
                return null;
            }
            $watermark = Yii::getAlias('@app/web' . $watermark);
            $waterSize = getimagesize($watermark);

            if ($fileSize[0] <= $waterSize[0] || $fileSize[1] <= $waterSize[1]) {
                return false;
            }
        }

        //水印位置
        $pos = $config['water_pos'];

        if ($pos == 0) {
            $pos = rand(1,9);
        }

        $x = $y = 0;
        switch ($pos) {
            case 1:
            case 4:
            case 7:
                $x = 10;
                break;
            case 2:
            case 5:
            case 8:
                $x = ($fileSize[0] - $waterSize[0])/2;
                break;
            case 3:
            case 6:
            case 9:
                $x = $fileSize[0] - $waterSize[0]-10;
            default:
                # code...
                break;
        }

        switch ($pos) {
            case 1:
            case 2:
            case 3:
                $y = 10;
                break;
            case 4:
            case 5:
            case 6:
                $y = ($fileSize[1] - $waterSize[1])/2;
                break;
            case 7:
            case 8:
            case 9:
                $y = $fileSize[1] - $waterSize[1]-10;
            default:
                # code...
                break;
        }


        return [
            'x' => $x,
            'y' => $y,
            'fontsize' => $font_size
        ];
    }


    public static function utf8_strlen($string = null) {
         // 将字符串分解为单元
        preg_match_all("/./us", $string, $match);
         // 返回单元个数
        return count($match[0]);
    }

    public static function autoThumb($src, $thumb_path, $size, $res="common")
    {
        $filePath = $src;

        if (!is_dir(dirname($thumb_path))) {
            @mkdir(dirname($thumb_path), 0777, true) or die(dirname($thumb_path) . ' no permission to write');
        }

        self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($thumb_path);

        self::water($res, $thumb_path);//缩略完成后打水印

        return $thumb_path;
    }

}
