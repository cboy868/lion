<?php

namespace app\modules\grave\controllers\home;

use yii;
use app\modules\grave\helpers\InsHelper;
use app\modules\grave\models\InsProcess;
use app\modules\grave\models\Process;
use app\modules\grave\models\InsCfgCase;
use app\modules\shop\models\Goods;



class ProcessController extends \app\core\web\HomeController
{

	public function init()
	{
		Process::$tomb_id = Yii::$app->request->get('tomb_id');
		parent::init();
	}

    public function actionSel()
    {

    	$query = Yii::$app->request->get();

    	$model = Process::insProcess();

    	$num = $model->getDeadCount();

    	// p($model->getDead());die;


        if ($num==0) {
            $this->json(null, '请填写逝者信息');
        }

        $model->handleIns();

        $info = $model->getCfgIns($query['case_id']);

        // p($info);die;


        if ($info['is_front']==1) {
            // $god = $this->Ins->getIsGod($this->tomb_id);
            $shape = $model->shape;
            $god = 0;
            // if ($god) {
            //     $god = $shape == 'v' ? 1 : 2;
            // }
            $direct = 'front';
        } else if ($info['is_front'] == '2') {
            $direct = 'cover';
        } else {
            $direct = 'back';
        }


        $font = $model->getFont();

        $pre_path = 'upload/ins/tmp/'. Process::$tomb_id . $direct. uniqid() . '.png';

        InsHelper::showImg($info['data'], $info['size'][0], $info['size'][1], $font, $pre_path);

        return $this->json('/'.$pre_path, null, 1);
    }


    public function actionPrice($tomb_id, $case_id)
    {
        $model = Process::insProcess();

        $model->handleIns();
        $data = $model->combinDbData($case_id);

        $case = InsCfgCase::findOne($case_id);

        $is_front = $case->cfg->is_front;

        $price = $this->calPrice($data, $is_front);

        $price['is_front'] = $is_front;

        return $this->json($price);

    }

    public function calPrice($data, $is_front=0){



        p($data);die;
        $model = Process::insProcess();
        $post = Yii::$app->request->post();

        $is_tc = $post['is_tc'];
        $paint = $post['ins']['paint'];


        // $per_price = $this->Ins->getFontPrice($paint, $this->tomb_id);

        $font_price = $this->module->params['ins']['fee'];

        $per_price = 10;

        $result = array();

        if (array_key_exists('main', $data)){
            foreach ($data as $k=>$v) {
                $count = 0;
                if ($k == 'main'){
                    foreach ($v['content'] as $val){
                        $count += self::getFontNum($val);
                    }
                } else {
                    $count += self::getFontNum($v['content']);
                }
                
                $result['count'] += $count;
                $result['letter'] += $per_price * $count;
            }
        } else {
            foreach ($data as $k=>$v) {
                foreach ($v as $key=>$val){
                    if ($key == 'inscribe_date' && $model->shape=='v') {
                        $count = self::getFontNum($val['content'], true);
                    } else {
                        $count = self::getFontNum($val['content']);
                    }

                    $result['count'] += $count;

                    $result['letter'] += $per_price * $count;
                }
            }
        }

        if ($paint == 4) {
            $result['letter'] = $is_front == 1 ? $per_price : 0;
        }
        $result['count'] = ceil($result['count']);

        $result['tc_fee'] = 0;
        $result['per_price'] = $per_price;

        $is_second = $model->is_stand ? true : false;


        if($is_tc && $paint!=4 && !$is_second) {
            $tc_goods_id = $this->module->params['goods']['id']['tc'];
            $goods = Goods::findOne($tc_goods_id);
            $result['tc_fee'] = $goods->price;
        }

        return $result;
    }
   

    public static function getFontNum($str, $flag = false)
    {
        $tmp = str_replace(array('.','&nbsp;',',','、',' ','，','－', '—', '-', '|', '｜'),'',$str);
        $total = mb_strlen($tmp);

        if ($flag) {
            return mb_strlen($tmp, 'utf-8');
        }

        $utf = mb_strlen($tmp, 'UTF-8');

        $o_count = substr_count($tmp, 'O'); // o字母个数

        $c_count = ($total - $utf)/2;  //汉字个数

        $n_count = ($utf - $c_count - $o_count)/2;//数字个数除2, 两个数字计为一个字

        return $c_count + $n_count + $o_count; //换算过的字数;
    }

    public function fontprice($paint, $tomb_id)
    {

        $get = Yii::$app->request->get();


        $model = Process::insProcess();

        // $per_price = $model->getFontPrice($paint, $tomb_id);
        $per_price = 10;

        if ($paint == 4) {
            return $this->json(array('price'=>$per_price), null, 1);
        }

        return $this->json(array('price'=>$get['font_num'] * $per_price), null, 1);
    }
}
