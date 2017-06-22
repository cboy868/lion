<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Goods;
use Yii;
use yii\rest\ActiveController;
use app\modules\shop\models\Category;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\modules\shop\models\Sku;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use app\modules\api\models\common\Cart;
use yii\data\ActiveDataProvider;
/**
 * Site controller
 */
class TombController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Tomb';

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

        $query->where(['<>', 'status', $modelClass::STATUS_DELETE]);
        $query->andWhere(['user_id'=>$params['uid']]);

        if ($query->count() == 0) {
            return ['errno'=>1, 'error'=>'没有有效墓位'];
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

    public function actionRenew()
    {

        $post = Yii::$app->request->post();

        $model = $this->findModel($post['id']);

        if (!$model) {
            return ['errno'=>1, 'error'=>'此墓位不存在'];
        }

        if (!$post['uid']) {
            return ['errno'=>1, 'error'=>'参数错误'];
        }

        $config = Yii::$app->getModule('grave')->params['goods'];

        $gid = $config['id']['renew'];
        $fee = $config['fee']['renew'];
        $ginfo = Goods::findOne($gid);

        $extra = [
            'price' => $post['num'] * $fee * $model->price,
            'num'   => $post['num'],
            'tid'   => $model->id,
        ];

        $info = $ginfo->order($post['uid'], $extra);
        if ($info['order']) {
            return $info;
        }

        return ['errno'=>1, 'error'=>'下单失败，请联系管理人员'];
    }

//    public function actionRepair()
//    {
//        $post = Yii::$app->request->post();
//
//        $model = $this->findModel($post['id']);
//
//        if (!$model) {
//            return ['errno'=>1, 'error'=>'此墓位不存在'];
//        }
//
//
//        if (!$model->ins) {
//            return ['errno'=>1, 'error'=>'此墓位不存在碑文，请联系工作人员'];
//        }
//
//        $config = Yii::$app->getModule('grave')->params['goods'];
//    }

    protected function findModel($id)
    {
        $class = $this->modelClass;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
