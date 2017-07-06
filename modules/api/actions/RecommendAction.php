<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\api\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * @author cboy
 * @since 2.0
 */
class RecommendAction extends Action
{
    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     * should return a collection of the models. If not set, [[prepareDataProvider()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return an instance of [[ActiveDataProvider]].
     */
    public $prepareDataProvider;


    /**
     * @return ActiveDataProvider
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        return $this->prepareDataProvider();
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find();


        $query->where(['<>', 'status', $modelClass::STATUS_DELETE]);
//        $query->andWhere(['recommend'=>1]);

        if (isset($params['cid'])) {
            $query->andWhere(['category_id'=>$params['cid']]);
        }

        $pageSize = 10;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        $query->orderBy('id desc');


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);
    }
}
