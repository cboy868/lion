<?php

namespace app\modules\memorial\controllers\home;

use app\core\helpers\ArrayHelper;
use app\core\helpers\Url;
use app\core\models\Comment;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use app\modules\blog\models\AlbumPhotoSearch;
use app\modules\blog\models\AlbumSearch;
use app\modules\blog\models\Blog;
use app\modules\cms\controllers\home\CommonController;
use app\modules\grave\models\Order;
use app\modules\memorial\models\OrderForm;
use app\modules\memorial\models\Pray;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Sku;
use app\modules\user\models\Track;
use app\modules\wechat\models\User;
use EasyWeChat\Payment\Payment;
use yii;
use app\modules\memorial\models\Memorial;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\BlogSearch;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as WechatOrder;

use Endroid\QrCode\QrCode;
class HallController extends Controller
{
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

    public function actionIndex($id)
    {


        $memorial = $this->findModel($id);
        $deads = $memorial->deads;

        //档案及追忆
        //档案
        $archives = Blog::find()->where([
            'memorial_id'=>$id,
            'status'=>Blog::STATUS_NORMAL,
            'privacy' => Blog::PRIVACY_PUBLIC,
            'res' =>Blog::RES_ARCHIVE
        ])
            ->orderBy('id desc')->limit(10)->all();

        //追忆
        $miss = Blog::find()->where([
            'memorial_id'=>$id,
            'status'=>Blog::STATUS_NORMAL,
            'privacy' => Blog::PRIVACY_PUBLIC,
            'res' =>Blog::RES_MISS
        ])
            ->orderBy('id desc')->limit(10)->all();


        //祝福
        $msgs = Comment::find()->where(['res_name'=>'memorial', 'res_id'=>$id, 'pid'=>0])
            ->orderBy('id desc')
            ->limit(10)->all();


        $memorial->track();

        return $this->render('index',[
            'memorial' => $memorial,
            'deads' => $deads,
            'archives' => $archives,
            'miss' => $miss,
            'msgs' => $msgs
        ]);
    }


    public function actionMemorial($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $tracks = Track::find()->where(['res_name'=>Track::RES_MEMORIAL, 'res_id'=>$id])
            ->orderBy('id desc')
            ->limit(20)
            ->all();


        $albums = Album::find()->where(['memorial_id'=>$id,'privacy'=>Album::PRIVACY_PUBLIC])
            ->orderBy('id desc')->limit(10)->all();
        $albums_ids = ArrayHelper::getColumn($albums, 'id');
        $photos = AlbumPhoto::find()->where(['album_id'=>$albums_ids, 'status'=>AlbumPhoto::STATUS_ACTIVE])
            ->limit(10)->all();


        $miss = Blog::find()->where(['res'=>Blog::RES_MISS, 'memorial_id'=>$id])
            ->orderBy('id desc')
            ->limit(8)
            ->all();

        //祝福
        $msgs = Comment::find()->where(['res_name'=>'memorial', 'res_id'=>$id, 'pid'=>0])
            ->orderBy('id desc')
            ->limit(10)->all();

        //点烛献花
        $prays = Pray::find()->where(['memorial_id'=>$id])->orderBy('id desc')
            ->limit(10)
            ->all();

        return $this->render('memorial', [
            'memorial'=>$memorial,
            'tracks' => $tracks,
            'photos' => $photos,
            'miss' => $miss,
            'msgs' => $msgs,
            'prays' => $prays,
            'comment' => new Comment()
        ]);
    }

    /**
     * @name 生平
     * @return string
     */
    public function actionLife($id)
    {

        $memorial = $this->findModel($id);
        $memorial->track();
        $deads = $memorial->deads;
        return $this->render('life', [
            'deads' => $deads,
            'memorial' => $memorial
        ]);
    }

