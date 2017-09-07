<?php

namespace app\modules\blog\controllers\member;

use app\core\models\TagRel;
use app\core\web\MemberController;
use app\modules\memorial\models\Memorial;
use Yii;
use app\modules\blog\models\Blog;
use app\modules\blog\models\BlogSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Blog model.
 */
class DefaultController extends MemberController
{
    public $homeuid;

    public function init()
    {
        parent::init();

        $this->homeuid = Yii::$app->user->id;
//        $getuid = Yii::$app->request->get('uid');
//        $this->homeuid = isset($getuid) ? $getuid : Yii::$app->user->id;
//
//        if (!User::findOne($this->homeuid)) {
//            //todo 用户不存在报错
//            return $this->error('用户不存在');
//        }
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
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['status'] = [Blog::STATUS_VRIFY,Blog::STATUS_NOVRIFY,Blog::STATUS_NORMAL];
        $params['BlogSearch']['type'] = Blog::TYPE_TEXT;
        $params['BlogSearch']['created_by'] = $this->homeuid;
        $params['BlogSearch']['res'] = [Blog::RES_MISS, Blog::RES_BLOG];//查找追忆和普通博客

        if (isset($params['res'])) {
            $params['BlogSearch']['res'] = $params['res'];
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();
            $model->status = Yii::$app->params['blog']['blogInitStatus'];
            $model->created_by = $this->homeuid;
            if ($model->memorial_id) {
                $model->res = Blog::RES_MISS;
            }


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

        $memorials = Memorial::find()->where(['user_id'=>$this->homeuid])->all();

        $model->type = Blog::TYPE_TEXT;
        $model->privacy = Blog::PRIVACY_PUBLIC;
        return $this->render('create', [
            'model' => $model,
            'memorials' => ArrayHelper::map($memorials, 'id', 'title'),
            'tags' => ''
        ]);
    }

    private function tagCreate($str, $id)
    {
        $str = str_replace('，', ',', $str);
        $tags = explode(',', $str);
        TagRel::addTagRel($tags, 'blog', $id);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->memorial_id) {
            $model->res = Blog::RES_MISS;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $memorials = Memorial::find()->where(['user_id'=>$this->homeuid])->all();

        $tags = TagRel::getTagsByRes('blog', $id);
        $tags = implode(',', ArrayHelper::getColumn($tags, 'tag_name')) ;

        return $this->render('update', [
            'model' => $model,
            'memorials' => ArrayHelper::map($memorials, 'id', 'title'),
            'tags' => $tags
        ]);

    }

    /**
     * Deletes an existing Blog model.
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
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
