<?php

namespace app\core\helpers;

use Yii;
use Imagine\Image\ManipulatorInterface;

class Image extends \yii\imagine\Image {

    /**
     * @name 缩略
     * 这里文件稍大时，可能会内存超出，之后再解决
     */
    public static function thumb($event)
    {
        $filePath = $event->filePath;

        $dir = dirname($filePath);
        $basename = basename($filePath);

        if (!isset($event->res)) {
            return ;
        }


        $params = Yii::$app->params;
        $current_params = Yii::$app->controller->module->params;

        $params = ArrayHelper::merge($params, $current_params);


        if (!isset($params['image'][$event->res]['thumb'])) {
            return ;
        }

        $thumb = $params['image'][$event->res]['thumb'];

        foreach ($thumb as $k => $v) {
            $size = explode('*', $v);
            $thumb_path = $dir. '/' . $size[0] .'x'. $size[1] . '@' . $basename;
            // self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb_path);
            self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($thumb_path);
        }

        return true;
    }

    /**
     * @图片水印
     */
    public static function water($event)
    {
        $filePath = $event->filePath;

        $config = Yii::$app->params['image'];
        $watermark = isset($config[$event->res]['waterMark']) ? $config[$event->res]['waterMark'] : $config['common']['waterMark'];

        if (!is_file($watermark)) {
            return ;
        }

        $basename = basename($filePath);
        $dirname = dirname($filePath);

        $originPath = $dirname . '/' . 'ori_' . $basename;

        @copy($filePath, $originPath);
        self::watermark($filePath, $watermark)->save($filePath);

        return true;
    }

    /**
     * @文字水印
     * 报错
     */
    public static function textWater($event)
    {
        $fullPath = $event->fullPath;

        $config = Yii::$app->params['image'];
        $watermark = $config[$event->res]['textMark'] ? $config[$event->res]['textMark'] : $config['common']['textMark'];

        if (!$watermark) {
            return ;
        }
        $basename = basename($fullPath);
        $dirname = dirname($fullPath);

        $originPath = $dirname . '/' . 'ori_' . $basename;

        $fontFile = '@webroot/static/font/simsun.ttc';
        @copy($fullPath, $originPath);
        self::text($fullPath, $watermark, $fontFile)->save($fullPath);

        return true;
    }

    public static function autoThumb($src, $thumb_path, $size)
    {
        $filePath = $src;

        $dir = dirname($filePath);
        $basename = basename($filePath);

        if (!is_dir(dirname($thumb_path))) {
            @mkdir(dirname($thumb_path), 0777, true) or die(dirname($thumb_path) . ' no permission to write');
        }
        
        self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb_path);

        return $thumb_path;
    }

}