    /**
     * @音容笑貌
     */
    public function actionAlbum($id)
    {
        $params = Yii::$app->request->queryParams;

        $params['AlbumSearch']['memorial_id'] = $id;
        $params['AlbumSearch']['privacy'] = Album::PRIVACY_PUBLIC;

        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->searchHome($params);

        $memorial = $this->findModel($id);
        $memorial->track();

        return $this->render('album', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionPhotos($album_id)
    {
        $album = Album::findOne($album_id);
        $album->track();

        $params = Yii::$app->request->queryParams;

        $params['AlbumPhotoSearch']['album_id'] = $album_id;
        $searchModel = new AlbumPhotoSearch();
        $dataProvider = $searchModel->searchHome($params);

        return $this->render('photos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $album,
        ]);

    }

    /**
     * @name 档案资料
     */
    public function actionArchive($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['res'] = Blog::RES_ARCHIVE;
        $params['BlogSearch']['memorial_id'] = $id;
        $params['BlogSearch']['privacy'] = Blog::PRIVACY_PUBLIC;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->homeSearch($params);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);
    }

    public function actionArchiveView($bid, $id)
    {
        $model = Blog::findOne($bid);
        $model->track(Track::RES_ARCHIVE);

        return $this->render('archive-view',[
            'model' => $model
        ]);
    }

    public function actionMissView($bid, $id)
    {
        $model = Blog::findOne($bid);
        $model->track(Track::RES_MISS);

        return $this->render('miss-view',[
            'model' => $model
        ]);
    }

    /**
     * @name 生前作品
     */
    public function actionWorks()
    {
        return $this->render('works');
    }

    /**
     * @name 追思文章
     */
    public function actionMiss($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['res'] = Blog::RES_MISS;
        $params['BlogSearch']['memorial_id'] = $id;
        $params['BlogSearch']['privacy'] = Blog::PRIVACY_PUBLIC;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->homeSearch($params);

        return $this->render('miss', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);
    }


    /**
     * @name 微纪念
     */
    public function actionMsg($id)
    {
        $memorial = $this->findModel($id);
        $comment = new Comment();

        //取评论
        $comments = Comment::getByRes('memorial', $id, 15, '45x45');

        $memorial->track();
        return $this->render('msg',[
//            'model' => $memorial,
            'comment' => $comment,
            'comments' => $comments
        ]);
    }

    public function actionReplyMsg()
    {
        if (Yii::$app->user->isGuest) {
            return $this->json(null, '请先登录', 0);
        }

        $post = Yii::$app->request->post();


        $data = [
            'from' => Yii::$app->user->id,
            'to' => $post['to'],
            'content' => $post['content'],
            'pid' => $post['pid'],
            'res_name' => $post['res_name'],
            'res_id' => $post['res_id'],
            'privacy' => Comment::PRIVACY_PUBLIC
        ];

        $msg = new Comment();
        $msg->load($data, '');
        if ($msg->save() !== false) {
            return $this->json();
        }

        return $this->json(null, '回复失败',0);

    }

    public function actionCreateMsg()
    {
        $model = new Comment();
        $req = Yii::$app->getRequest();


        $model->load($req->post());

        $model->from = Yii::$app->user->id;
        $model->to = 0;
        $model->privacy = Comment::PRIVACY_PUBLIC;

        if ($model->save() !== false) {
            return $this->json();
        } else {
            return $this->json(null, '祝福留言失败,请重试或联系管理员', 0);
        }
    }

    public function actionCandleFlower($id)
    {
        $model = new Pray();
        $model->memorial_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;

            if ($model->save() !== false) {
                return $this->json();
            } else {
                return $this->json(null, '祝福提交失败', 0);
            }
        }

        $types = $this->module->params['memorial_types'];

