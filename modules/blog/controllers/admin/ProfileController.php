<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Blog;
use app\modules\blog\models\BlogSearch;
use Yii;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\memorial\models\Memorial;
use app\core\models\TagRel;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for Task model.
 */
class ProfileController extends BackController
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $params = Yii::$app->request->queryParams;
        $params['BlogSearch']['created_by'] = Yii::$app->user->id;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $tags = TagRel::getTagsByRes('blog', $id);
        $tags = implode(',', ArrayHelper::getColumn($tags, 'tag_name')) ;
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'tags' => $tags
        ]);
    }


    public function actionCreate()
    {
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();
            $model->status = Yii::$app->params['blog']['blogInitStatus'];
            $model->created_by = Yii::$app->user->id;


            if ($model->save() !== false) {
                if ($model->tags) {
                    $this->tagCreate($model->tags, $model->id);
                }
                Yii::$app->session->setFlash('success', '添加博客成功');
            } else {
                Yii::$app->session->setFlash('error', '添加博客失败,请重试或联系管理员');
            }

            return $this->redirect(['index']);
        }

        $model->type = Blog::TYPE_TEXT;
        $model->privacy = Blog::PRIVACY_PUBLIC;
        return $this->renderAjax('create', [
            'model' => $model,
            'tags' => ''
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->tags) {
                $this->tagCreate($model->tags, $model->id);
            }
            return $this->redirect(['index']);
        }

        $tags = TagRel::getTagsByRes('blog', $id);
        $tags = implode(',', ArrayHelper::getColumn($tags, 'tag_name')) ;

        return $this->renderAjax('update', [
            'model' => $model,
            'tags' => $tags
        ]);

    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Blog::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }


    private function tagCreate($str, $id)
    {
        $str = str_replace('，', ',', $str);
        $tags = explode(',', $str);
        TagRel::addTagRel($tags, 'blog', $id);
    }

    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
