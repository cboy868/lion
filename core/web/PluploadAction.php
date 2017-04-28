<?php
namespace app\core\web;

use yii;
use yii\base\Action;
use app\core\base\Upload;

class PluploadAction extends Action
{


    public $type;

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
            $use = Yii::$app->request->post('use');
            $res_id = Yii::$app->request->post('res_id');

            $upload = Upload::getInstanceByName('file', $res_name, $res_id);
            $upload->use = $use ? $use : null;

            if ($this->type == 'news') {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\modules\news\models\NewsPhoto', 'db']);
            } else {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
            }
            $upload->save();

            $info = $upload->getInfo();

            if (method_exists($this->controller, 'saveAttach')) {
                $this->controller->saveAttach($info);
            }
            
            return [
                'web_url'=> $info['path'] . '/' . $info['fileName'],
                'mid' => $info['mid']
            ];
        }
    }

}