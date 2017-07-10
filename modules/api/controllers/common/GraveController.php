<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Grave;
use Yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

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
                                    ->orderBy('id desc');

        $pageSize = 10;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);
    }

}
