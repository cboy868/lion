<?php
namespace app\modules\api\controllers\common;

use api\common\models\Post;
use api\common\models\PostCategory;
use api\common\models\PostImage;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use api\common\models\Module;
use api\common\models\Code;

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
            return ;
        }

        $mid = $params['mid'];

        $query = (new \yii\db\Query())
            ->from('post_' . $mid)
            ->where(['status'=>Post::STATUS_ACTIVE]);

        $count = $query->count();

        $pageSize = 10;
        if (isset($params['per-page'])) {
            $pageSize = $params['per-page'];
        }

        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);

        $list = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

        foreach ($list as &$v) {
            $v['cover'] = PostImage::getById($v['thumb']);
        }unset($v);

        return [
            'items' => $list,
            '_meta' => [
                'totalCount' => $count,
                'pageCount' =>$pagination->getPageCount(),
                'currentPage' => $pagination->getPage(),
                'perPage' => $pageSize

            ],
            '_links' => $pagination->getLinks(true)
        ];
    }

    public function actionView($mid, $id)
    {
        return $this->findModel($mid, $id);
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
       $list = PostCategory::find()->where(['mid'=>$mid])->all();

       return [
           'items' => $list
       ];
    }



}
