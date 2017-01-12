<?php

namespace app\modules\member\controllers;

use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\member\models\LoginForm;
use app\modules\cms\models\Favor;
use app\modules\user\models\Log;
use app\modules\user\models\Addition;
use app\modules\user\models\Log as LoginLog;

class DefaultController extends \app\core\web\MemberController
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'error', 'signup', 'logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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



// public function addFav()
//     {

//         $filter = array(
//             'res_id'    => $this->_get('res_id', 'intval'),
//             'res_name'  => $this->_get('res_name', 'trim'),
//             'user_id'   => $this->uid
//         );

//         if ($this->fav_model->where($filter+array('status'=>1))->find()) {
//             $this->ajaxReturn(null, '您已经收藏过了', 0);
//         }

//         $data = $filter + array('add_time' => date('Y-m-d H:i:s'));
//         if ($this->fav_model->add($data)) {
//             $count = $this->fav_model->getCountByResId($data['res_name'], $data['res_id']);
//             $this->ajaxReturn(array('count'=>$count), null, 1);
//         } else {
//             $this->ajaxReturn(null, '收藏失败', 0);
//         }
//     }


    public function actionFavor()
    {

        $post = Yii::$app->request->post();

        $filter = [
            'res_name' => $post['res_name'],
            'res_id'   => $post['res_id'],
            'user_id' => Yii::$app->user->id 
        ];

        // if (Favor::find()->where($filter)->one()) {
        //     return $this->json(null, '您已收藏成功', 0);
        // }



        $favor = new Favor;

        if ($favor->load($post, '')) {
            $favor->user_id = Yii::$app->user->id;

            if ($favor->save()) {

                $count = Favor::getCountByRes($post['res_name'], $post['res_id']);

                return $this->json(['count'=>$count], '收藏成功', 1);
            }
        }

        return $this->json(null, '收藏失败,请稍后重试', 0);
    }

    /**
     * @name 管理后台首页
     */
    public function actionIndex()
    {
        $this->layout = false;
        return $this->render('index');
    }

    public function actionPanel()
    {


        $total['favor'] = Favor::find()->where(['user_id'=>Yii::$app->user->id])->count();


        return $this->render('panel', [
                'log' => Log::getLast(),
                'addition' => Yii::$app->user->identity->addition,
                'user' => Yii::$app->user->identity,
                'total' => $total,
            ]);
    }


    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            LoginLog::create();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actions()
    {       
        return  [   
                'captcha' => 
                   [
                       'class' => 'yii\captcha\CaptchaAction',
                       'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                   ],  //默认的写法
            // 'captcha' => [
            //             'class' => 'yii\captcha\CaptchaAction',
            //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            //             'backColor'=>0xebf2fd,//背景颜色
            //             'maxLength' => 6, //最大显示个数
            //             'minLength' => 5,//最少显示个数
            //             'padding' => 5,//间距
            //             'height'=>42,//高度
            //             'width' => 100,  //宽度  
            //             'foreColor'=>0x345180,     //字体颜色
            //             'offset'=>1,        //设置字符偏移量 有效果
            //             //'controller'=>'login',        //拥有这个动作的controller
            //     ],
        ];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
