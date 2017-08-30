<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Goods;
use app\modules\api\models\common\Grave;
use app\modules\api\models\common\Tomb;
use app\modules\api\models\common\User;
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
use yii\web\NotFoundHttpException;
/**
 * Site controller
 */
class TaskController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Task';

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

        if (!isset($params['pre'])) {
            $query->andWhere(['like', 'pre_finish', date('Y-m-d')]);
        } else {
            $query->andWhere(['like', 'pre_finish', $params['pre']]);
        }

        $query->andWhere(['<>', 'status', $modelClass::STATUS_DELETE]);
        $query->andWhere(['user_id'=>$params['uid']]);

        $pageSize = 25;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);
    }


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