        return $this->renderAjax('candle-flower',[
            'model' => $model,
            'types' => $types
        ]);
    }

    public function actionRemote($mid)
    {

        $goods = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE,'can_remote'=>1])->all();
        $cids = ArrayHelper::getColumn($goods, 'category_id');
        $cates = Category::find()->where(['id'=>$cids])->all();
        $goods = ArrayHelper::index($goods, 'id', 'category_id');

        return $this->renderAjax('remote',[
            'goods' => $goods,
            'cates' => $cates,
            'memorial_id' => $mid
        ]);
    }

    /**
     * @name 设置购买参数
     */
    public function actionSet($mid, $gid)
    {
        $goods = Goods::findOne($gid);
        $set = new OrderForm();
        $set->use_time = date('Y-m-d', strtotime('+1 day'));
        return $this->renderAjax('set',[
            'goods' => $goods,
            'model' => $set,
            'memorial_id' => $mid
        ]);
    }

    public function actionQrGoods($id, $sku_id, $num, $use_time)
    {

        $memorial = $this->findModel($id);

        $proid = $memorial->tomb_id .'.'.$sku_id . '.' .$num . '.' . $use_time;


        $wechat_cfg = Yii::$app->params['wechat']['wx'];

        $oAttr = [
            'product_id' =>$proid,
            'appid' => 'wxc90847ac1a02b8a3',//$wechat_cfg['appid'],
            'mch_id' => '1458026302',
            'time_stamp' => time(),
            'nonce_str' => uniqid(),
        ];
        $key = '923556';

        $sign = \EasyWeChat\Payment\generate_sign($oAttr, $key);

        $oAttr['sign'] = $sign;



        $url = Payment::SCHEME_PATH .'?'. http_build_query($oAttr);


        $qrCode = new QrCode($url);

        header('Content-Type: '.$qrCode->getContentType());

        echo $qrCode->writeString();
    }

    //proid由 tomb_id, sku_id num数量组成

    /**
     * @param $proid
     * 微信扫码回调此方法生成订单
     */
    public function actionOrder($proid)
    {
//        $pd = explode('_', $proid);
//
//        $tomb_id = $pd[0];
//        $sku_id = $pd[1];
//        $num = $pd[2];
//        $use_time = $pd[3];
//
//        $sku = Sku::findOne($sku_id);
//
//        $openid = '';
//
//        $wuser = User::findOne($openid);
//
//        $extra = [
//            'type' => Order::TYPE_TOMB,
//            'tid' => $tomb_id,
//            'num' => $pd[2],
//            'use_time' => $pd[3]
//        ];
//
//        $oinfo = $sku->order($wuser->user_id, $extra);

        $oAttr = [
            'a' =>1,
            'b' => 2,
            'c' => 'abc'
        ];
        $key = 1;

        $sign = \EasyWeChat\Payment\generate_sign($oAttr, $key);

        $url = Payment::SCHEME_PATH;//


//        weixin：//wxpay/bizpayurl?sign=XXXXX&appid=XXXXX&mch_id=XXXXX&product_id=XXXXXX&time_stamp=XXXXXX&nonce_str=XXXXX



        $arr = [
            'sign' => $sign,
            'appid' => 1,
            'mch_id' => 2,
            'product_id' =>12,
            'time_stamp' => time(),
            'nonce_str' =>uniqid()
        ];

        $url = $url .'?'. http_build_query($arr);
        echo $url;die;

        echo $sign;
        die;


        $options = [
            // 前面的appid什么的也得保留哦
            'app_id' => 'xxxx',
            // ...
            // payment
            'payment' => [
                'merchant_id'        => 'your-mch-id',
                'key'                => 'key-for-signature',
                'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
                'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
                'notify_url'         => '默认的订单回调地址',       // 你也可以在下单时单独设置来想覆盖它
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
                // ...
            ],
        ];
        $app = new Application($options);

        $userService = $app->user;


        $payment = $app->payment;

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388, // 单位：分
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new WechatOrder($attributes);







        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        //接下来使用统一下单接口
    }


    public function actionRecord()
    {
        return $this->render('record');
    }

    protected function findModel($id)
    {
        if (($model = Memorial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
