<?php

namespace app\modules\grave\controllers\home;

use yii;
use app\modules\grave\helpers\InsHelper;
use app\modules\grave\models\InsProcess;
use app\modules\grave\models\Process;
use app\modules\grave\models\InsCfgCase;
use app\modules\shop\models\Goods;



class InsController extends \app\core\web\HomeController
{

	public function init()
	{
		Process::$tomb_id = Yii::$app->request->get('tomb_id');
		parent::init();
	}

    public function actionFreeSel()
    {

        $query = Yii::$app->request->get();

        $model = Process::insPro();

        $num = $model->deadCount();

        if ($num==0) {
            $this->json(null, '请填写逝者信息');
        }

        $model->handleIns();

        $info = $model->getFreeCfgIns($query['case_id']);

        return $this->json($info, null, 1);

    }


    public function actionSel()
    {

    	$query = Yii::$app->request->get();

    	$model = Process::insPro();

    	$num = $model->deadCount();

        if ($num==0) {
            $this->json(null, '请填写逝者信息');
        }

        $model->handleIns();


        $info = $model->getCfgIns($query['case_id']);




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



    /**
     * @name ajax取价格
     */
    public function actionPrice($tomb_id, $front_case, $back_case)
    {
        $model = Process::insPro();

        $model->handleIns();

        $front_data = $model->combinDbData($front_case);
        $back_data  = $model->combinDbData($back_case);

//        $front_case = InsCfgCase::findOne($front_case);
//        $back_case = InsCfgCase::findOne($back_case);

        $attach = Yii::$app->request->post('attach');


        $front_num = self::fontNum($front_data, $front_case);
        $back_num  = self::fontNum($back_data, $back_case);
        $attach_num = self::attachNum($attach);

        $total_num = [
            'big' => $front_num['big'] + $back_num['big'] + $attach_num['big'] - $model->big_num,
            'small' => $front_num['small'] + $back_num['small'] + $attach_num['small'] - $model->small_num
        ];

        $front_price = self::calPrice($front_num);
        $back_price = self::calPrice($back_num);
        $total_price = self::calPrice($total_num);


        $is_second = $model->is_stand ? true : false;
        $tc_fee = 0;
        if($model->is_tc && $model->paint!=4 && !$model->is_stand) {
            $tc_fee = $this->module->params['ins']['fee']['tc'];
        }

        return $this->json(['front'=>$front_price, 'back'=>$back_price, 'total'=>$total_price, 'tc_fee'=>$tc_fee]);

    }


    public static function attachNum($data)
    {

        $count = [
            'big' => 0,
            'small' => 0
        ];
        if (isset($data['front']) && is_array($data['front'])){
            foreach ($data['front'] as $v) {
                $is_big = isset($v['is_big']) ? 'big' : 'small';
                $count[$is_big] += self::getFontNum($v['content']);
            }
        }

        if (isset($data['back']) && is_array($data['back'])){
            foreach ($data['back'] as $v) {
                $is_big = isset($v['is_big']) ? 'big' : 'small';
                $count[$is_big] += self::getFontNum($v['content']);
            }
        }


        return $count;

    }

    public static function fontNum($data, $case_id)
    {

        $model = Process::insPro();
        $cfg_info = $model->getCfg($case_id);

        $count = [
            0 => 0,
            1 => 0
        ];

        $result = [
            'big' => 0,
            'small' => 0
        ];

        if (array_key_exists('main', $data)){
            
            foreach ($data as $k=>$v) {

                if ($k == 'main'){
                    foreach ($v['content'] as $val){
                        if (!isset($cfg_info[$k])) {
                            continue;
                        }
                        $count[$cfg_info[$k][0]['is_big']] += self::getFontNum($val);
                    }
                } else {
                    if (!$v) {
                        continue;
                    }
                    $count[$cfg_info[$k][0]['is_big']] += self::getFontNum($v['content']);
                }
                
                $result['big'] += $count[1]? $count[1] : 0;
                $result['small'] += $count[0] ? $count[0] : 0;
            }
        } else {
            foreach ($data as $k=>$v) {
                $count = [];
                foreach ($v as $key=>$val){

                    if (!isset($val['content'])) {
                        continue;
                    }

                    if ($key == 'inscribe_date' && $model->shape=='v') {
                        $count[$cfg_info[$k][0]['is_big']] = self::getFontNum($val['content'], true);
                    } else {
                        $count[$cfg_info[$k][0]['is_big']] = self::getFontNum($val['content']);
                    }

                    $result['big'] += isset($count[1])? $count[1] : 0;
                    $result['small'] += isset($count[0]) ? $count[0] : 0;
                }
            }
        }




        return $result;
    }



    public function calPrice($num)
    {
        $post = Yii::$app->request->post();

        $is_tc = $post['is_tc'];
        $paint = $post['InsPro']['paint'];

        $fee = $this->module->params['ins']['fee'];

        $result = [
            'big' => $num['big'],
            'small' => $num['small'],
            'letter_big_price' => $num['big'] * $fee['letter']['big'][$paint],
            'letter_small_price' => $num['small'] * $fee['letter']['small'][$paint],
            'paint_big_price' => $num['big'] * $fee['paint']['big'][$paint],
            'paint_small_price' => $num['small'] * $fee['paint']['small'][$paint],
        ];

        return $result;
    }

    public function calPrice1($data, $case_id, $is_front=0){

        $model = Process::insProcess();
        $post = Yii::$app->request->post();
        // $cfg = 

        $is_tc = $post['is_tc'];
        $paint = $post['InsProcess']['paint'];

        $cfg_info = $model->getCfg($case_id);


        $font_price = $this->module->params['ins']['fee'];

        $result = array();



        $model->load(Yii::$app->request->post());
        $paint = $model->paint;


        $result = [
            'big' => 0,
            'small' => 0,
            'letter_big_price' => 0,
            'letter_small_price' => 0,
            'paint_big_price' => 0,
            'paint_small_price' => 0,
        ];

        if (array_key_exists('main', $data)){
            $count = [
                0 => 0,
                1 => 0
            ];
            foreach ($data as $k=>$v) {

                if ($k == 'main'){
                    foreach ($v['content'] as $val){
                        if (!isset($cfg_info[$k])) {
                            continue;
                        }

                        $count[$cfg_info[$k][0]['is_big']] += self::getFontNum($val);
                    }
                } else {
                    if (!$v) {
                        continue;
                    }
                    $count[$cfg_info[$k][0]['is_big']] += self::getFontNum($v['content']);
                }
                
                $result['big'] += $count[1]? $count[1] : 0;
                $result['small'] += $count[0] ? $count[0] : 0;
                $result['letter_big_price'] += $font_price['letter']['big'][$paint] * $count[1];
                $result['letter_small_price'] += $font_price['letter']['small'][$paint] * $count[0];
                $result['paint_big_price'] += $font_price['paint']['big'][$paint] * $count[1];
                $result['paint_small_price'] += $font_price['paint']['small'][$paint] * $count[0];
            }
        } else {
            foreach ($data as $k=>$v) {
                $count = [];
                foreach ($v as $key=>$val){
                    if ($key == 'inscribe_date' && $model->shape=='v') {
                        $count[$cfg_info[$k][0]['is_big']] = self::getFontNum($val['content'], true);
                    } else {
                        $count[$cfg_info[$k][0]['is_big']] = self::getFontNum($val['content']);
                    }

                    $result['big'] += isset($count[1])? $count[1] : 0;
                    $result['small'] += isset($count[0]) ? $count[0] : 0;
                    $result['letter_big_price'] += $font_price['letter']['big'][$paint] * isset($count[1]) ?$count[1] :0;
                    $result['letter_small_price'] += $font_price['letter']['small'][$paint] * isset($count[0]) ?$count[0] :0;
                    $result['paint_big_price'] += $font_price['paint']['big'][$paint] * isset($count[1]) ?$count[1] :0;
                    $result['paint_small_price'] += $font_price['paint']['small'][$paint] * isset($count[0]) ?$count[0] :0;

                }
            }
        }

        $fee = [
            'big_letter' => $font_price['letter']['big'][$paint],
            'small_letter' => $font_price['letter']['small'][$paint],
            'big_paint' => $font_price['paint']['big'][$paint],
            'small_paint' => $font_price['paint']['small'][$paint],
        ];

        // $result['per'] = $fee;

        // if ($paint == 4) {//处理反喷的
        //     $result['letter'] = $is_front == 1 ? $per_price : 0;
        // }
        // $result['count'] = ceil($result['count']);

        $result['tc_fee'] = 0;
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
        $total = strlen($tmp);

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
