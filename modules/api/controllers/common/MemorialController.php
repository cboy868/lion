<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Memorial;
use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\modules\api\models\common\Pray;
use app\modules\api\models\common\Comment;
use yii\filters\Cors;
/**
 * Site controller
 */
class MemorialController extends Controller
{
    public $modelClass = 'app\modules\api\models\common\Memorial';

    public function actions() {
        $actions = parent::actions();
        // 禁用""index,delete" 和 "create" 操作
        unset($actions['delete'], $actions['create']);
        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function behaviors() {
        return parent::behaviors();
    }

    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->orderBy('id desc');

//        if (!isset($params['uid'])) {
//            return ['errno'=>1, 'error'=>'不合法的用户id'];
//        }
//

        if (isset($params['status'])) {
            $query->where(['status'=>$params['status']]);
        } else {
            $query->where(['<>', 'status', $modelClass::STATUS_DELETE]);
        }

        if (isset($params['uid'])) {
            $query->andWhere(['user_id'=>$params['uid']]);
        } else {
            $query->andWhere(['privacy'=>$modelClass::PRIVACY_PUBLIC]);
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

    /**
     * @name 申请建馆
     */
    public function actionApply()
    {
        $post = Yii::$app->request->post();

        if (!$post['title'] || !$post['uid'] || !$post['intro']) {
            return ['errno'=>1, 'error'=>'参数错误'];
        }


        if ($this->hasApplys($post['uid'])) {
            return ['errno'=>1, 'error'=>'您有尚未审核的纪念馆'];
        }

        if (Memorial::find()->where(['user_id'=>$post['uid'], 'tomb_id'=>0])->count() >= 10) {
            return ['errno'=>1, 'error'=>'每人最多只能创建十个纪念馆'];
        }

        $model = new Memorial();
        $model->title = $post['title'];
        $model->intro = nl2br($post['intro']);
        $model->user_id = $post['uid'];
        $model->status = Memorial::STATUS_APPLY;
        return $model->save();
    }


    /**
     * @name 判断是否有待审批的纪念馆
     */
    public function hasApplys($uid)
    {
        return Memorial::find()->where(['status'=>Memorial::STATUS_APPLY])
                                ->andWhere(['user_id'=>$uid])->one();

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
        return Comment::add('memorial', $post['id'], $content, $post['uid']);
    }

}
