<?php
namespace app\core\widgets\Videoup;

use app\core\base\VideoUpload;
use yii;
use yii\base\Action;
use app\core\base\Upload;

class VideoupAction extends Action
{

    public $view;

    public function init()
    {
        $this->controller->enableCsrfValidation = false;
        parent::init();
    }

    public function run()
    {
        return $this->upload();
    }

    /**
     * @name 图片上传,用于百度的webupload插件
     */
//    public function upload()
//    {
//
//        $id = \Yii::$app->request->get('id');
//
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//
//        if (\Yii::$app->request->isPost) {
//
//            $res_name = Yii::$app->request->post('res_name');
//            $use = Yii::$app->request->post('use');
//
//            $upload = Upload::getInstanceByName('file', $res_name);
//            $upload->use = $use ? $use : null;
//            $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
//            $upload->save();
//
//            $info = $upload->getInfo();
//
//            return [
//                'status'    => 1,
//                'info'      => null,
//                'data'      => [
//                    'web_url'=> $info['path'],
//                    'id'=>$id,
//                    'mid' => $info['mid']
//                ]
//            ];
//        }
//    }

    public function upload()
    {
        set_time_limit (0);
        //关闭缓存
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $ip_path = 'upload/video/'. date('Ymd');
        $save_path = 'upload/video/'. date('Ymd');
        $uploader =  new VideoUpload();



        $uploader->set('path',\Yii::getAlias('@app/web/' . $ip_path));
        //用于断点续传，验证指定分块是否已经存在，避免重复上传

        $session = Yii::$app->session;

        if(isset($_POST['status'])){

            if($_POST['status'] == 'chunkCheck'){
                $target =  $ip_path.'/'.$_POST['name'].'/'.$_POST['chunkIndex'];
                if(file_exists($target) && filesize($target) == $_POST['size']){
                    die('{"ifExist":1}');
                }
                die('{"ifExist":0}');

            }elseif($_POST['status'] == 'md5Check'){

                //todo 模拟持久层查询
                $dataArr = array(
                    'b0201e4d41b2eeefc7d3d355a44c6f5a' => 'kazaff2.jpg'
                );

                if(isset($dataArr[$_POST['md5']])){
                    die('{"ifExist":1, "path":"'.$dataArr[$_POST['md5']].'"}');
                }
                die('{"ifExist":0}');
            }elseif($_POST['status'] == 'chunksMerge'){

                if($path = $uploader->chunksMerge($_POST['name'], $_POST['chunks'], $_POST['ext'])){
                    //todo 把md5签名存入持久层，供未来的秒传验证
                    $session->set('video_path', $save_path.'/'.$path);
                    die('{"status":1, "path": "'.$save_path.'/'.$path.'"}');
                }
                die('{"status":0}');
            }
        }

        if(($path = $uploader->upload('file', $_POST)) !== false){

            if(!$session->has('video_path')){
                $session->set('video_path', $save_path.'/'.$path);
            }
            die('{"status":1, "path": "'.$save_path.'/'.$path.'"}');
        }
        die('{"status":0}');
    }

}