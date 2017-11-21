<?php

namespace app\modules\mess\controllers\admin;

use app\core\base\Pagination;
use app\core\helpers\ArrayHelper;
use app\modules\mess\models\MessUserRecharge;
use Yii;
use app\modules\mess\models\MessUserPrice;
use app\modules\mess\models\SearchMessUserPrice;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\user\models\User;
use app\core\helpers\Pinyin;
use app\modules\mess\models\SearchMessUserRecharge;

/**
 * PriceController implements the CRUD actions for MessUserPrice model.
 */
class PriceController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MessUserPrice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMessUserPrice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $note_user = MessUserPrice::find()->where(['<=', 'price', 0])
            ->andWhere(['status'=>MessUserPrice::STATUS_NORMAL])
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'note_user' => $note_user
        ]);
    }

    /**
     * @name 充值记录
     */
    public function actionRecord($user_id=null)
    {

        $params = Yii::$app->request->queryParams;

        if ($user_id) {
            $params['SearchMessUserRecharge']['user_id'] = $user_id;
        }
        $searchModel = new SearchMessUserRecharge();
        $dataProvider = $searchModel->search($params);

        return $this->render('record', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MessUserPrice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MessUserPrice model.
     * @name 选择食堂账号
     * @return mixed
     */
    public function actionCreate()
    {

        $query = User::find()->where(['status' => 10]);

        $page = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 40
        ]);

        $users = $query->orderBy('py ASC')
            ->offset($page->offset)
            ->limit($page->limit)
            ->asArray()
            ->all();


        $sels = MessUserPrice::find()->all();
        $selids = ArrayHelper::getColumn($sels, 'user_id');

        $users_info = [];
        foreach ($users as $k => $v) {
            $pin = strtoupper(substr($v['py'], 0, 1));
            $users_info[$pin][$v['id']] = [
                'username' => $v['username'],
                'pinyin' => $v['py'],
                'is_sel' => in_array($v['id'], $selids) ? 1 : 0
            ];
        }

        $keys = array_keys($users_info);
        return $this->render('create', [
            'user'=>$users_info,
            'keys'=>$keys,
            'page' => $page,
            ]);
    }

    public function actionAssign()
    {
        $request = Yii::$app->request;

        $user_ids = $request->post('user_id', '');
        $sel = $request->post('is_sel');

        foreach ($user_ids as $user_id) {

            $user = MessUserPrice::find()->where(['user_id'=>$user_id])->one();
            if (!$sel && $user) {
                $user->status = MessUserPrice::STATUS_DEL;
            }

            if ($sel) {
                if ($user) {
                    $user->status = MessUserPrice::STATUS_NORMAL;
                } else {
                    $user = new MessUserPrice();
                    $user->user_id = $user_id;
                    $user->price = 0;
                    $user->status = 1;
                }
            }

            $user->save();
        }

        return $this->json(null, '角色分配成功', 1);
    }

    public function actionRecharge($user_id)
    {
        $model = new MessUserRecharge();
        $model->user_id = $user_id;
        $model->op_id = Yii::$app->user->id;
        $price = MessUserPrice::find()->where(['user_id'=>$user_id,'status'=>MessUserPrice::STATUS_NORMAL])
            ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $price->price += $model->price;
            $price->save();
            return $this->redirect(['index']);
        }

        $user = User::findOne($user_id);
        return $this->renderAjax('recharge', [
            'model' => $model,
            'user'  => $user,
            'price' => $price
        ]);
    }
    /**
     * Updates an existing MessUserPrice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MessUserPrice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MessUserPrice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessUserPrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessUserPrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
