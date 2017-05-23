<?php

namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Menu;
use app\modules\wechat\models\Wechat;
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
    public function actionIndex()
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
    public function actionCreate()
    {

        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['index']);
            }

        } else {
            $model->loadDefaultValues();
            return $this->renderAjax('create', [
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

            return $this->renderAjax('update', [
                'model' => $model,
            ]);

        }
    }

    /**
     * @name 同步到微信服务
     */
    public function actionSync()
    {
        $menu = $this->wechat->menu;

        $menus = Menu::getWechatMenus();
        $buttons = $this->parseMenus($menus);


        if ($menu->add($buttons)) {

            Yii::$app->getSession()->setFlash('success', '同步微信菜单成功');
            return $this->json();
        } else {
            return $this->json(null, '同步菜单失败', 0);
        }
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
