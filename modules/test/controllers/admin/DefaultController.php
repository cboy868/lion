<?php

namespace app\modules\test\controllers\admin;



use app\core\models\TagRel;

class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {


    	\Yii::$app->mailer->compose('@app/modules/test/views/admin/default/index', ['conaaa' => '测试邮件内容'])
			      ->setFrom('cboy868@163.com')
			      ->setTo('cboy868@163.com')
			      ->setSubject('这里有点内容')
			      ->send();


    	// TagRel::addTagRel(['朋友情'], 'news', 4);
        return $this->render('index');
    }
}
