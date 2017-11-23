<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\MessReceptionMenu;
use Yii;
use app\modules\mess\models\MessReception;
use app\modules\mess\models\SearchMessReception;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\mess\models\MessDayMenu;
use app\modules\mess\models\Mess;
use app\modules\mess\models\MessUserOrderMenu;
/**
 * ReceptionController implements the CRUD actions for MessReception model.
 */
class ReceptionController extends BackController
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
     * Lists all MessReception models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMessReception();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $types = $this->module->params['menu_types'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types'=> $types,
        ]);
    }

    /**
     * Displays a single MessReception model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $date=null)
    {
        $reception = $this->findModel($id);
        $date = $date ? $date : $reception->day_time;
        $_menus = MessDayMenu::find()->where(['day_time'=>$date,'status'=>MessDayMenu::STATUS_NORMAL])
            ->all();
        $menus = [];
        foreach ($_menus as $menu) {
            $menus[$menu->mess_id][$menu->type][] = $menu;
        }

        $_self_menus = MessReceptionMenu::find()->where(['reception_id'=>$id])
            ->andWhere(['day_time'=>$date])
            ->orderBy('mess_id asc,type asc')
            ->all();

        $self_menus = [];
        foreach ($_self_menus as $menu) {
            $self_menus[$menu->mess_id][$menu->type][$menu->day_menu_id] = $menu;
        }

        $types = $this->module->params['menu_types'];

        return $this->render('view',[
            'mess' => Mess::sel(),
            'types'=> $types,
            'menus' => $menus,
            'self' => $self_menus,
            'self_menus' => $_self_menus,
            'date' => $date,
            'model' => $this->findModel($id)
        ]);

    }

    /**
     * Creates a new MessReception model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessReception();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateMenu($id)
    {
        $post = Yii::$app->request->post();

        $menu = MessDayMenu::findOne($post['id']);
        if (!$menu) {
            return $this->json(null, '此菜单不存在', 0);
        }

        $options = [
            'day_time' => $menu->day_time,
            'mess_id'  => $menu->mess_id,
            'type'     => $menu->type,
            'day_menu_id' => $menu->id,
            'reception_id'  => $id,
            'menu_id'  => $menu->menu_id
        ];

        $model = MessReceptionMenu::find()->where($options)->one();


        if ($post['num'] <=0) {
            if ($model) {
                if ($model->delete()) {
                    return $this->json($model, '取消成功', 1);
                }
                return $this->json(null, '取消失败', 0);
            } else {
                return $this->json(null, '订餐不存在', 0);
            }

        }

        if (!$model){//如果不存在，则创建一个
            $model = new MessReceptionMenu();
            $model->load($options, '');
        }

        $model->real_price = $menu->real_price;
        $model->num = $post['num'];


        if ($model->save()) {
            return $this->json($model, '订餐成功', 1);
        } else {
            return $this->json(null, '数据验证失败', 0);
        }
    }

    public function actionList($id,$date=null)
    {
        $date = $date ? $date : date('Y-m-d');

        $self_menus = MessReceptionMenu::find()->where(['reception_id'=>$id])
            ->andWhere(['day_time'=>$date])
            ->orderBy('mess_id asc,type asc')
            ->all();

        $types = $this->module->params['menu_types'];

        return $this->renderAjax('list',[
            'self_menus' => $self_menus,
            'types'=> $types,
            'date' => $date
        ]);
    }

    /**
     * Updates an existing MessReception model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @name 用餐安排
     */
    public function actionDining($id)
    {

    }

    /**
     * Deletes an existing MessReception model.
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
     * Finds the MessReception model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessReception the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessReception::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
