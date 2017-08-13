<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 13:08
 */
namespace app\modules\blog\controllers\member;

use app\modules\blog\models\BlogSearch;
use yii;
use app\modules\blog\models\Blog;
use yii\data\Pagination;
use app\modules\user\models\User;


class DefaultController extends \app\core\web\MemberController
{

    public $homeuid;

    public function init()
    {
        parent::init();
        $getuid = Yii::$app->request->get('uid');
        $this->homeuid = isset($getuid) ? $getuid : Yii::$app->user->id;

        if (!User::findOne($this->homeuid)) {
            //todo 用户不存在报错
            return $this->error('用户不存在');
        }
    }

    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {

        $searchModel = new BlogSearch();
        $params = Yii::$app->request->queryParams;
        $params['BlogSearch']['status'] = [Blog::STATUS_VRIFY,Blog::STATUS_NOVRIFY,Blog::STATUS_NORMAL];
        $params['BlogSearch']['type'] = Blog::TYPE_TEXT;
        $params['BlogSearch']['created_by'] = $this->homeuid;
        $params['BlogSearch']['res'] = [Blog::RES_MISS, Blog::RES_BLOG];//查找追忆和普通博客

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView()
    {
        $this->layout = "@app/modules/member/views/layouts/profile.php";
        return $this->render('view');
    }


    /**
     * @return string
     * @name 添加blog
     */
    public function  actionCreate()
    {

        $model = new Blog();
        $req = \Yii::$app->request;
        if ($model->load($req->post())) {
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->type = Blog::TYPE_TEXT;
            $model->created_by = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect(['/blog/member/default/view', 'id'=>$model->id]);
            }
        }

        $model->loadDefaultValues();
        return $this->render('create', ['model'=>$model]);
    }

    /**
     * @name 修改blog
     */
    public function  actionUpdate($id)
    {
        $model = Blog::findOne($id);
        if (!$model) {
            return $this->error('不存在此博客');
        }

        $req = \Yii::$app->request;

        if ($model->load($req->post())) {
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->type = Blog::TYPE_TEXT;
//            $model->created_by = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect(['/blog/member/default/view', 'id'=>$model->id]);
            }
        }

        return $this->render('update', ['model'=>$model]);
    }

    /**
     * 删除
     */
    public function actionDel($id)
    {
        $model = Blog::findOne($id);
        $model->status = Blog::STATUS_DEL;
        if ($model->save()) {
            return $this->json();
        }
        return $this->json(null, '删除失败', 0);
    }
}
