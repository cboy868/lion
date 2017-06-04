<?php

namespace app\modules\news\controllers\admin;

use app\core\models\TagRel;
use Yii;
use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use app\modules\news\models\NewsPhoto;
use app\modules\news\models\NewsSearch;
use app\core\web\BackController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\helpers\ArrayHelper;
use app\modules\news\models\LgNews;
use yii\base\Model;

/**
 * DefaultController implements the CRUD actions for News model.
 */
class DefaultController extends BackController
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
            'web-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'news',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
                'type' =>'news',
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     * @name 资讯列表
     */
    public function actionIndex($i18n=false)
    {
        $searchModel = new NewsSearch();

        $params = Yii::$app->request->queryParams;

        $type = Yii::$app->request->get('type');
        if ($type) {
            $params['NewsSearch']['type'] = $type;
        } else {
            $type = isset($params['NewsSearch']['type']) ? $params['NewsSearch']['type'] : 0;
        }

        $dataProvider = $searchModel->search($params);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
            'i18n' => $i18n,
            'i18n_flag' => Yii::$app->params['i18n']['flag']
        ];

        return $this->render('index', $data);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @name 资讯详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $str
     * @param $id
     */
    private function tagCreate($str, $id)
    {
        $str = str_replace('，', ',', $str);
        $tags = explode(',', $str);
        TagRel::addTagRel($tags, 'news', $id);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加新资讯
     */
    public function actionCreate($type="text")
    {
        if (!in_array($type, ['text', 'image', 'video'])) {
            $type = 'text';
        }

        $class = '\app\modules\news\models\News' . ucfirst($type) . 'Form';

        $model = new $class();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->author = $model->author ? $model->author : Yii::$app->user->identity->username;
            $news=$model->save();
            if ($news) {
                if ($model->tags) {
                    $this->tagCreate($model->tags, $news->id);
                }
                $i18n = Yii::$app->params['i18n'];
                if ($i18n['flag']) {
                    return $this->redirect(['index', 'type' => $news->type, 'i18n'=>true, 'id'=>$news->id]);
                }
                return $this->redirect(['index', 'type' => $news->type]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'type' => $type,
                'tags' => ''
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改资讯
     */
    public function actionUpdate($id, $i18n=false)
    {
        $types = [
            News::TYPE_TEXT => 'text',
            News::TYPE_IMAGE => 'image',
            News::TYPE_VIDEO => 'video'
        ];

        $model = $this->findModel($id);
        if (!in_array($model->type, array_keys($types))) {
            $type = $types[News::TYPE_TEXT];
        } else {
            $type = $types[$model->type];
        }

        $method = 'update' . ucfirst($type);

        $tags = TagRel::getTagsByRes('news', $id);
        $tags = implode(',', ArrayHelper::getColumn($tags, 'tag_name')) ;

        return $this->$method($model, $tags, $i18n);

    }

    /**
     * @name 多语言编辑
     */
    public function actionUpdateLg($id)
    {

        $model = $this->findModel($id);


        $body = '';
        if ($model->type == News::TYPE_TEXT) {
            $ndata = NewsData::findOne($model->id);
            $body = $ndata->body;
        }

        $params = Yii::$app->params['i18n'];
        $lgs = array_keys($params['languages']);
        $data['model'] = $model;
        $lg_models = LgNews::find()->where(['language'=>$lgs])
                            ->andWhere(['news_id'=>$model->id])
                            ->indexBy('language')
                            ->all();

        foreach ($lgs as $v) {
            if (!array_key_exists($v, $lg_models)) {
                $lg_models[$v] = new LgNews();
                $lg_models[$v]->language = $v;
                $lg_models[$v]->news_id = $id;
            }
        }

        if (Model::loadMultiple($lg_models, \Yii::$app->request->post()) && Model::validateMultiple($lg_models)) {

            foreach ($lg_models as $lg_model) {
                $lg_model->save(false);
            }

            return $this->redirect(['index', 'type'=>$model->type]);
        }

        $data['lg_models'] = $lg_models;
        $data['languages'] = $params['languages'];
        $data['body'] = $body;
        return $this->render('update_lg', $data);
    }

    /**
     * @return array
     * @name 批量删除
     */
    public function actionBatchDel()
    {
        $post = Yii::$app->request->post();

        $ses = Yii::$app->getSession();

        if (empty($post['ids'])) {
            return $this->json(null, '请选择要删除的数据 ', 0);
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try{
            Yii::$app->db->createCommand()
                ->delete(News::tableName(),[
                    'id' => $post['ids']
                ])->execute();

            Yii::$app->db->createCommand()
                ->delete(NewsPhoto::tableName(),[
                    'news_id' => $post['ids']
                ])->execute();

            Yii::$app->db->createCommand()
                ->delete(NewsData::tableName(),[
                    'news_id' => $post['ids']
                ])->execute();

            $outerTransaction->commit();

        } catch (Exception $e){
            $outerTransaction->rollBack();
            return $this->json(null, '删除失败', 0);
        }

        $ses->setFlash('success','数据批量删除成功');
        return $this->json();

    }




    protected function updateText($model, $tags, $i18n)
    {
        $class = '\app\modules\news\models\NewsTextForm';
        $formModel = new $class();
        $ndata = NewsData::findOne($model->id);

        if (!$ndata) {
            $ndata = new NewsData();
            $ndata->news_id = $model->id;
        }

        $req = Yii::$app->request;
        $params = Yii::$app->params['i18n'];

        if ($model->load($req->post(), 'NewsTextForm') && $ndata->load($req->post(), 'NewsTextForm')) {

            if ($model->save() && $ndata->save()) {
                $this->tagCreate($model->tags, $model->id);
                if ($params['flag']) {
                    return $this->redirect(['update', 'id' => $model->id, 'i18n'=>$params['flag']]);
                }
                return $this->redirect(['index', 'type' => $model->type]);
            }
        }

        $data = ArrayHelper::toArray($model);

        $formModel->load($data, '');
        $formModel->body = $ndata['body'];

        $data = [
            'model' => $formModel,
            'type' => 'text',
            'tags' => $tags
        ];

        if ($params['flag']) {
            $data['i18n'] = $i18n;
            $data['languages'] = $params['languages'];
            $data['main_language'] = $params['main'];
        }




        return $this->render('update', $data);

    }

    protected function updateImage($model, $tags, $i18n)
    {
        $class = '\app\modules\news\models\NewsImageForm';
        $formModel = new $class();

        $req = Yii::$app->request;

        $params = Yii::$app->params['i18n'];
        if ($model->load($req->post(), 'NewsImageForm')) {
            $post = $req->post();
            $model->thumb = isset($post['cover']) ? $post['cover'] : $model->thumb;
            $model->save();

            $post = $req->post();
            if (isset($post['mid'])) {

                $title = $post['title'];
                $intro = $post['intro'];
                $mid = $post['mid'];

                foreach ($mid as $k => $v) {
                    $data[$v] = [
                        'news_id' => $model->id,
                        'title' => isset($title[$k]) ? $title[$k] : '',
                        'body'  => isset($intro[$k]) ? $intro[$k] : '',
                    ];

                    $pt = NewsPhoto::findOne($v);
                    $pt->load($data[$v], '');
                    $pt->save();
                }
            }

            $this->tagCreate($model->tags, $model->id);

            if ($params['flag']) {
                return $this->redirect(['update', 'id' => $model->id, 'i18n'=>$params['flag']]);
            }
            return $this->redirect(['index', 'type' => $model->type]);
        }

        $data = ArrayHelper::toArray($model);

        $formModel->load($data, '');

        //取出已上传图片

        $imgs = NewsPhoto::find()->where(['news_id'=>$model->id, 'status'=>NewsPhoto::STATUS_NORMAL])->all();

        $data = [
            'model' => $formModel,
            'type' => 'image',
            'imgs' => $imgs,
            'tags' => $tags
        ];

        if ($params['flag']) {
            $data['languages'] = $params['languages'];
            $data['main_language'] = $params['main'];
            $data['i18n'] = $i18n;
        }


        return $this->render('update', $data);
    }

    protected function updateVideo($model, $tags, $i18n)
    {
        $class = '\app\modules\news\models\NewsVideoForm';
        $formModel = new $class();

        $req = Yii::$app->request;

        $params = Yii::$app->params['i18n'];
        if ($model->load($req->post(), 'NewsVideoForm') && $model->save()) {
            $this->tagCreate($model->tags, $model->id);
            if ($params['flag']) {
                return $this->redirect(['update', 'id' => $model->id, 'i18n'=>$params['flag']]);
            }
            return $this->redirect(['index', 'type' => $model->type]);
        }

        $data = ArrayHelper::toArray($model);

        $formModel->load($data, '');

        $datas = [
            'model' => $formModel,
            'type' => 'video',
            'tags' => $tags
        ];

        if ($params['flag']) {
            $datas['i18n'] = $i18n;
            $datas['languages'] = $params['languages'];
            $datas['main_language'] = $params['main'];
        }

        return $this->render('update', $datas);
    }

    /**
     * @param $id
     * @return array
     * @name 推荐
     */
    public function actionRecommend($id)
    {
        $model = $this->findModel($id);
        $model->recommend = $model->recommend ? 0 : 1;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * @param $id
     * @return array
     * @name 置顶
     */
    public function actionTop($id)
    {
        $model = $this->findModel($id);
        $model->is_top = $model->is_top ? 0 : 1;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }


    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();


        $redirect = $_SERVER['HTTP_REFERER'];
        if ($redirect) {
            return $this->redirect($redirect);
        }

        return $this->redirect($_SERVER['']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @name 删除图片资讯图片
     */
    public function actionDelimg($id)
    {
        NewsPhoto::findOne($id)->delete();


        $redirect = $_SERVER['HTTP_REFERER'];
        if ($redirect) {
            return $this->redirect($redirect);
        }

        return $this->redirect($_SERVER['']);
    }

    /**
     * @return array
     * @name 修改图片标题及内容
     */
    public function actionTitDes()
    {
        $post = Yii::$app->request->post();

        $tit = $post['title'];
        $des = $post['desc'];
        $id  = $post['id'];

        $model = NewsPhoto::findOne($id);
        $model->title = $tit;
        $model->body = $des;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * @param $news_id
     * @param $id
     * @return array
     * @name 修改封面
     */
    public function actionCover($news_id, $id)
    {
        $model = $this->findModel($news_id);
        $model->thumb = $id;
        $model->save();

        return $this->json();
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
