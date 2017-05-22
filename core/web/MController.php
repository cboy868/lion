<?php

namespace app\core\web;
/**
 * Default controller for the `wechat` module
 */
class MController extends \app\core\web\Controller
{
//	public $layout = "@app/core/views/layouts/m.php";
    public $layout = "@app/modules/m/views/layouts/m.php";

	public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }

    public function init()
    {
        parent::init();
        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();
    }

    protected function _theme() {

        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/m/views/default' => '@app/web/theme/' . $model->svalue . '/mobile/home',
            '@app/modules/m/views/layouts' => '@app/web/theme/' . $model->svalue . '/mobile/layouts',
            '@app/modules/news/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/news',
            '@app/modules/shop/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/goods',

            '@app/modules/user/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/user',
            '@app/modules/order/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/order',

            '@app/modules/grave/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/grave',
            '@app/modules/memorial/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/memorial'
        ];
    }
}
