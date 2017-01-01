<?php
/**
 * 
 * Author: wsq(wansq@ylwkj.com)
 * Date: 14-12-3 下午10:11
 */

namespace app\controllers;

use Yii;
use app\models\Attachment;
use yii\base\Action;
use app\core\base\Upload;



class UeditorAction extends Action{

	public $enableCsrfValidation = false;


	public function run()
    {

    	$config = Yii::$app->params['ueditor'];
		$action = Yii::$app->request->get('action');

		switch ($action) {
            case 'config':
                $config = Yii::$app->params['ueditor'];
                $result =  json_encode($config);
                break;

            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
                $result = $this->upload();
                break;

            /* 列出图片 */
            case 'listimage':
                $result = $this->imgList();
                break;
            /* 列出文件 */
            case 'listfile':
                $result = $this->fileList();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = $this->crawler();
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        if (YIi::$app->request->get('callback')) {
        	if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
        	echo $result;
        }
    }



	public function upload()
	{
		$CONFIG = Yii::$app->params['ueditor'];

		$base64 = "upload";
		switch (htmlspecialchars(Yii::$app->request->get('action'))) {
		    case 'uploadimage':
		        $config = array(
		            "pathFormat" => $CONFIG['imagePathFormat'],
		            "maxSize" => $CONFIG['imageMaxSize'],
		            "allowFiles" => $CONFIG['imageAllowFiles']
		        );
		        $fieldName = $CONFIG['imageFieldName'];
		        break;
		    case 'uploadscrawl':
		        $config = array(
		            "pathFormat" => $CONFIG['scrawlPathFormat'],
		            "maxSize" => $CONFIG['scrawlMaxSize'],
		            "allowFiles" => $CONFIG['scrawlAllowFiles'],
		            "oriName" => "scrawl.png"
		        );
		        $fieldName = $CONFIG['scrawlFieldName'];
		        $base64 = "base64";
		        break;
		    case 'uploadvideo':
		        $config = array(
		            "pathFormat" => $CONFIG['videoPathFormat'],
		            "maxSize" => $CONFIG['videoMaxSize'],
		            "allowFiles" => $CONFIG['videoAllowFiles']
		        );
		        $fieldName = $CONFIG['videoFieldName'];
		        break;
		    case 'uploadfile':
		    default:
		        $config = array(
		            "pathFormat" => $CONFIG['filePathFormat'],
		            "maxSize" => $CONFIG['fileMaxSize'],
		            "allowFiles" => $CONFIG['fileAllowFiles']
		        );
		        $fieldName = $CONFIG['fileFieldName'];
		        break;
		}


		$up = Upload::getInstanceByName($fileName);
		$up->save();

		p($up->getInfo());

		/* 生成上传实例对象并完成上传 */
		// $up = new Uploader($fieldName, $config, $base64);

		/**
		 * 得到上传文件所对应的各个参数,数组结构
		 * array(
		 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
		 *     "url" => "",            //返回的地址
		 *     "title" => "",          //新文件名
		 *     "original" => "",       //原始文件名
		 *     "type" => ""            //文件类型
		 *     "size" => "",           //文件大小
		 * )
		 */

		/* 返回数据 */
		return json_encode($up->getFileInfo());
	}

	public function imgList()
	{

		$request = Yii::$app->request;
        $size = $request->get('size', 20);
        $start = $request->get('start', 0);

        $all = Attachment::getImgByUserId(Yii::$app->user->id, $start, $size);
        $uploadDir = Yii::$app->params['upload']['savePath'];

        $urls = [];
        foreach ($all['list'] as $k => $v) {
            $url = '/'.$uploadDir . $v['path'] .'/'. $v['name'] . '.' . $v['ext'];
            array_push($urls, ['url'=>$url]);
        }

        return json_encode(array(
            "state" => "SUCCESS",
            "list" => $urls,
            "start" => $start,
            "total" => $all['count']
        ));  

	}

	public function fileList()
	{

	}

	public function crawler()
	{
		$CONFIG = Yii::$app->params['ueditor'];
		$request = Yii::$app->request;
		/* 上传配置 */
		$config = array(
		    "pathFormat" => $CONFIG['catcherPathFormat'],
		    "maxSize" => $CONFIG['catcherMaxSize'],
		    "allowFiles" => $CONFIG['catcherAllowFiles'],
		    "oriName" => "remote.png"
		);
		$fieldName = $CONFIG['catcherFieldName'];

		/* 抓取远程图片 */
		$list = array();
		if ($request->post($fieldName)) {
		    $source = $request->post($fieldName);
		} else {
		    $source = $request->get($fieldName);
		}
		foreach ($source as $imgUrl) {
		    $item = new Uploader($imgUrl, $config, "remote");
		    $info = $item->getFileInfo();
		    array_push($list, array(
		        "state" => $info["state"],
		        "url" => $info["url"],
		        "size" => $info["size"],
		        "title" => htmlspecialchars($info["title"]),
		        "original" => htmlspecialchars($info["original"]),
		        "source" => htmlspecialchars($imgUrl)
		    ));
		}

		/* 返回抓取数据 */
		return json_encode(array(
		    'state'=> count($list) ? 'SUCCESS':'ERROR',
		    'list'=> $list
		));
	}

}