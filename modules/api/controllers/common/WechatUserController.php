<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\core\base\Upload;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;

use app\modules\api\models\common\User;
/**
 * Site controller
 */
class WechatUserController extends Controller
{
    public $modelClass = 'app\modules\api\models\common\WechatUser';


    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }

}
