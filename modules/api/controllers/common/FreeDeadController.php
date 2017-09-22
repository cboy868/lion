<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\news\models\Category;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * Site controller
 */
class FreeDeadController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\FreeDead';


    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        // 禁用""index,delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->orderBy('id desc');


        if (isset($params['uid'])) {
            $query->andWhere(['user_id'=>$params['uid']]);
        } else {
            return ['errno'=>1, 'error'=>'参数不全'];
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

    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        $model = new $this->modelClass;

        $model->contact_user = $post['realname'];
        $model->contact_mobile = $post['mobile'];
        $model->dead = $post['dead'];
        $model->relation = $post['relation'];
        $model->user_id = $post['user'];
        $model->free_id = 0;
        $model->note = '客户从小程序申请';

        if ($model->save() !== false) {
            return true;
        }

        return ['errno'=>1, 'error'=>'报名失败,请联系管理员或直接电话报名'];

    }

}
