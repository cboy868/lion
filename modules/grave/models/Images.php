<?php

namespace app\modules\grave\models;

use Yii;


/**
 * 图片管理模型
 * 
 */
class Images {

    // 错误提示信息
    protected $error;

    // 图片类型
    protected $type = array('jpeg','jpg','gif','png',);

    // 所略尺寸
    protected $thunder_size;

    // 图片保存根地址
    protected $base_path;

    // 图片的用途
    protected $img_use;

    // 当前登录的用户ID
    protected $userid;

    protected $default_spec = 'original';

    public function __construct(string $img_use) 
    {
        // 根据类别设置表名 modify by bandry
        if (!empty($img_use)) {
            $this->tableName = 'images_' . $img_use;
        }
        parent::__construct();
        // 图片的类别
        $this->img_use = empty($img_use) ? 'default' : $img_use;
        
        // 图片上传的基本路径
        $base_path = 'upload';
        $this->base_path = empty($base_path) ? 'upload/'.$this->img_use : $base_path.'/'.$this->img_use;
        // 缩略图尺寸
        // $thunder_conf = C('IMAGE_THUMB_SIZE');
        // $this->thunder_size = isset($thunder_conf[$this->img_use]) ? $thunder_conf[$this->img_use] : array();


        $this->thunder_size = [];

        // 当前登录的用户ID
        $this->userid = Yii::$app->user->id;
    }

    /**
     * 设置所略尺寸
     *
     * @param void
     * @return void
     */
    public function setThunderSize($width,$height,$spec='default') 
    {
        if(empty($spec) || !is_string($spec)) {
            $spec = 'default';
        }
        if(empty($width) || empty($height)) {
            return $this;
        }
        $this->thunder_size[$spec] = $width.'x'.$height;
        return $this;
    }

    /**
     * 设置对象ID 实际保存的字段是 owner_id
     * @param void
     * @return void
     */
    public function setUserid($userid = 0) 
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * 获取满足条件的图片记录列表
     * @return void
     * @author sunbingchao
     */
    public function getList($condition = null,$offset=0,$length=100,$field='') {

        $list = $this->where($condition)
                     ->limit($offset.','.$length)
                     ->order('sort asc')
                     ->select();
        if($list === false) {
            $this->error = $this->getDbError();
            return false;
        }

        if(!empty($list) && !empty($field)) {
            $data = array();
            foreach($list as $value) {
                $data[] = isset($value[$field]) ? $value[$field] : '';
            }
            $list = $data;
        }

        return $list;
    }

    /**
     * 获取一条图片记录
     *
     * @return void
     * @author sunbingchao
     */
    public function getOne($condition,$order = 'sort desc') 
    {
        if(is_int($condition)) {
            $condition = 'id='.$id;
        }
        $info = $this->where($condition)->order($order)->find();
        if(!empty($info) && !empty($field)) {
            $info = isset($info[$field]) ? $info[$field] : '';
        }
        return $info;
    }

    /**
     * 获取满足条件的图片总数
     *
     * @return void
     * @author sunbingchao
     */
    public function getCount($condition) 
    {
        return $this->where($condition)->field('id')->count();
    }

    /**
     * 上传图片
     * @param string $save_name
     * @param string $tmp_name
     * @param string $type
     * @return int $id
     */
    public function upload($tmp_name,$data = array(), $path='') 
    {
    	if(empty($this->img_use)) {
            $this->error = '图片的用途未知';
            return false;
        }
        
        if(!is_file($tmp_name)) {
            $this->error = '临时文件不存在';
            return false;
        }
        $info = $this->getImageInfo($tmp_name);
        $type = isset($info['type']) ? $info['type'] : '';
        if(empty($type)) {
            $this->error = '不能识别图片的类型';
            return false;
        }
     
        $content = file_get_contents($tmp_name);
        // 保存到本地
         $info = $this->binary($content,$type, $path);
        if($info == false) return false;
        unset($binary);
        // 保存到数据库
        $result = $this->saveImage(array_merge($info,$data));
        if($result === false) {
            return false;
        };
        // 返回数据
        return $result;
    }

    /**
     * 通过网络url地址获取图片
     * @param string $save_name
     * @param string $url
     * @param string $type
     * @return int $id
     */
    public function fetch($url,$data = array()) 
    {
        if(empty($this->img_use)) {
            $this->error = '图片的用途未知';
            return false;
        }
        $binary = $this->curl_image($url);
        if($binary === false) return false;
        $info = $this->getImageInfo($url);
        $type = isset($info['type']) ? $info['type'] : '';
        if(empty($type)) {
            $this->error = '不能识别图片的类型';
            return false;
        }
        $info = $this->binary($binary,$type);
        if($info == false) return false;
        unset($binary);
        $result = $this->saveImage(array_merge($info,$data));
        if($result === false) {
            return false;
        };
        return $result;
    }

