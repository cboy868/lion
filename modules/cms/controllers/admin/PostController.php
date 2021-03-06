<?php

namespace app\modules\cms\controllers\admin;

use app\modules\cms\models\Category;
use app\modules\cms\models\LgPost;
use Yii;

use app\modules\cms\models\Post;
use app\modules\cms\models\PostForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;
use app\modules\cms\models\PostImage;
use app\core\base\Upload;
use app\core\helpers\Html;
use app\modules\cms\models\PostImageSearch;
use yii\base\Model;
use app\core\helpers\Url;

class PostController extends \app\core\web\BackController
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

    public function actions()
    {
        return [
//            'web-upload' => [
//                'class' => 'app\core\web\WebuploadAction',
//            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'post-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'post'
            ]
        ];
    }

    /**
     * @param $mid
     * @param null $type
     * @param null $category_id
     * @return string
     * @name 图文列表
     */
    public function actionIndex($mid=null, $type=null, $category_id=null, $i18n=false, $id=null)
    {

        //取所有模块
        $modules = Module::find()->where(['status'=>Module::STATUS_NORMAL])->asArray()->all();

        if ($mid === null) {
            return $this->render('empty_index', ['modules'=>$modules]);
        }

        $cates = $this->getCates($mid);

        $module = Module::findOne($mid);
        Code::createObj('post', $mid);

        $c = 'Post' . $mid . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;

        if ($category_id) {
            $params[$c]['category_id'] = $params['category_id'];
        }

        if ($type) {
            $types = Post::types();
            $type_key = array_search($type, $types);
            $params[$c]['type'] = $type_key;
        }

        $dataProvider = $searchModel->search($params);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module,
            'type'  => $type,
            'i18n' => $i18n,
            'i18n_flag' => Yii::$app->params['i18n']['flag'],
            'modules' => $modules,
            'cates' => $cates
        ];

        if (!empty($id)) {
            $data['model'] = $this->findModel($mid, $id);
        }

        return $this->render('index', $data);

    }

    private function getCates($mid)
    {
        $tree = Category::sortTree(['mid'=>$mid]);

        foreach ($tree as $k => &$v) {
//            $v['url'] =Url::toRoute(['index', 'pid'=>$v['id']]);
            $v['url'] =Url::toRoute(['index', 'category_id'=>$v['id'], 'mid'=>$mid]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    /**
     * @param $mid
     * @param $id
     * @return mixed
     * @name 详细内容
     */
    public function actionView($mid, $id)
    {
        $module = Module::findOne($mid);
        $model = $this->findModel($mid, $id);
        $method = '_' . Post::types($model->type) . 'View';
        return $this->$method($module, $model);
    }

    private function _textView($module, $model)
    {
        return $this->render('text-view', [
            'model' => $model,
            'mInfo' => $module
        ]);
    }

    private function _imageView($module, $model)
    {
        $searchModel = new PostImageSearch();
        $params = Yii::$app->request->queryParams;
        $params['PostImageSearch']['mod'] = $module->id;
        $params['PostImageSearch']['post_id'] = $model->id;

        $dataProvider = $searchModel->search($params);

        return $this->render('image-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'module' => $module,
        ]);
    }

    /**
     * @param $mid
     * @param $type
     * @return mixed
     * @name 添加内容
     */
    public function actionCreate($mid, $type)
    {
        Code::createObj('post', $mid);
        $class = '\app\modules\cms\models\mods\Post' . $mid;
        $model = new $class;

        $module = Module::findOne($mid);

        $attach = $this->getAttach($mid);

        $method = '_create' . ucfirst($type);

        return $this->$method($module, $model, $attach);

    }

    private function _createText($module, $model, $attach)
    {
        $model->setScenario('text');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->ip = Yii::$app->request->userIP;
            $model->created_by = Yii::$app->user->id;
            $model->author = $model->author ? $model->author : Yii::$app->user->identity->username;

            if (empty($model->summary)) {
                $model->summary = Html::cutstr_html($model->body, 50);
            }

            $model->type = Post::TYPE_TEXT;

            $model->save();

            $up = Upload::getInstance($model, 'thumb', 'post'.$module->id);

            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD,
                    ['app\modules\cms\models\PostImage', 'db'],
                    ['album_id'=>$model->id, 'mid'=>$module->id]
                );

                $up->save();
                $info = $up->getInfo();

                $model->thumb = $info['mid'];
                $model->save();
            }

            $i18n = Yii::$app->params['i18n'];
            if ($i18n['flag']) {
                return $this->redirect(['index', 'mid' => $module->id, 'i18n'=>true, 'id'=>$model->id]);
            }

            return $this->redirect(['index', 'mid' => $module->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'attach'=> $attach,
                'module' => $module,
            ]);
        }

    }

    private function _createImage($module, $model, $attach)
    {
        $model->setScenario('image');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->created_by = Yii::$app->user->identity->id;
            $model->type = Post::TYPE_IMAGE;
            $model->author = $model->author ? $model->author : Yii::$app->user->identity->username;

            $model->save();
            $i18n = Yii::$app->params['i18n'];
            if ($i18n['flag']) {
                return $this->redirect(['index', 'mid' => $module->id, 'i18n'=>true, 'id'=>$model->id]);
            }
            return $this->redirect(['view', 'mid'=>$module->id, 'id'=>$model->id]);
        } else {
            $model->author = Yii::$app->user->identity->username;
            return $this->renderAjax('create', [
                'model' => $model,
                'module' => $module,
                'attach'=> $attach,
            ]);
        }
    }


    private function getAttach($mid, $type='post')
    {
        $command = (new \yii\db\Query())
                ->from('module_field')
                ->where(['table' => 'post_' . $mid])
                ->createCommand();
        // 返回查询结果的所有行
        return $command->queryAll();
    }

    /**
     * @name 多语言编辑
     */
    public function actionUpdateLg($mid, $id)
    {

        $model = $this->findModel($mid, $id);
        $module = Module::findOne($mid);

        $params = Yii::$app->params['i18n'];
        $lgs = array_keys($params['languages']);
        $data['model'] = $model;
        $lg_models = LgPost::find()->where(['language'=>$lgs])
                                    ->andWhere(['post_id'=>$model->id])
                                    ->indexBy('language')
                                    ->all();

        foreach ($lgs as $v) {
            if (!array_key_exists($v, $lg_models)) {
                $lg_models[$v] = new LgPost();
                $lg_models[$v]->language = $v;
                $lg_models[$v]->post_id = $id;
                $lg_models[$v]->mid = $mid;
            }
        }

        if (Model::loadMultiple($lg_models, \Yii::$app->request->post()) && Model::validateMultiple($lg_models)) {

            foreach ($lg_models as $lg_model) {
                $lg_model->save(false);
            }

            return $this->redirect(['index', 'mid'=>$mid]);
        }

        $data['lg_models'] = $lg_models;
        $data['languages'] = $params['languages'];
        $data['module'] = $module;

        return $this->render('update_lg', $data);
    }


    /**
     * @name 修改内容
     */
    public function actionUpdate($type, $mid, $id)
    {
        $model = $this->findModel($mid, $id);
        $module = Module::findOne($mid);

        $attach = $this->getAttach($mid);

        $method = '_update' . ucfirst($type);

        return $this->$method($module, $model, $attach);

    }

    private function _updateText($module, $model, $attach)
    {

        $model->setScenario('text');


        $thumb = $model->thumb;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $up = Upload::getInstance($model, 'thumb', 'post'.$module->id);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD,
                        ['app\modules\cms\models\PostImage', 'db'],
                        ['album_id'=>$model->id, 'mid'=>$module->id]
                );
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            } else {
                $model->thumb = $thumb;
            }
            $summary = strip_tags($model->summary);

            if (empty($summary)) {
                $model->summary = Html::cutstr_html($model->body, 50);
            }

            $model->save();

            return $this->redirect(['index', 'mid'=>$module->id]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'attach'=> $attach,
                'module' => $module,
            ]);
        }
    }

    private function _updateImage($module, $model, $attach)
    {
        $model->setScenario('image');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index', 'mid'=>$module->id, 'type'=>'image']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'module' => $module,
                'attach'=> $attach,
            ]);
        }
    }

    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除图集
     */
    public function actionDeleteAlbum($id, $mid)
    {
        $this->findAlbum($id, $mid)->delete();

        Yii::$app->db->createCommand()
            ->update(
                PostImage::tableName(),
                ['status' => -1],
                ['album_id'=>$id, 'mod'=>$mid])
            ->execute();

        return $this->redirect(['index', 'mid'=>$mid,'type'=>'album']);
    }

    /**
     * @name 批量删除
     */
    public function actionBatchDel()
    {
        $post = Yii::$app->request->post();

        $ses = Yii::$app->getSession();

        if (empty($post['mid']) || empty($post['ids'])) {
            return $this->json(null, '请选择要删除的数据 ', 0);
        }

        Code::createObj('post', $post['mid']);

        $class = '\app\modules\cms\models\mods\Post' . $post['mid'];

        $flag = Yii::$app->db->createCommand()
                    ->delete($class::tableName(),[
                        'id' => $post['ids']
                    ])->execute();

        if ($flag) {
            $ses->setFlash('success','数据批量删除成功');
            return $this->json();
        }

        return $this->json(null, '删除失败', 0);

    }


    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除文章
     */
    public function actionDelete($mid, $id)
    {
        $model = $this->findModel($mid, $id);
        $model->delete();

        return $this->redirect(['index', 'mid'=>$mid, 'type'=>Post::types($model->type)]);
    }

    /**
     * @return array
     * @name 修改图片名及描述
     */
    public function actionTitDes()
    {
        $post = Yii::$app->request->post();

        $tit = $post['title'];
        $des = $post['desc'];
        $id  = $post['id'];

        $model = PostImage::findOne($id);
        $model->title = $tit;
        $model->desc = $des;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除图集中图片
     */
    public function actionDelImg($id, $mid, $post_id)
    {
        $this->findImg($id)->delete();
        $model = $this->findModel($mid, $post_id);
        $model->updateNum();
        return $this->redirect(['view', 'mid'=>$mid, 'id'=>$post_id]);
    }

    /**
     * @name 排序
     */
    public function actionSort($post_id)
    {
        $ids = Yii::$app->request->post('ids');

        $connection = Yii::$app->db;

        foreach ($ids as $k => $v) {
            $connection->createCommand()
                ->update(
                    PostImage::tableName(),
                    ['sort' => $k],
                    ['id'=>$v])
                ->execute();
        }

        return $this->json();
    }

    /**
     * @param $mid
     * @param $post_id
     * @param $id
     * @return array
     * @name 修改图集封面
     */
    public function actionCover($mid, $post_id, $id)
    {
        $model = $this->findModel($mid, $post_id);
        $model->thumb = $id;
        $model->save();

        return $this->json();
    }


    protected function findModel($mid, $id)
    {
        Code::createObj('post', $mid);

        $class = '\app\modules\cms\models\mods\Post' . $mid;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findImg($id)
    {
        if (($model = PostImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
