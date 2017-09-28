<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Grave;
use app\modules\user\models\User;
use Yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\modules\cms\models\MsgForm;

/**
 * Site controller
 */
class GraveController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Grave';

    public function behaviors() {
        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->where(['is_show'=>Grave::SHOW_YES])
                                    ->andWhere(['status'=>Grave::STATUS_SALE])
                                    ->andWhere(['is_leaf'=>1]);


        if (isset($params['recommend'])) {
            $query->andWhere(['recommend'=>1]);
        }
        $query->orderBy('id desc');

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
     * @name 预定
     */
    public function actionPre()
    {
        $post = Yii::$app->request->post();
        $user_id = $post['uid'];
        $grave_id = $post['gid'];
        $uinfo = User::findOne($user_id);

        p($post);die;

        $mobile = $post['mobile'] ? $post['mobile'] : $uinfo->mobile;

        if (!$uinfo) {
            return ['errno'=>1,'error'=>'用户未找到，请先绑定'];
        }

        if (!$mobile) {
            return ['errno'=>1,'error'=>'请填写电话号码，或到个人中心补全电话'];
        }

        $model = new MsgForm();
        $model->username = $uinfo->username;
        $model->email = $uinfo->email;
        $model->title = '墓区预约';
        $model->res_id = $grave_id;
        $model->res_name = 'grave';
        $model->mobile = $mobile;
        if ($model->create() !== false){
            return true;
        }
        return ['errno'=>1,'error'=>'预定失败'];
    }

}
