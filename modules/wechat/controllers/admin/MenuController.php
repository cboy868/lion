<?php

namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Menu;
use app\modules\wechat\models\Wechat;
use app\modules\wechat\models\MenuMain;
use app\modules\wechat\models\MenuMainSearch;
use app\modules\wechat\models\MenuSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\helpers\Url;
/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    // public $wechat;

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
     * Lists all Menu models.
     * @return mixed
     * @name 微信菜单
     */
    public function actionIndex($type=1)
    {
        $searchModel = new MenuMainSearch();

        $params = Yii::$app->request->queryParams;
        $params['MenuMainSearch']['type'] = $type;
        $params['MenuMainSearch']['wid'] = $this->wid;

        $dataProvider = $searchModel->search($params);

        $model = new MenuMain();
        $model->wid = $this->wid;

        if ($model->load(Yii::$app->request->post()) &&$model->wid=$this->wid && $model->save()){
            return $this->redirect(['info', 'type'=>$model->type, 'id'=>$model->id]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
            'model' => $model
        ]);
    }
    public function actionIndex1()
    {

        $wid = Yii::$app->session->get('wechat.id');
        $wechat = Wechat::findOne($wid);

        $list = Menu::getWechatMenus();

        return $this->render('index', [
            'wechat' => $wechat,
            'menus'=>$list,
            'type' => Menu::typeMap()
        ]);

    }

//    public function actionInfo()
//    {
//        return $this->render('info');
//    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException
     * @name 添加
     */
    public function actionCreate1($type=MenuMain::TYPE_NORMAL)
    {
        $wid = Yii::$app->session->get('wechat.id');
        $wechat = Wechat::findOne($wid);

        $list = Menu::getWechatMenus();

        $menus = Menu::find()->indexBy('id')->all();

        $model = new MenuMain();

        return $this->render('create', [
            'wechat' => $wechat,
            'menus'=>$menus,
            'typemap' => Menu::typeMap(),
            'model' => $model,
            'type' => $type
        ]);

//        $model = new Menu();
//
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->save()) {
//                return $this->redirect(['index']);
//            }
//
//        } else {
//            $model->loadDefaultValues();
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }


    public function actionInfo($id)
    {
        $wechat = Wechat::findOne($this->wid);

        $list = Menu::getWechatMenus($this->wid, $id);

        $model = MenuMain::findOne($id);

        return $this->render('info', [
            'wechat' => $wechat,
            'menus'=>$list,
            'typemap' => Menu::typeMap(),
            'model' => $model,
            'type' => $model->type,
        ]);

//        $model = new Menu();
//
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->save()) {
//                return $this->redirect(['index']);
//            }
//
//        } else {
//            $model->loadDefaultValues();
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    public function actionUpdateMain()
    {
        $post = Yii::$app->request->post();
        $model = MenuMain::findOne($post['id']);

        if (!$model) {
            return $this->json(null, '不存在此菜单组', 0);
        }

        $model->name = isset($post['name']) ?$post['name'] : $model->name;

        if ($model->save()) {
            return $this->json();
        }

    }



    public function actionCreateMenu($main_id)
    {
        $model = new Menu();

        $model->wid = $this->wid;
        $model->main_id = $main_id;
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['info', 'id'=>$main_id]);
            }
        } else {
            $model->loadDefaultValues();
            return $this->renderAjax('create-menu', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateMenu($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['info', 'id'=>$model->main_id]);
        } else {

            return $this->renderAjax('update-menu', [
                'model' => $model,
            ]);

        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @name 修改
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {

            return $this->render('update', [
                'model' => $model,
            ]);

        }
    }

    /**
     * @name 同步到微信服务
     */
    public function actionSync($id)
    {
        $menu = $this->app->menu;

        $menus = Menu::getWechatMenus($this->wid, $id);
        $buttons = $this->parseMenus($menus);

        if ($menu->add($buttons)) {
            Yii::$app->getSession()->setFlash('success', '同步微信菜单成功');
        } else {
            Yii::$app->getSession()->setFlash('error', '同步微信菜单失败，请重试或检查菜单是否符合规则');
        }

        return $this->redirect(['info', 'id'=>$id]);
    }

    private function parseMenus($menus)
    {

        $buttons = [];
        foreach ($menus as $menu) {
            if (isset($menu['child'])) {
                $buttons[$menu['id']] = array(
                    'name' => $menu['name'],
                ); 
                foreach ($menu['child'] as $v) {
                    $btn = array(
                        'type' => $v['type'] == 1 ? 'view' : 'click',
                        'name' => $v['name'],
                    ); 
                    if ($v['type'] == 1 ) {
                        $btn['url'] = $v['url'];
                    } else {
                      $btn['key'] = $v['key'];
                    }
                    $buttons[$menu['id']]['sub_button'][] = $btn;
                }
            } else {
                $buttons[$menu['id']] = array(
                    'name' => $menu['name'],
                    'type' => $menu['type'] == 1 ? 'view' : 'click',
                ); 

                if ($menu['type'] == 1 ) {
                    $buttons[$menu['id']]['url'] = $menu['url'];
                } else {
                  $buttons[$menu['id']]['key'] = $menu['key'];
                }
            }
        }
        $buttons = array_values($buttons);


        return $buttons;
    }


    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除菜单
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['info','id'=>$model->main_id]);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
