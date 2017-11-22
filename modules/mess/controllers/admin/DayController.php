<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\Mess;
use Yii;
use app\modules\mess\models\MessDayMenu;
use app\modules\mess\models\SearchMessDayMenu;
use app\core\web\BackController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DayController implements the CRUD actions for MessDayMenu model.
 */
class DayController extends BackController
{

    public static $types = [
        '1' => '早餐',
        '2' => '午餐',
        '3' => '晚餐'
    ];



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
     * Lists all MessDayMenu models.
     * @return mixed
     */
    public function actionIndex($date=null)
    {

        $date = $date ? $date : date('Y-m-d');

        $_menus = MessDayMenu::find()->where(['day_time'=>$date,'status'=>MessDayMenu::STATUS_NORMAL])
//            ->asArray()
            ->all();


        $menus = [];
        foreach ($_menus as $menu) {
            $menus[$menu->mess_id][$menu->type][] = $menu;
        }



        return $this->render('index',[
            'mess' => Mess::sel(),
            'types'=> self::$types,
            'menus' => $menus,
            'date' => $date
        ]);




        $searchModel = new SearchMessDayMenu();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MessDayMenu model.
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
     * Creates a new MessDayMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date, $mess_id, $type)
    {
        $model = new MessDayMenu();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $md = MessDayMenu::find()->where([
                'day_time'=>$model->day_time,
                'mess_id'=>$model->mess_id,
                'type' => $model->type,
                'menu_id' => $model->menu_id
            ])->one();

            if ($md) {
                Yii::$app->session->setFlash('error', '此菜单已存在');
            } else {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', '菜品添加成功');
                } else {
                    Yii::$app->session->setFlash('error', '菜单添加失败，请重试或联系管理员');
                }
            }
            return $this->redirect(['index', 'date'=>$date]);
        } else {

            $model->type = $type;
            $model->day_time = $date;
            $model->mess_id = $mess_id;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        $model = new MessDayMenu();


        if ($model->load($post, '') && $model->validate()) {

            $md = MessDayMenu::find()->where([
                'day_time'=>$model->day_time,
                'mess_id'=>$model->mess_id,
                'type' => $model->type,
                'menu_id' => $model->menu_id
            ])->one();

            if (isset($post['delid']) && $post['delid']) {
                $del_model = MessDayMenu::findOne($post['delid']);
                $del_model->delete();
            }

            if ($md) {
                return $this->json(null, '此菜单已存在', 0);
            } else {
                if ($model->save()) {
                    return $this->json($model->id, '菜品添加成功', 1);
                } else {
                    return $this->json(null, '菜单添加失败，请重试或联系管理员', 0);
                }
            }
        } else {
            return $this->json(null, '菜单添加失败，数据验证未通过', 0);
        }

    }

    /**
     * @name 改价
     */
    public function actionPrice()
    {
        $post = Yii::$app->request->post();

        $model = MessDayMenu::findOne($post['id']);
        if (!$model) {
            return $this->json(null, '数据错误',0);
        }

        $model->real_price = $post['price'];

        if ($model->save() !== false) {
            return $this->json();
        }
        return $this->json(null, '数据错误',0);
    }

    /**
     * Updates an existing MessDayMenu model.
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
     * Deletes an existing MessDayMenu model.
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
     * Finds the MessDayMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessDayMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessDayMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
