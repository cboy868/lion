<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\news\models\Category;
/**
 * Site controller
 */
class NewsController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\News';


    public function actions() {
        $actions = parent::actions();

        $actions = array_merge($actions, [
            'recommend' => [
                'class' => 'app\modules\api\actions\RecommendAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ]);


        // 禁用""index,delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    /**
     * @name index
     * @des 本方法可代替actions 中indexAction中的 prepareDataProvider
     */

    public function actionCates()
    {
        $items = Category::find()->where(['status'=>Category::STATUS_ACTIVE])
            ->select(['id', 'name'])
            ->all();

        return $items;
    }

//    public function actionRecommend($category_id = null, $limit=5)
//    {
//        $model = $this->modelClass;
//        $data = $model::find()->filterWhere(['category_id'=>$category_id])
//            ->orderBy('id desc')
//            ->limit($limit)
//            ->asArray()
//            ->all();
//
//        return $data;
//
//    }

}
