<?php

namespace app\modules\test\controllers\admin;



use app\core\models\TagRel;
use app\core\libs\Fpdf;
use app\modules\order\models\Order;
use app\modules\shop\models\Sku;
use app\modules\sys\models\Msg;
use app\modules\task\models\Task;
use app\modules\user\models\UserSearch;
use app\modules\wechat\models\Template;
use yii;
use kartik\export\ExportMenu;
use EasyWeChat\Foundation\Application;

class DefaultController extends \app\core\web\BackController
{

    public function actionA()
    {
        Msg::batch();
    }



    public function actionIndex()
    {


        $order = Order::findOne(2);
        Msg::create($order, 'order', '测试消息', Msg::TYPE_SMS);

//        Task::createConfirmGoodsTask(107, 'ins', '1');

//        Task::createGoodsTask(26);


    	// \Yii::$app->mailer->compose('@app/modules/test/views/admin/default/index', ['conaaa' => '测试邮件内容'])
			  //     ->setFrom('cboy868@163.com')
			  //     ->setTo('cboy868@163.com')
			  //     ->setSubject('这里有点内容')
			  //     ->send();


    	// TagRel::addTagRel(['朋友情'], 'news', 4);
        return $this->render('index');
    }

    public function actionLog()
    {
//        Yii::trace('abc', __METHOD__);
//        Yii::info('info', __METHOD__);
//        Yii::error('error', __METHOD__);
//        Yii::warning('warning', __METHOD__);
    }

    public function actionExcel()
    {
        \app\core\libs\PHPExcel::export();
    }


    public function actionEx()
    {
        \app\core\libs\PHPExcel::import(\Yii::getALias('@app/core/libs/01simple.xlsx'));
    }

    public function actionLongContent()
    {
        $str = <<<STR
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
STR;


        $arr = Fpdf::bodyLn($str, 45, [10,50]);


        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','楷体_GB2312'); //这个一定要有，否则无法使用 $pdf->SetFont(); 


        foreach($arr['content'] as $v){
         $pdf->setXY($v['x'],$v['y']);
         $pdf->SetFont($v['font'],$v['b'],$v['font_size']); 
         $pdf->cell(10,10, $v['content']);
        }

        $y = $arr['y'];

        $pdf->setXY(10,$y);
        $pdf->cell(10,10, 'hello world');


        ob_end_clean();
        $pdf->Output();

    }

    public function actionPdfContent()
    {

        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','楷体_GB2312'); //这个一定要有，否则无法使用 $pdf->SetFont();

        $content = array(
            array("content" => "收款收据（销售）","y" => 10,"x" => 90,"b" => true ,"font_size" => 10),
            array("content" => "日期：","y" => 15,"x" => 49,"b" => false ,"font_size" => 8),

            array("content" => date("Y年m月d日"),"y" => 15,"x" => 58,"b" => false ,"font_size" => 8),
            array("content" => "单据编号：","y" => 15,"x" => 118,"b" => false ,"font_size" => 8),
            
            array("content" => "交款人","y" => 21,"x" => 35,"b" => false ,"font_size" => 8),

            array("content" => "收款单位","y" => 21,"x" => 91,"b" => false ,"font_size" => 8),
            //收款单位
            array("content" => "仙鹤岭公墓","y" => 20,"x" => 115,"b" => false ,"font_size" => 8),
            array("content" => "收款项目","y" => 21,"x" => 146,"b" => false ,"font_size" => 8),
            //收款项目
            array("content" => "销售","y" => 21,"x" => 171,"b" => false ,"font_size" => 8),

            array("content" => "墓地地址","y" => 28,"x" => 50,"b" => false ,"font_size" => 8),
        );

        $result = Fpdf::content($content);

        foreach($result as $v){
            $pdf->setXY($v['x'],$v['y']);
            $pdf->SetFont($v['font'],$v['b'],$v['font_size']); 
            $pdf->cell(10,10, $v['content']);
        }
        
        ob_end_clean();
        $pdf->Output();

    }

    public function actionPdfTable()
    {
        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);

        $table = [
            [
                [10,10],//起始 x y
                [50,9],//长 高
                [20,9],
                [10,9],
                [60,9]
            ],//第一排
            [
                [10,19],//起始 x y
                [30,9],
                [30,9],
                [50,9]
            ],//第二排
        ];

        $tableArr = Fpdf::table($table, 1, 30);

        foreach ($tableArr as $v){
            $pdf->SetXY($v['x'],$v['y']);
            $pdf->cell($v['w'],$v['h'], '', 1);
        }

        ob_end_clean();
        $pdf->Output();

    }

    public function actionOrder()
    {
        $sku = Sku::findOne(47);
        $sku->order(1);
    }

    public function actionTask()
    {
        \app\modules\task\models\Task::create(20,'tomb', 11);
    }

    public function actionCard()
    {
        \app\modules\grave\models\Card::initCard(5, 21);
    }

    public function actionUser()
    {
        $searchModel = new UserSearch();

        $params = Yii::$app->request->queryParams;
        if (isset($params['is_staff'])) {
            $params['UserSearch']['is_staff'] = $params['is_staff'];
        }
        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->el($dataProvider, ['title'=>'abc','filename'=>'user','pageTitle'=>'pagetitles']);
        }

        return $this->render('user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function el($dataProvider, $options)
    {
        \app\core\libs\PHPExcel::export($dataProvider,['id', 'username','created_at:datetime',

            [
                'label'=>'abc',
                'value' => function($model){
                    return $model->username;
                }
            ]
            ], $options);
    }

    public function actionWechat()
    {

        $data = array(
            "keyword1"   => "2016-08-10",
            "keyword2"  => "张三",
            "keyword3"   => "园内",
            "keyword4"  => "选墓",
        );

        Template::send($data, Template::TPL_YUYUE, 1);


//
//        $options = $this->getOptions();
//        $app = new Application($options);
//        $notice = $app->notice;
//
//
//
//
//        $messageId = $notice->send([
//            'touser' => 'ofYkL1rwpqdx4Ug6OvNhg5EbUTcw',
//            'template_id' => '-8kRYGW0y3OgnZMwGbxrsiJus3MPt_zvQJ1-NLAm3ts',
//            'url' => 'http://lion.ibagou.com',
//            'data' => $data
//        ]);
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
}
