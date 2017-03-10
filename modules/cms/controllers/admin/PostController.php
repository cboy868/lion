<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\cms\models\Post;
use app\modules\cms\models\PostForm;
use app\modules\cms\models\PostSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\cms\models\Test;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;

use app\modules\cms\models\Category;
use app\core\helpers\Url;
use app\core\base\Upload;
use app\core\helpers\Html;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BackController
{


//     public function actionTest()
//     {


//         $post = Code::find()->where(['module'=>'post', 'type'=>'model'])->one();


//         $model_code = $post->code;

// $a = str_replace('{modstr}', 5, $a);



//     $b = <<<'A'
// namespace app\modules\cms\models\mods;

// use Yii;
// use yii\base\Model;
// use yii\data\ActiveDataProvider;
// use app\modules\cms\models\mods\Post{modstr};

// class Post{modstr}Search extends Post{modstr}
// {
//     /**
//      * @inheritdoc
//      */
//     public function rules()
//     {
//         return [
//             [['id', 'created_by', 'category_id', 'thumb', 'view_all', 'com_all', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
//             [['title', 'subtitle', 'summary', 'ip', 'author'], 'safe'],
//         ];
//     }

//     /**
//      * @inheritdoc
//      */
//     public function scenarios()
//     {
//         // bypass scenarios() implementation in the parent class
//         return Model::scenarios();
//     }

//     /**
//      * Creates data provider instance with search query applied
//      *
//      * @param array $params
//      *
//      * @return ActiveDataProvider
//      */
//     public function search($params)
//     {
//         $query = Post{modstr}::find();

//         $dataProvider = new ActiveDataProvider([
//             'query' => $query,
//         ]);

//         if (!($this->load($params) && $this->validate())) {
//             return $dataProvider;
//         }

//         $query->andFilterWhere([
//             'id' => $this->id,
//             'author' => $this->author,
//             'category_id' => $this->category_id,
//             'created_by' => $this->created_by,
//             'thumb' => $this->thumb,
//             'view_all' => $this->view_all,
//             'com_all' => $this->com_all,
//             'recommend' => $this->recommend,
//             'created_at' => $this->created_at,
//             'updated_at' => $this->updated_at,
//             'status' => $this->status,
//         ]);

//         $query->andFilterWhere(['like', 'title', $this->title])
//             ->andFilterWhere(['like', 'subtitle', $this->subtitle])
//             ->andFilterWhere(['like', 'summary', $this->summary])
//             ->andFilterWhere(['like', 'ip', $this->ip]);

//         return $dataProvider;
//     }
// }
// A;














//         $classa = eval($a);

//         echo \app\modules\cms\models\mods\Post5::tableName();
//         // echo $classa::className();
//         // $class = eval($b);


//         // // $a = new $class;
//         // // p($a);die;
//         // echo $class::tableName();

//     }













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
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     * @name 文章列表
     */
    public function actionIndex($mod)
    {

        $tree = $this->getCates($mod);

        $modInfo = Module::findOne($mod);
        

        Code::createObj('post', $mod);

        $c = 'Post' . $mod . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;
        
        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;

        if (isset($params['category_id'])) {
            $params[$c]['category_id'] = $params['category_id'];
        }
        
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modinfo' => $modInfo,
            'cates'       => $tree,
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ]);
    }

    /**
     * @name 获取分类
     */
    private function getCates($mod)
    {
        $res_name = 'post' . $mod;
        $tree = Category::sortTree(['res_name'=>$res_name]);

        foreach ($tree as $k => &$v) {
            $v['url'] = $v['is_leaf'] ? Url::toRoute(['index', 'category_id'=>$v['id'], 'mod'=>$mod]) : '#';
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @name 文章详细内容
     */
    public function actionView($id, $mod)
    {

        return $this->render('view', [
            'model' => $this->findModel($id, $mod),
            'modInfo' => Module::findOne($mod)
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加文章
     */
    public function actionCreate($mod)
    {


        Code::createObj('post', $mod);


        $class = '\app\modules\cms\models\mods\Post' . $mod;
        $model = new $class;
        $dataClass = '\app\modules\cms\models\mods\PostData' . $mod;
        $dataModel = new $dataClass;

        $modInfo = Module::findOne($mod);

        $attach = [];
        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'post_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->ip = Yii::$app->request->userIP;
            $model->created_by = Yii::$app->user->identity->id;


            if (empty($model->summary)) {
                $body = Yii::$app->request->post('PostData'.$mod)['body'];
                $model->summary = Html::cutstr_html($body, 50);
            }



            $up = Upload::getInstance($model, 'thumb', 'post'.$mod);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }



            $model->save();

            $class = '\app\modules\cms\models\mods\PostData' . $mod;
            $data = new $class;
            $data->post_id = $model->id;
            $data->body = Yii::$app->request->post('PostData'.$mod)['body'];

            $data->save();

            return $this->redirect(['view', 'id' => $model->id, 'mod'=>$mod]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'attach'=> $attach,
                'modInfo' => $modInfo,
                'dataModel' => $dataModel
            ]);
        }

    }



    /**
     * @name 编辑文章
     */
    public function actionUpdate($id, $mod)
    {

        $model = $this->findModel($id, $mod);
        $class = '\app\modules\cms\models\mods\PostData' . $mod;
        $dataModel = $class::find()->where(['post_id'=>$id])->one();
        $dataModel = $dataModel ? $dataModel : new $class;


        $modInfo = Module::findOne($mod);

        $attach = [];
        if ($mod) {
            $command = (new \yii\db\Query())
                // ->select(['id', 'email'])
                ->from('module_field')
                ->where(['table' => 'post_' . $mod])
                ->createCommand();

            // 返回查询结果的所有行
            $attach = $command->queryAll();
        }

        if ($model->load(Yii::$app->request->post()) && $dataModel->load(Yii::$app->request->post())) {

            $up = Upload::getInstance($model, 'thumb', 'post'.$mod);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            $summary = strip_tags($model->summary);


            if (empty($summary)) {
                $body = Yii::$app->request->post('PostData'.$mod)['body'];
                $model->summary = Html::cutstr_html($body, 50);
            }


            $model->save();
            $dataModel->save();

            return $this->redirect(['view', 'id' => $model->id, 'mod'=>$mod]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'attach'=> $attach,
                'modInfo' => $modInfo,
                'dataModel' => $dataModel
            ]);
        }
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $mod = Yii::$app->getRequest()->get('mod');
        $this->findModel($id, $mod)->delete();

        return $this->redirect(['index', 'mod'=>$mod]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $mod)
    {

        Code::createObj('post', $mod);


        $class = '\app\modules\cms\models\mods\Post' . $mod;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // ------------------------------- 以下部分处理分类 ------------------------------


    /**
     * @name 添加分类
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
            $model->res_name = 'post' . $request->get('mod');

            $model->save();

            return $this->redirect(['index', 'mod'=>$request->get('mod'), 'category_id'=>$request->get('category_id')]);
        } 

        return $this->renderAjax('create-cate', [
            'model' => $model,
        ]);
    }

    /**
     * @name 修改分类
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