    /**
     * 修改图片信息
     */
    public function updateImage($id,$data) 
    {
        if(empty($id)) {
            $this->error = '要修改的图片ID为空';
            return false;
        }

        $attrs = array('title', 'desc', 'sort', 'status'); 
        $info = array();
        foreach($attrs as $attr) {
            if (isset($data[$attr])) {
                $info[$attr] = $data[$attr];
            }
        }

      	$info['owner_id'] = $this->userid;

        if(empty($info)) {
            $this->error = '没有要修改的内容';
            return false;
        }

        if(($result = $this->where('id='.$id)->save($info)) !== false) {
            return $result;
        }else {
            $this->error = $this->getDbError();
            return false;
        }
    }

    /**
     * 删除图片
     *
     * @return void
     * @author sunbingchao
     */
    public function deleteImage($id) 
    {
        return $this->updateImage($id,array('status'=>0));
    }

    /**
     * 二进制图片的处理 (sb)
     */
    protected function binary($binary,$type, $path="") 
    {
        // 安全性验证
        if(empty($binary)) {
            $this->error = '图片不存在';
            return false;
        }
        if(empty($this->type)) {
            $this->error = '图片分类为空';
            return false;
        }
        if(empty($type) || !in_array($type,$this->type)) {
            $this->error = '图片扩展名非法';
            return false;
        }
        // 获取原始图片保存地址 基础地址 + 分类 + 规格 + 文件路径
        
        if (!empty($path)) {
            $pos = strrpos($path, '/');
            $file_path = substr($path, 0, $pos+1);
            $name = substr($path, $pos+1);
            $md5 = md5($binary);
        } else {
            $md5 = md5($binary);
            $name = substr($md5,7,32);
            $file_path = substr($md5,0,2).'/'.substr($md5,2,2).'/'.substr($md5,4,3).'/';
        }
        
        $save_path = $this->base_path.'/'.$this->default_spec.'/'.$file_path;
        if((is_dir($save_path) === false) && $this->mkdir($save_path)) {
            return false;
        }

        $save_name = $save_path.$name.'.'.$type;
        // 保存图片
        $result = file_put_contents($save_name,$binary);
        if($result === false) {
            $this->error = sprintf('图片保存失败 检查根文件路径问题 %s 或权限不够', $save_name);
            return false;
        }
        // 生成缩略图
        // if(!empty($this->thunder_size)) {
        //     foreach($this->thunder_size as $k=>$v) {
        //         $save_path = $this->base_path.'/'.$k.'/'.$file_path;
        //         if((is_dir($save_path) === false) && $this->mkdir($save_path)) {
        //             $this->error = '保存缩略图的文件夹'.$save_path.'不存在';
        //             return false;
        //         }
        //         list($maxWidth,$maxHeight) = explode('x',$v);
        //         $result = $this->thumb($save_name,$save_path.$name.'.png',$maxWidth, $maxHeight);
        //         if($result === false) {
        //             $this->error = '生成缩略图失败';
        //             return false;
        //         }
        //     }

        // }

        // 返回图片信息
        return array(
            'path'  =>  $file_path,
            'name'  =>  $name,
            'md5'   =>  $md5,
            'type'   =>  $type
        );
    }

    /**
     * 保存图片
     *
     * @return void
     * @author sunbingchao
     */
    protected function saveImage($data) {
        $path = isset($data['path']) ? trim($data['path']) : '';
        if(empty($path)) {
            $this->error = '图片的路径为空';
            return false;
        }
        $name = isset($data['name']) ? trim($data['name']) : '';
        if(empty($name)) {
            $this->error = '图片的名称为空';
            return false;
        }
        $md5 = isset($data['md5']) ? trim($data['md5']) : '';
        if(empty($md5)) {
            $this->error = '图片的md5未知';
            return false;
        }
        $type = isset($data['type']) ? trim($data['type']) : '';
        if(empty($type)) {
            $this->error = '图片的扩展名未知';
            return false;
        }

        $title = isset($data['title']) ? trim($data['title']) : '';
        $desc = isset($data['desc']) ? trim($data['desc']) : '';
        $title = isset($data['title']) ? trim($data['title']) : '';
        $sort = isset($data['sort']) ? intval($data['sort']) : 0;
        $data = array(
            'title'     =>  $title,
            'desc'      =>  $desc,
            'owner_id'  =>  $this->userid,
            'path'      =>  $path,
            'img_use'   =>  $this->img_use,
            'name'      =>  $name,
            'sort'      =>  $sort,
            'add_time'  =>  date('Y-m-d H:i:s',time()),
            'status'    =>  1,
            'md5'       =>  $md5,
            'ext'       =>  $type
        );
        $result = $this->add($data);
        if($result === false) {
            $this->error = $this->getDbError();
            return false;
        }else {
            $data['id'] = $result;
            return $data;
        }
    }

