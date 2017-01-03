<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\core\helpers\Url;


use app\modules\cms\models\Album;
use app\modules\cms\models\Category;
use app\modules\cms\models\AlbumSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\mod\models\Module;


/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends BackController
{

    public $modInfo;


    public function init()
    {
        parent::init();
        $mod = Yii::$app->request->get('mod');
        $this->modInfo = Module::findOne($mod);
    }

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

    public function actions()
    {
        return [
            'web-upload' => [
                'class' => 'app\core\web\WebuploadAction',
            ]
        ];
    }

    /**
     * Lists all Album models.
     * @return mixed
     * @name 图集管理
     */
    public function actionIndex()
    {
        $mod = Yii::$app->request->get('mod');
        $tree = $this->getCates($mod);

        $modInfo = Module::findOne($mod);

        $class = '\app\modules\cms\models\mods\Album' . $mod . 'Search';
        $c = 'Album' . $mod . 'Search';

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;

        $params[$c]['category_id'] = Yii::$app->request->get('category_id');


        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modinfo' => $this->modInfo,
            'cates'         => $tree,
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ]);

    }

    private function getCates($mod)
    {
        $res_name = 'album' . $mod;
        $tree = Category::sortTree(['res_name'=>$res_name]);

        foreach ($tree as $k => &$v) {
            $v['url'] = $v['is_leaf'] ? Url::toRoute(['index', 'category_id'=>$v['id'], 'mod'=>$mod]) : '#';
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     * @return mixed
     * @name 图集详细
     */
    public function actionView($id)
    {

        $mod = Yii::$app->getRequest()->get('mod');

        return $this->render('view', [
            'model' => $this->findModel($id, $mod),
            'modinfo' => $this->modInfo,
        ]);
    }

    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加图集
     */
    public function actionCreate($mod)
    {

        $modInfo = Module::findOne($mod);


        $attach = [];
        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'album_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();


        $class = '\app\modules\cms\models\mods\Album' . $mod;;

        $model = new $class();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['index', 'mod'=>$mod]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modinfo' => $this->modInfo,
                'attach'=> $attach,
            ]);
        }
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改图集
     */
    public function actionUpdate($id, $mod)
    {

        $model = $this->findModel($id, $mod);

        $attach = [];
        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'album_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'mod'=>$mod]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modinfo' => $this->modInfo,
                'attach'=> $attach,
            ]);
        }
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除图集
     */
    public function actionDelete($id, $mod)
    {
        $this->findModel($id, $mod)->delete();

        return $this->redirect(['index', 'mod'=>$mod]);
    }

    /**
     * 
     * @name 修改图集分类
     */
    public function actionMove($mod)
    {

        $req = Yii::$app->getRequest();
        $ids = $req->post('ids');
        $category_id = $req->post('category_id');
        $class = '\app\modules\cms\models\mods\Album' . $mod;


        Yii::$app->db->createCommand()
                          ->update(
                            $class::tableName(), 
                            ['category_id' => $category_id], 
                            ['id'=>$ids])
                          ->execute();

        return $this->json();
        
    }

    /**
     * @name 删除图集
     */
    public function actionDrop($mod)
    {
        $req = Yii::$app->getRequest();
        $ids = $req->post('ids');
        $class = '\app\modules\cms\models\mods\Album' . $mod;

        Yii::$app->db->createCommand()
                     ->delete($class::tableName(),[
                            'id' => $ids
                        ])
                     ->execute();

        return $this->json();
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $mod)
    {
        $class = '\app\modules\cms\models\mods\Album' . $mod;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    // ------------------------------- 以下部分处理分类 ------------------------------



    /**
     * @name 添加图集分类
     */
    public function actionCreateCate()
    {

        $request = Yii::$app->getRequest();

        $model = new Category();

        if (Yii::$app->request->isPost) {
            $model->load($request->post());
            // $upload = Up::getInstance($model, 'covert', 'foods_category');

            // if ($upload) {
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
            //     $upload->save();

            //     $info = $upload->getInfo();
            //     $model->cover = $info['path'] . '/' . $info['fileName'];
            // }

            // $model->pid = $request->get('pid');
            $model->res_name = 'album' . $request->get('mod');

            $model->save();

            return $this->redirect(['index', 'mod'=>$request->get('mod'), 'category_id'=>$request->get('category_id')]);
        } 

        return $this->renderAjax('create-cate', [
            'model' => $model,
        ]);
    }

    /**
     * @name 修改图集分类
     */
    public function actionUpdateCate($id)
    {

        $req = Yii::$app->getRequest();
        $model = $this->findCate($id);

        if ($model->load(Yii::$app->request->post())) {
            // $upload = Up::getInstance($model, 'covert', 'foods_category');

            // if ($upload) {
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
            //     $upload->save();

            //     $info = $upload->getInfo();
            //     $model->cover = $info['path'] . '/' . $info['fileName'];
            // }

            if ($model->save()) {
                return $this->redirect(['index', 'mod'=>$req->get('mod'), 'category_id'=>$req->get('category_id')]);
            }
        }

        return $this->renderAjax('update-cate', [
            'model' => $model,
        ]);
    }

    /**
     * @name 删除分类
     */
    public function actionDeleteCate($id)
    {
        $this->findCate($id)->delete();
        $req = Yii::$app->getRequest();

        return $this->redirect(['index', 'mod'=>$req->get('mod'), 'category_id'=>$req->get('category_id')]);
    }

    protected function findCate($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
