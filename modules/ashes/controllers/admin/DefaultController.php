<?php

namespace app\modules\ashes\controllers\admin;

use app\modules\ashes\models\Box;
use app\modules\ashes\models\Log;
use yii;
use app\core\helpers\Url;
use app\modules\ashes\models\Area;
use app\modules\ashes\models\BoxSearch;
use yii\web\NotFoundHttpException;

class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        $cates = $this->getAreas();
        $searchModel = new BoxSearch();
        $params = Yii::$app->request->queryParams;

        $params['BoxSearch']['area_id'] = isset($params['aid']) ? $params['aid'] : false;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates,
            'params' => $params,
            'boxes' => Area::find()->where(['status'=>Area::STATUS_ACTIVE])
                ->indexBy('id')->all()
        ]);
    }

    public function actionView($box_id)
    {
        $box = Box::findOne($box_id);

        return $this->render('view', ['model'=>$box]);
    }

    private function getAreas()
    {
        $tree = Area::sortTree();

        foreach ($tree as $k => &$v) {
            if ($v['is_leaf']) {
                $v['url'] =Url::toRoute(['index', 'aid'=>$v['id']]);
            } else {
                $v['url'] = '#';
            }
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Box::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Box::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
