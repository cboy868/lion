<?php
namespace app\modules\api\controllers\common;

use api\common\models\Comment;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use api\common\models\memorial\Pray;
use api\common\models\NewsPhoto;
use api\common\models\NewsCategory;
use yii\filters\Cors;
/**
 * Site controller
 */
class MemorialController extends Controller
{
    public $modelClass = 'app\modules\api\models\common\Memorial';

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ],
        ], parent::behaviors());
    }

    public function actions() {
        $actions = parent::actions();
        // 禁用""index,delete" 和 "create" 操作
        unset($actions['delete'], $actions['create']);
        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->orderBy('id desc');

        if (!isset($params['uid'])) {
            return ['errno'=>1, 'error'=>'不合法的用户id'];
        }

        $query->andWhere(['user_id'=>$params['uid']]);

        $pageSize = 10;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);
    }

    /**
     * @name 点烛 献花等
     */
    public function actionJisi()
    {
        $post = Yii::$app->request->post();

        if (!$post['id'] || !$post['type'] || !$post['uid']) {
            return ["errno"=>1, 'error'=>'参数错误'];
        }

        $pray = Pray::find()->where(['user_id'=>$post['uid'], 'memorial_id'=>$post['id'],'type'=>$post['type']])
                    ->andWhere(['like','from_unixtime(`created_at`)', date('Y-m-d')])
                    ->all();
        if ($pray) {
            return ['errno'=>1, 'error'=>'每天每种祝福只能进行一次'];
        }

        $pray = new Pray();
        $pray->memorial_id = $post['id'];
        $pray->type = $post['type'];
        $pray->user_id = $post['uid'];

        return $pray->save();
    }

    public function actionJisiNum($id, $type=null)
    {
        if ($type !== null) {
            $type = explode(',', $type);
        }
        return Pray::prayCount($id, $type);
    }

    public function actionComment()
    {
        $post = Yii::$app->request->post();
        if (!$post['id']) {
            return ['errno'=>1, 'error'=>'参数错误'];
        }
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($post['id']);

        if (!$model) {
            return ['errno'=>1, 'error'=>'纪念馆未找到'];
        }
        $content = $post['content'];

        if (!$content) {
            return ['errno'=>1, 'error'=>'参数错误，内容不全'];
        }
        return Comment::create('memorial', $post['id'], $content, $post['uid']);
    }

}
