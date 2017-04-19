<?php

namespace app\core\helpers;

use Yii;
use Imagine\Image\ManipulatorInterface;
// use yii\helpers\ArrayHelper;

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

        $thumb = self::getConfig($event->res, 'thumb');
        $thumb = array_filter($thumb);

        if (!is_array($thumb)) {
            return false;
        }
        
        foreach ($thumb as $k => $v) {
            $v = str_replace('X', 'x', $v);
            $v = str_replace('*', 'x', $v);
            $size = explode('x', $v);

            if (!is_numeric($size[0]) || !is_numeric($size[1])) {
                continue;
            }
            $thumb_path = $dir. '/' . $size[0] .'x'. $size[1] . '@' . $basename;


            // self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb_path);
            self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($thumb_path);
        }

        self::water($event->res, $event->filePath);//ManipulatorInterface::THUMBNAIL_OUTBOUND 时使用 

        return true;
    }


    public static function getConfig($res, $field=null)
    {

        $configs = Yii::$app->params['image'];

        $current_config = isset($configs[$res]) ? $configs[$res] : [];

        $config = array_merge($configs['common'], $current_config);

        if ($field) {
            return $config[$field];
        } else {
            return $config;
        }
    }

    // /**
    //  * @图片水印
    //  */
    // public static function water($event)
    // {
    //     $filePath = $event->filePath;

    //     $config = self::getConfig($event->res);
    //     $watermark = $config['water_image'];
    //     $pos = $config['water_pos'];


    //     $watermark = Yii::getAlias('@app/web' . $watermark);

    //     if (!is_file($watermark)) {
    //         return ;
    //     }
    //     $start = self::getPos($filePath, $watermark, $pos);

    //     if (!$start) {
    //         return ;
    //     }

    //     $basename = basename($filePath);
    //     $dirname = dirname($filePath);

    //     $originPath = $dirname . '/' . 'ori_' . $basename;

    //     @copy($filePath, $originPath);
    //     self::watermark($filePath, $watermark, $start)->save($filePath);

    //     return true;
    // }



    // /**
    //  * @文字水印
    //  * 报错
    //  */
    // public static function textWater($event)
    // {
    //     $filePath = $event->filePath;

    //     $config = self::getConfig($event->res);
    //     $watermark = $config['water_text'];
    //     $pos = $config['water_pos'];

    //     if (!$watermark) {
    //         return ;
    //     }

    //     $font_size = 40;
    //     $start = self::getPos($filePath, $watermark, $pos, $font_size);
    //     if (!$start) {
    //         return ;
    //     }

    //     $originPath = dirname($filePath) . '/' . 'ori_' . basename($filePath);
    //     $fontFile = Yii::getAlias('@app/web/static/font/simsun.ttc');

    //     @copy($filePath, $originPath);
    //     self::text($filePath, $watermark, $fontFile,$start, ['size'=>$font_size])->save($filePath);

    //     return true;
    // }


    public static function water($res, $filePath)
    {
        $img_config = Image::getConfig($res);
        if (isset($img_config['water'])) {//水印
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

        //缩略
        $thumb =array_filter($config['thumb']);

        //水印
        $watermark = $config['water_image'];
        $watermark = Yii::getAlias('@app/web' . $watermark);
        if (!is_file($watermark)) {
            return ;
        }

        //水印位置
        $pos = $config['water_pos'];
        

        $dirname = dirname($filePath);
        $basename = basename($filePath);
        

        if (is_array($thumb)) {

            foreach ($thumb as $k => $v) {
                $v = str_replace('*', 'x', str_replace('X', 'x', $v));
                $size = explode('x', $v);

                if (!is_numeric($size[0]) || !is_numeric($size[1])) {
                    continue;
                }

                $thumb_path = $dirname. '/' . $size[0] .'x'. $size[1] . '@' . $basename;

                $start = self::getPos($thumb_path, $watermark, $pos);
                if (!$start) {
                    continue ;
                }

                self::watermark($thumb_path, $watermark, $start)->save($thumb_path);

            }
        }

        // $originPath = $dirname . '/' . 'ori_' . $basename;

        // @copy($filePath, $originPath);

        $start = self::getPos($filePath, $watermark, $pos);
        if (!$start) {
            return ;
        }

        self::watermark($filePath, $watermark, $start)->save($filePath);

        return true;
    }



    public static function waterText($res, $filePath)
    {

        $config = self::getConfig($res);

        //缩略
        $thumb =array_filter($config['thumb']);

        //水印
        $watermark = $config['water_text'];
        if (!$watermark) {
            return ;
        }

        //水印位置
        $pos = $config['water_pos'];
        $font_size = 40;
        


        $dirname = dirname($filePath);
        $basename = basename($filePath);


        $fontFile = Yii::getAlias('@app/web/static/font/simsun.ttc');

        if (is_array($thumb)) {

            foreach ($thumb as $k => $v) {
                $v = str_replace('*', 'x', str_replace('X', 'x', $v));
                $size = explode('x', $v);

                if (!is_numeric($size[0]) || !is_numeric($size[1])) {
                    continue;
                }

                $thumb_path = $dirname. '/' . $size[0] .'x'. $size[1] . '@' . $basename;
                $start = self::getPos($thumb_path, $watermark, $pos, $font_size);
                if (!$start) {
                    continue ;
                }
                self::text($thumb_path, $watermark, $fontFile,$start, ['size'=>$font_size])->save($thumb_path);

            }
        }

        $start = self::getPos($filePath, $watermark, $pos, $font_size);
        if (!$start) {
            return ;
        }

        $originPath = $dirname . '/' . 'ori_' . $basename;
        @copy($filePath, $originPath);
        self::text($filePath, $watermark, $fontFile,$start, ['size'=>$font_size])->save($filePath);

        return true;
    }

// $filePath = $event->filePath;

//         $config = self::getConfig($event->res);
//         $watermark = $config['water_text'];
//         $pos = $config['water_pos'];

//         if (!$watermark) {
//             return ;
//         }

//         $font_size = 40;
//         $start = self::getPos($filePath, $watermark, $pos, $font_size);
//         if (!$start) {
//             return ;
//         }

//         $originPath = dirname($filePath) . '/' . 'ori_' . basename($filePath);
//         $fontFile = Yii::getAlias('@app/web/static/font/simsun.ttc');

//         @copy($filePath, $originPath);
//         self::text($filePath, $watermark, $fontFile,$start, ['size'=>$font_size])->save($filePath);

//         return true;




    /**
     * @图片水印
     */
    // public static function water($event)
    // {
    //     $filePath = $event->filePath;


    //     $dirname = dirname($filePath);
    //     $basename = basename($filePath);


    //     $config = self::getConfig($event->res);
    //     $thumb =array_filter($config['thumb']);



    //     $watermark = $config['water_image'];
    //     $pos = $config['water_pos'];


    //     $watermark = Yii::getAlias('@app/web' . $watermark);

    //     if (!is_file($watermark)) {
    //         return ;
    //     }
    //     $start = self::getPos($filePath, $watermark, $pos);

    //     if (!$start) {
    //         return ;
    //     }


    //     if (is_array($thumb)) {


    //         foreach ($thumb as $k => $v) {
    //             $v = str_replace('X', 'x', $v);
    //             $size = explode('x', $v);

    //             if (!is_numeric($size[0]) || !is_numeric($size[1])) {
    //                 continue;
    //             }
    //             $thumb_path = $dirname. '/' . $size[0] .'x'. $size[1] . '@' . $basename;

    //             self::watermark($thumb_path, $watermark, $start)->save($filePath);

    //         }
    //     }

        

        

    //     $originPath = $dirname . '/' . 'ori_' . $basename;

    //     @copy($filePath, $originPath);
    //     self::watermark($filePath, $watermark, $start)->save($filePath);

    //     return true;
    // }



    /**
     * @文字水印
     * 报错
     */
    // public static function textWater($event)
    // {
    //     $filePath = $event->filePath;

    //     $config = self::getConfig($event->res);
    //     $watermark = $config['water_text'];
    //     $pos = $config['water_pos'];

    //     if (!$watermark) {
    //         return ;
    //     }

    //     $font_size = 40;
    //     $start = self::getPos($filePath, $watermark, $pos, $font_size);
    //     if (!$start) {
    //         return ;
    //     }

    //     $originPath = dirname($filePath) . '/' . 'ori_' . basename($filePath);
    //     $fontFile = Yii::getAlias('@app/web/static/font/simsun.ttc');

    //     @copy($filePath, $originPath);
    //     self::text($filePath, $watermark, $fontFile,$start, ['size'=>$font_size])->save($filePath);

    //     return true;
    // }


    public static function getPos($filePath, $water, $pos, $font_size = null)
    {
        $fileSize = getimagesize($filePath);

        if ($font_size == null) {
            $waterSize = getimagesize($water);
        } else {
            $waterSize[0] = self::utf8_strlen($water) * $font_size;
            $waterSize[1] = $font_size;
        }

        if ($fileSize[0] <= $waterSize[0] || $fileSize[1] <= $waterSize[1]) {
            return false;
        }


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

        return [$x, $y];
    }


    public static function utf8_strlen($string = null) {
         // 将字符串分解为单元
        preg_match_all("/./us", $string, $match);
         // 返回单元个数
        return count($match[0]);
    }

    public static function autoThumb($src, $thumb_path, $size)
    {
        $filePath = $src;

        $dir = dirname($filePath);
        $basename = basename($filePath);

        if (!is_dir(dirname($thumb_path))) {
            @mkdir(dirname($thumb_path), 0777, true) or die(dirname($thumb_path) . ' no permission to write');
        }
        
        // self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb_path);

        self::thumbnail($filePath, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($thumb_path);

        return $thumb_path;
    }

}
