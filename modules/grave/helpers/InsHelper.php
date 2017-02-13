<?php
/**
 * 
 * 此类用于生成对应数据、字体、长、宽属性的图片
 * =======================================================================
 * -------------------------------------------------------------------
 * 许可声明：无许可
 * =======================================================================
 * Author: wsq (cboy868@163.com)
 * Date: 2017-02-10  上午07:21:55
 */

namespace app\modules\grave\helpers;


class InsHelper
{
	//图像资源
    static $im;
    
    //图宽
    static $width;
    
    //图高
    static $height;
    
    //字体
    static $font;
       
    /**
     * 保存图片
     * Enter description here ...
     */
    static public function saveImg($file_path, $data, $width, $height, $font){
        self::$width = $width;
        self::$height = $height;
        self::$font = $font;
        
        self::createImg();
    	self::writeWord($data);
        
        $tmp_path = 'upload/ins/tmp.png'.microtime(true);
        $pos = strrpos($tmp_path, '/');
        $path = substr($tmp_path, 0, $pos+1);
        
        if (!is_dir($path)) {
            @mkdir($path, 777, true);
        }
        
    	header("Content-type: image/png");
        imagepng(self::$im, $tmp_path);
        imagedestroy(self::$im);
        
        $Image = new ImagesModel('ins');
        $info = $Image->setUserid()->upload($tmp_path,array('desc'=>'描述'),$file_path);
        
        unlink($tmp_path);//删除临时图片
        return $info;
    }
    
    /**
     * 做模板时，预览用的
     * @param unknown $data
     * @param unknown $width
     * @param unknown $height
     * @param unknown $font
     */
    static public function showImg($data, $width, $height, $font, $tmp_path="", $is_god=0){
    	
    	self::$width = $width;
    	self::$height = $height;
    	self::$font = $font;
    
    	self::createImg($is_god);
    	self::writeWord($data);

    	$tmp_path = empty($tmp_path) ? 'upload/ins/tmp.png':$tmp_path;
    	$pos = strrpos($tmp_path, '/');
    	$path = substr($tmp_path, 0, $pos+1);
    	
    	if (!is_dir($path)) {
    		@mkdir($path, 0777, true);
    	}
    	
    	header("Content-type: image/png");
    	imagepng(self::$im, $tmp_path);
    	imagedestroy(self::$im);
    }
    
    /**
     *
     * 在背景上写字
     * @param 背景的路径 $bg_path
     * @param 要打印到图片上的文字及格式等 $testarr
     * @param 字体路径 $font_path
     * @return 生成的图片资源 $bg_im
     */
    static private function writeWord($data) {
        foreach ($data as $v) {
        	if (empty($v['color'])){
        		$color_arr = array('22','22','22');
        	} else {
	        	$color_tmp = str_replace('#', '', $v['color']);
        		$color_arr = str_split($color_tmp, 2);
        	}
            if (isset($v['angle'])) {
                self::angle($v['x1'], $v['y1'], $v['x2'], $v['y2']);
                continue ;
            }

            $color = imagecolorallocate(self::$im, '0x'.$color_arr[0], '0x'.$color_arr[1], '0x'.$color_arr[2]);
            imagefttext (self::$im, $v[ 'size'], 0, $v[ 'x'], $v[ 'y'], $color, self::$font, $v['text']);

        }
    }

    static private function angle($start_x, $start_y, $end_x, $end_y)
    {
        imagesetthickness(self::$im , 3);
        $black = imagecolorallocate(self::$im, 50,50,50);
        imagerectangle(self::$im, $start_x, $start_y, $end_x, $end_y, $black);
    }

    /**
     * 
     * 生成基本的图片
     */
    static private function createImg($is_god){
        
        if (empty(self::$width) || empty(self::$height))
            throw new \Exception('生成图片缺少宽高参数');
        
        $im = imagecreatetruecolor(self::$width, self::$height)
            or die("Cannot Initialize new GD image stream");
        $color=imagecolorallocate($im,255,255,255);
        imagecolortransparent($im,$color);
        imagefill($im,0,0,$color);
        $border = imagecolorallocate($im, 200, 200, 200);
        self::borderImg($im, 10, 10, $border);
        self::$im = $im;
        self::god($is_god);

    }

    static private function god($is_god=0)
    {
        $god_pic = 'public/ins/img/s.gif';
        $new_im = imagecreatefromgif($god_pic);
        $god_img_info = getimagesize($god_pic);

        if (!$is_god) {
            return true;
        } else if ($is_god == 1) {
            $left = (self::$width-$god_img_info[0])/2;
            $top = $god_img_info[1]/2;
        } else if ($is_god == 2) {
            $left = $god_img_info[0]/2;
            $top = (self::$height-$god_img_info[1])/2;
        }

        imagecopy(self::$im ,$new_im ,$left ,$top ,0 ,0 ,$god_img_info[0] ,$god_img_info[1]);
    }
    
    /**
     * 
     * 按图片大小，生成边框
     * @param 图片资源 $im
     * @param 底边 $border_bottom
     * @param 右边 $border_right
     * @param 边框颜色 $border_color
     */
    static private function borderImg($im, $border_bottom,$border_right, $border_color){
        for($i=0; $i<$border_bottom; $i++){
            imageline($im, self::$width-$border_right+$i,$i, self::$width-$border_right+$i, self::$height+$i, $border_color);
            imageline($im, $i,self::$height-$border_bottom+$i, self::$width-$border_bottom+$i, self::$height-$border_bottom+$i, $border_color);
        }
        $white = imagecolorallocate($im, 246, 245, 225);//填充颜色，不可使用白色
        ImageFillToBorder ($im, 0, 0, $border_color, $white);
    }
}
