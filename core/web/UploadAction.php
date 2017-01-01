<?php
namespace app\core\web;

use yii;
use yii\base\Action;
use app\core\helpers\Up;

class UploadAction extends Action
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
    public function upload()
    {

        $id = \Yii::$app->request->get('id');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isPost) {

            $res_name = Yii::$app->request->post('res_name');
            $upload = Up::getInstanceByName('file', $res_name);

            $img_config = $upload->getConfig();
            $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);

            if (isset($img_config['water']) && $img_config['water']) {//水印
                $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
            }

            if (isset($img_config['db']) && $img_config['db']) {//是否存入数据库
                $upload->on(Up::EVENT_AFTER_UPLOAD, ['common\models\Attachment', 'db']);
            }
            $upload->save();

            $info = $upload->getInfo();
            
            return [
                'status'    => 1,
                'info'      => null,
                'data'      => [
                    'web_url'=> $info['path'] . '/' . $info['fileName'],
                    'mid' => $info['mid']
                ]
            ];
        }
    }

}