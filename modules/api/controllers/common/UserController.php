<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\rest\ActiveController;

/**
 * Site controller
 */
class UserController extends ActiveController
{
	public $modelClass = 'api\common\models\User';


	public function behaviors() {
		
        $behaviors = ArrayHelper::merge (parent::behaviors(), [ 
                'authenticator' => [ 
                    'class' => QueryParamAuth::className() 
                ]
        ]);

        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;

        return $behaviors;
    }
}
