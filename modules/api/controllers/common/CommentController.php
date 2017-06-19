<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * Site controller
 */
class CommentController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Comment';

    public function actions() {
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
        unset($actions['delete'], $actions['create']);

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


        if (!isset($params['res_name']) || !isset($params['res_id'])) {
            return ['errno'=>'1', 'error'=>'缺少参数'];
        }

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->orderBy('id desc')
                                ->andWhere(['res_name'=>$params['res_name']])
                                ->andWhere(['res_id'=>$params['res_id']]);
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
