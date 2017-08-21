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
use app\modules\grave\models\Tomb;
use app\modules\memorial\models\OrderForm;
use app\modules\memorial\models\Pray;
use app\modules\order\models\Pay;
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

    public function beforeAction($action) {

        $currentaction = $action->id;
        $novalidactions = ['order','notify'];

        if(in_array($currentaction,$novalidactions)) {

            $action->controller->enableCsrfValidation = false;

        }
        parent::beforeAction($action);
        return true;
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

        $option = $this->getOptions();

        $app = new Application($option);

        $payment = $app->payment;

        $url = $payment->scheme($proid);

        $qrCode = new QrCode($url);

        header('Content-Type: '.$qrCode->getContentType());

        echo $qrCode->writeString();
    }

    //proid由 tomb_id, sku_id num数量组成

    /**
     * @param $proid
     * 微信扫码回调此方法生成订单
     */
    public function actionOrder()
    {
        $option = $this->getOptions();

        $app = new Application($option);

        $payment = $app->payment;

        return $payment->handleScanNotify(function($pro_id,$openid) use ($payment){
            $arr = explode('.', $pro_id);
            $sku_id = $arr[1];
            $sku = Sku::findOne($sku_id);
            $extra = [
                'tid' => $arr[0],
                'num' => $arr[2],
                'use_time' => $arr[3]
            ];
            $tomb = Tomb::findOne($arr[0]);

            $oInfo = $sku->order($tomb->user_id, $extra);
            if (!$oInfo) {
                Yii::error($pro_id.'订单创建失败',__METHOD__);
                return false;
            }
            $rel = $oInfo['rel'];
            $order = $oInfo['order'];

            $pay = Pay::create($order);

            if (!$pay) {
                Yii::error('订单'.$order->id.'创建支付记录失败',__METHOD__);
                return false;
            }
            $attr = [
                'trade_type' => 'NATIVE',
                'body' => $rel->title,
                'detail' => $rel->title,
                'out_trade_no'     => $pay->order_no,
                'total_fee'        => $order->price * 100,
                'openid'           => $openid
            ];
            $order = new WechatOrder($attr);
            $result = $payment->prepare($order);

            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                return $result->prepay_id;
            }

            return false;
        });

    }
    private function getOptions()
    {
        $params  = Yii::$app->getModule('wechat')->params;

        $options = [
            'debug'  => $params['debug'],
            'log' => $params['log'],
            'app_id' => $params['wx']['appid'],
            'secret' => $params['wx']['appsecret'],
            'token' => $params['wx']['token'],
            'payment' => [
                'merchant_id'        => $params['payment']['merchant_id'],
                'key'                => $params['payment']['key'],
                'cert_path'          => $params['payment']['cert_path'], // XXX: 绝对路径！！！！
                'key_path'           => $params['payment']['key_path'],      // XXX: 绝对路径！！！！
                'notify_url'         => $params['payment']['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
            ],
        ];


        return $options;
    }

    public function actionNotify()
    {
        $option = $this->getOptions();

        $app = new Application($option);

        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单

Yii::error($notify);
            $pay = Pay::find()->where(['order_no'=>$notify->out_trade_no])->one();


            if (!$pay) { // 支付记录不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            Yii::error($pay);
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($pay->pay_result == Pay::RESULT_FINISH) {
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                $pay->pay(Pay::METHOD_WECHAT, $notify->total_fee);
            } else { // 用户支付失败
                $pay->status = Pay::STATUS_FAIL;
                $pay->save();
            }
            return true; // 返回处理完成
        });

        return $response;
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
