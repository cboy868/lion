<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use api\common\models\NewsPhoto;
use api\common\models\NewsCategory;
/**
 * Site controller
 */
class NewsController extends Controller
{
	public $modelClass = 'api\common\models\News';

//    public $serializer = 'yii\rest\Serializer';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public $prepareDataProvider = '_index';

	public function behaviors() {
		return parent::behaviors();
    }



    public function actions() {  
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;  
    }

    public function prepareDataProvider()
    {

    }




}
