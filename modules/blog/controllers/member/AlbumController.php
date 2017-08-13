<?php

namespace app\modules\blog\controllers\member;

use app\core\web\MemberController;
use app\modules\blog\models\AlbumPhoto;
use app\modules\blog\models\AlbumPhotoSearch;
use Yii;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\memorial\models\Memorial;
use yii\helpers\ArrayHelper;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends MemberController
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
    public $homeuid;

    public function init()
    {
        parent::init();

        $this->homeuid = Yii::$app->user->id;

    }

    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'album-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'blog_album'
            ]
        ];
    }

    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionIndex()
    {

        $params = Yii::$app->request->queryParams;

        $params['AlbumSearch']['user_id'] = Yii::$app->user->id;
        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionPhotos($id)
    {

        $album = Album::findOne($id);
        $params = Yii::$app->request->queryParams;

        $params['AlbumPhotoSearch']['album_id'] = $id;
        $searchModel = new AlbumPhotoSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('photos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $album,
        ]);
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

        $model = AlbumPhoto::findOne($id);
        $model->title = $tit;
        $model->body = $des;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * Displays a single Album model.
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
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Album();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->user->id;
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '添加相册成功');
            } else {
                Yii::$app->session->setFlash('error', '添加相册失败,请重试或联系管理员');
            }

            return $this->redirect(['index']);
        } else {

            $memorials = Memorial::find()->where(['user_id'=>$this->homeuid])->all();
            $model->privacy = Album::PRIVACY_PUBLIC;
            return $this->renderAjax('create', [
                'model' => $model,
                'memorials' => ArrayHelper::map($memorials, 'id', 'title')
            ]);
        }
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '修改相册成功');
            } else {
                Yii::$app->session->setFlash('error', '修改相册失败,请重试或联系管理员');
            }
            return $this->redirect(['index']);
        }

        $memorials = Memorial::find()->where(['user_id'=>$this->homeuid])->all();
        return $this->renderAjax('update', [
            'model' => $model,
            'memorials' => ArrayHelper::map($memorials, 'id', 'title')
        ]);
    }

    /**
     * Deletes an existing Album model.
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
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
