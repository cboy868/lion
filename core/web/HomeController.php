<?php

namespace app\core\web;

use yii;
/**
 * Default controller for the `wechat` module
 */
class HomeController extends \app\core\web\Controller
{

//	public $layout = "@app/core/views/layouts/home.php";
    public $layout = "@app/modules/home/views/layouts/home.php";


    public function init()
    {
        parent::init();
        $session = Yii::$app->getSession();
        if ($session->has('language')) {
            Yii::$app->language = $session->get('language');
        }

        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();
    }

    protected function _theme()
    {
        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/home/views/default' => '@app/web/theme/' . $model->svalue . '/home/home',
            '@app/modules/news/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/news',
            '@app/modules/shop/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/shop',
            '@app/modules/home/views/layouts' => '@app/web/theme/' . $model->svalue . '/home/layouts',
            '@app/modules/grave/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/grave',
            '@app/modules/blog/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/blog',
            '@app/modules/memorial/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/memorial',


            '@app/modules/cms/views/home/about' => '@app/web/theme/' . $model->svalue . '/home/about',
            '@app/modules/cms/views/home/join' => '@app/web/theme/' . $model->svalue . '/home/join',
            '@app/modules/cms/views/home/case' => '@app/web/theme/' . $model->svalue . '/home/case',
            '@app/modules/cms/views/home/job' => '@app/web/theme/' . $model->svalue . '/home/job',
            '@app/modules/cms/views/home/contact' => '@app/web/theme/' . $model->svalue . '/home/contact',
            '@app/modules/cms/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/article',
            '@app/modules/cms/views/home/message' => '@app/web/theme/' . $model->svalue . '/home/message',
        ];
    }

    // public $layout = "home.php";

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }

    public function success($url = [], $sec = 3)
    {
        $url = empty($url) ? ['/admin'] : $url;
        $url = \yii\helpers\Url::toRoute($url);
        return $this->renderPartial('@app/core/views/single/msg', ['gotoUrl' => $url, 'sec' => $sec]);
    }

    public function error($msg = '', $sec = 3)
    {
//    	\Yii::$app->getSession()->setFlash('error', '错误');
        return $this->renderPartial('@app/core/views/single/msg', ['errorMessage' => $msg, 'sec' => $sec]);
    }

    /**
     * @name 语言设置
     */
    public function actionLanguage()
    {
        $post = Yii::$app->request->post();
        $session = Yii::$app->getSession();
        $session->set('language', $post['language']);

        return $this->json($session->get('language'));
    }
}
//多语言设置 view中加入以下代码
/*
<div class="language">
    <a href="#" lg="zh-CN" >中文</a>
    <a href="#" lg="en-US" >英文</a>
</div>

<script>
$(function(){
    $('.language a').click(function(e){
        e.preventDefault();
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>"
            var lg = $(this).attr('lg');

            $.post('<?=Url::toRoute(['language'])?>', {_csrf:csrf,language:lg},function(xhr){

        },'json');
        });
})
</script>
*/

