<?php

namespace app\modules\news\controllers\admin;

use Yii;
use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use app\modules\news\models\NewsPhoto;
use app\modules\news\models\NewsSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\helpers\ArrayHelper;

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
            // 'web-upload' => [
            //     'class' => 'app\core\web\WebuploadAction',
            // ],
            'web-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'news',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type="text")
    {
        if (!in_array($type, ['text', 'image', 'video'])) {
            $type = 'text';
        }

        $class = '\app\modules\news\models\News' . ucfirst($type) . 'Form';

        $model = new $class();

        if ($model->load(Yii::$app->request->post()) ) {
            $news=$model->save();
            if ($news) {
                return $this->redirect(['index', 'type' => $news->type]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'type' => $type
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
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

        return $this->$method($model);

    }


    public function updateText($model)
    {
        $class = '\app\modules\news\models\NewsTextForm';
        $formModel = new $class();
        $ndata = NewsData::findOne($model->id);

        $req = Yii::$app->request;

        if ($model->load($req->post(), 'NewsTextForm') && $ndata->load($req->post(), 'NewsTextForm')) {
            if ($model->save() && $ndata->save()) {
                return $this->redirect(['index', 'type' => $model->type]);
            }
        }

        $data = ArrayHelper::toArray($model);

        $formModel->load($data, '');
        $formModel->body = $ndata['body'];

        return $this->render('update', [
            'model' => $formModel,
            'type' => 'text'
        ]);

    }

    public function updateImage($model)
    {
        $class = '\app\modules\news\models\NewsImageForm';
        $formModel = new $class();

        $req = Yii::$app->request;

        if ($model->load($req->post(), 'NewsImageForm') && $model->save()) {

            $model->thumb = isset($post['cover']) ? $post['cover'] : $model->thumb;

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

            return $this->redirect(['index', 'type' => $model->type]);
        }

        $data = ArrayHelper::toArray($model);

        $formModel->load($data, '');

        //取出已上传图片

        $imgs = NewsPhoto::find()->where(['news_id'=>$model->id, 'status'=>NewsPhoto::STATUS_NORMAL])->all();

        return $this->render('update', [
            'model' => $formModel,
            'type' => 'image',
            'imgs' => $imgs
        ]);
    }

    public function updateVideo($model)
    {

    }

    public function actionRecommend($id)
    {
        $model = $this->findModel($id);
        $model->recommend = $model->recommend ? 0 : 1;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

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

    public function actionDelimg($id)
    {
        NewsPhoto::findOne($id)->delete();


        $redirect = $_SERVER['HTTP_REFERER'];
        if ($redirect) {
            return $this->redirect($redirect);
        }

        return $this->redirect($_SERVER['']);
    }

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
