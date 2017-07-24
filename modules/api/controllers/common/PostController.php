<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;
use app\modules\api\models\common\Post;
use app\modules\cms\models\Category;


/**
 * Site controller
 */
class PostController extends Controller
{
    public $modelClass = 'app\modules\api\models\common\Post';

//    public $serializer = 'yii\rest\Serializer';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public $prepareDataProvider = '_index';

    public function actions() {
        $actions = parent::actions();
        // 禁用""index,delete" 和 "create" 操作
        unset($actions['delete'], $actions['create'], $actions['view']);

        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }


    /**
     * @name index
     * @des 本方法可代替actions 中indexAction中的 prepareDataProvider
     */
    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        if (!$params['mid']) {
            return ['errno'=>1, 'error'=>'参数错误'];
        }

        Code::createObj('post', $params['mid']);

        $c = 'Post' . $params['mid'];
        $class = '\app\modules\cms\models\mods\\' . $c;

        $query = $class::find();

        if (isset($params['cid'])) {
            $query->andWhere(['category_id'=>$params['cid']]);
        }
        if (isset($params['type'])) {
            $types = Post::types();
            $type_key = array_search($params['type'], $types);

            $query->andWhere(['type'=>$type_key]);

        }

        $pageSize = 10;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);

    }

    public function actionView($mid, $id)
    {
        $model = $this->findModel($mid, $id);

        return $model;

        if ($model->type == Post::TYPE_IMAGE) {
            return $model->getImages();
        } else {
            return $model;
        }
    }

    protected function findModel($mid, $id)
    {
        $model = $query = (new \yii\db\Query())
            ->from('post_' . $mid)
            ->where(['id'=>$id])
            ->one();

        return $model;
    }

    public function actionCates($mid)
    {
       $list = Category::find()->where(['mid'=>$mid])->all();
       return [
           'items' => $list
       ];
    }



}
