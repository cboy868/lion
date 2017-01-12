<?php

namespace app\modules\cms\controllers\member;

use Yii;
use app\modules\cms\models\Favor;
use app\modules\cms\models\FavorSearch;
use app\core\web\MemberController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * FavorController implements the CRUD actions for Favor model.
 */
class FavorController extends MemberController
{
    
    /**
     * Lists all Favor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $params['res'] = $params['res'] ? $params['res'] : 'goods';

        $params['FavorSearch']['res_name'] = $params['res'];
        $params['FavorSearch']['user_id'] = Yii::$app->user->id;

        $searchModel = new FavorSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
                'res' => Favor::$res,
                'params' => $params,
                'dataProvider' => $dataProvider
            ]);
    }

    /**
     * Deletes an existing Favor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id == Yii::$app->user->id) {
            $model->delete();
            Yii::$app->getSession()->setFlash('success', '删除成功');
        } else {
            Yii::$app->getSession()->setFlash('error', '您无权进行此操作');
        }
        return $this->redirect(['index']);
    }


    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        if (Favor::create($post['res_name'], $post['res_id'], $post['res_url'], $post['title'])) {
            return $this->json();
        }

        return $this->json(null, '收藏失败', -1);
        
    }

    /**
     * Finds the Favor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Favor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
