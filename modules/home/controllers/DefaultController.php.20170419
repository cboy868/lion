<?php

namespace app\modules\home\controllers;

use app\core\helpers\StringHelper;

use app\modules\cms\models\EmailForm;
use app\modules\home\models\UserForm;
use app\modules\user\models\User;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\shop\models\search\Goods as GoodsSearch;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\core\models\TagRel;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\Message;
use app\modules\home\models\MsgForm;
use app\modules\client\models\Client;




class DefaultController extends HomeController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    // /**
    //  * @inheritdoc
    //  */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'thumb' => [
                'class' => 'app\core\web\ThumbAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionEmail()
    {

        $email = Yii::$app->getRequest()->post('email');

        $model = new EmailForm;

        if ($model->contact($email)) {
            return $this->json(null, 'Thank you for subscription', 1);
        } 
        $errors = $model->getErrors();
        return $this->json(null, $errors['email']['0'], 0);
    }



    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionAboutView($mod, $id)
    {
        $post = postDetail($mod, $id);
        return $this->render('about-view', ['post'=>$post]);
    }

    // public function actionIntro()
    // {
    //     return $this->render('intro');
    // }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }



    public function actionProduct()
    {
        $cates = $this->getCates();
        $attrs = AvRel::attrs();


        return $this->render('product-index', [
            'cates'       => $cates,
            'attrs' => $attrs,
        ]);

    }


    public function actionProductView($id)
    {

        $model = Goods::findOne($id);

        $goods = $model->toArray();


        $attr = $this->getAttr($model);

        $imgs = AttachmentRel::getByRes('goods', $id);


        $rels = $this->getSeries($id);


        return $this->render('product-view', [
            'data'=>$goods, 
            'attr'=> $attr['attr'], 
            'imgs'=>$imgs,
            'series' => $rels
            ]);
    }

    public function actionProductMsg($id)
    {

        $goods = Goods::findOne($id);
        $model = new MsgForm();
        $msg = Yii::$app->params['msg'];
        $msgs = explode("\r\n", $msg);

        $result = [];
        foreach ($msgs as $k => $v) {
            if (!$v) {
                continue;
            }
            $result[$v] = $v;
        }

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['product-view', 'id' => $id]);
        } else {

            $model->title = 'Am interested in '.$goods->name;
            $model->goods_id = $id;
            return $this->render('product-msg', [
                'model' => $model,
                'shortmsg' => $result,
                'goods'=>$goods
            ]);
        }
    }

    /**
     * @name 取系列产品
     */
    private function getSeries($goods_id)
    {
        $rels = TagRel::getReleted('goods', $goods_id);

        $models = Goods::find()->where(['id'=>$rels])->asArray()->all();

        foreach ($models as &$v) {
            $v['img'] = Attachment::getById($v['thumb'], '200x200');
        }unset($v);


        return $models;
    }

    /**
     * @name 获取属性 
     */
    private function getAttr($model)
    {
        return AvRel::getAv($model);
    }


    private function getCates()
    {
        $tree = Category::sortTree();

        foreach ($tree as $k => &$v) {
            $v['url'] = Url::toRoute(['product', 'Goods[category_id]'=>$v['id']]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    public function actionResource()
    {
        return $this->render('resource-list');
    }

    // public function actionResourceView($mod, $id)
    // {
    //     $post = postDetail($mod, $id);
    //     return $this->render('resource-view', ['post'=>$post]);
    // }





}