    /**
     +----------------------------------------------------------
     * 取得图像信息
     *
     +----------------------------------------------------------
     * @static
     * @access public
      +----------------------------------------------------------
     * @param string $image 图像文件名
      +----------------------------------------------------------
     * @return mixed
      +----------------------------------------------------------
     */
    protected function getImageInfo($img) {
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

    /**
     +----------------------------------------------------------
     * 生成缩略图
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function thumb($image, $thumbname,$maxWidth, $maxHeight) {
        // 获取原图信息
        $info = $this->getImageInfo($image);
        if ($info !== false) {
            $srcWidth = $info['width'];
            $srcHeight = $info['height'];
            $type = $info['type'];
            $type = strtolower($type);
            unset($info);
            $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
            if ($scale >= 1) {
                // 超过原图大小不再缩略
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                // 缩略图尺寸
                $width = (int) ($srcWidth * $scale);
                $height = (int) ($srcHeight * $scale);
            }

            // 载入原图
            $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
            $srcImg = $createFun($image);

            //创建缩略图
            if ($type != 'gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($maxWidth, $maxHeight);
            else
                $thumbImg = imagecreate($maxWidth, $maxHeight);
            // 设置幕布透明
            $background_color = imagecolorallocate($thumbImg, 255, 255, 255);  //  指派一个颜色
           // imagecolortransparent($thumbImg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            imagefill($thumbImg,0,0,$background_color);
            // 缩略图在幕布中的x、y坐标
            $x = ($maxWidth - $width)/2;
            $y = ($maxHeight - $height)/2;
            // 复制图片
            if (function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, $x, $y, 0, 0, $width, $height, $srcWidth, $srcHeight);
            else
              imagecopyresized($thumbImg, $srcImg, $x, $y, 0, 0, $width, $height, $srcWidth, $srcHeight);

            // 生成图片
            imagepng($thumbImg, $thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
        }
        return false;
    }

    /**
     * 通过图片ID获取图片Url
     * @param int $id
     * @param string $specs
     * @return string
     * TODO  memcache
     */
    public function getUrlById($id,$specs = null) 
    {
        if(empty($id)) {
            return false;
        }
       
        $info = $this->where('id='.$id)->find();
        if(empty($info)) {
            $this->error = '图片不存在';
            return false;
        }else {
            return $this->getUrl($info,$specs);
        }
    }

    /**
     * 获取图片的url地址，数据库 ext 字段保存的是原图的扩展名，生成的图片格式统一为png
     * @param $specs 为空取原图，否则为取缩略图
     * @return void
     * @author sunbingchao
     */
    public function getUrl($record,$specs = null) {

        if(!$record) {
            $this->error = '图片信息为空';
            return false;
        }

        static $image_server = null;
        static $base_path = null;

        if($image_server === null) {
            $image_server = C('IMAGE_SERVER');
        }
        if($base_path === null) {
            $base_path = C('IMAGE_UPLOAD_PATH');
        }

        if(!empty($specs)) {
            $type = 'png';
        }else {
            $type = $record['ext'];
            $specs = $this->default_spec;
        }

        $path_arr = array(
            $image_server,
            $base_path,
            $this->img_use,
            $specs,
            trim($record['path'],'/'),
            $record['name']
        );

        return implode('/', $path_arr).'.'.$type;
    }

    /**
     * 获取错误提示信息
     *
     * @return void
     * @author sunbingchao
     */
    public function getError() 
    {
        return $this->error;
    }

    /**
     * 递归建立文件夹
     *
     * @return void
     * @author sunbingchao
     */
    protected function mkdir($dir) 
    {
        if(!is_dir($dir) && !@mkdir($dir,0777)) {
            $this->mkdir(dirname($dir));
            @mkdir($dir);
        }
    }

    /**
     * 通过curl获取图片信息
     * @param void
     * @return void
     */
    protected function curl_image($url) {
        // 地址安全验证
        if(!is_string($url) || empty($url)) {
            $this->error = '图片地址不合法';
            return false;
        }
        // 设置curl参数
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_TIMEOUT,5);
        // 获取图片相关信息
        $content = curl_exec($ch);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        $mime = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);
        $type = end(explode('/',$mime));

        curl_close($ch);
        if($http_code != 200) {
            $this->error = '图片抓取失败，HTTP错误码'.$http_code;
            return false;
        }
        if(!in_array($type,$this->type)) {
            $this->error = $type.'格式暂不支持';
            return false;
        }

        return $content;
    }

    /**
     * 获取图片的用途
     *
     * @param void
     * @return void
     */
    public function getImageUse() {
        return $this->img_use;
    }

    public function getImgs($owner_id, $type=null)
    {
        $option = array(
            'owner_id' => $owner_id  // 就是资源ID
        );
        $rs = $this->where($option)->select(); 
        $retval = array();

        if (is_array($type)) {
            $i = 0;
            foreach ($rs as $item) {
                foreach($type as $t) {
                    $retval[$i][$t] = $this->getUrl($item, $t); 
                }
                ++$i;
            }
        } else {
            foreach ($rs as $item) {
                $retval[] = $this->getUrl($item, $type); 
            }
        }

        return $retval;
    }
}

?>
