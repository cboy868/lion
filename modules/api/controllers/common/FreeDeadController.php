<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\news\models\Category;
/**
 * Site controller
 */
class FreeDeadController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\FreeDead';


    public function actions() {
        $actions = parent::actions();

        // 禁用""index,delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        $model = new $this->modelClass;

        $model->contact_user = $post['realname'];
        $model->contact_mobile = $post['mobile'];
        $model->dead = $post['dead'];
        $model->relation = $post['relation'];
        $model->free_id = 0;
        $model->note = '客户从小程序申请';

        if ($model->save() !== false) {
            return true;
        }

        return ['errno'=>1, 'error'=>'报名失败,请联系管理员或直接电话报名'];

    }

}
