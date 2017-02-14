<?php

namespace app\modules\grave\controllers\home;

use yii;
use app\modules\grave\helpers\InsHelper;
use app\modules\grave\models\InsProcess;
use app\modules\grave\models\Process;



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

//     public function getPrice(){

        


//         $query = $_GET;
//         $this->InsImage->handleIns($_POST);
//         $data = $this->InsImage->combinDbData($query['case_id']);

//         $sql = <<<SQL
// SELECT i.is_front FROM `ins_cfg_case` c LEFT JOIN ins_cfg i ON i.id=c.cfg_id WHERE c.id=%d
// SQL;
//         $sql = sprintf($sql, $query['case_id']);
//         $tmp = M()->query($sql);
//         $is_front = $tmp[0]['is_front'];
//         $price = $this->calPrice($data, $is_front);
        
//         $price['is_front'] = $is_front;


//         /**
//          * 以下几个区，碑文不收费，只收墓费，其它不收费的还有安葬等
//          * 但是如果不收费，任务也发不了。还是少收点吧
//          */
//         $grave_id = M('tomb')->where(['id'=>$this->tomb_id])->getField('grave_id');
//         if (in_array($grave_id, $this->free_ins_grave)) {
//             $price['nofee'] = 1;
//         }

//         $this->ajaxReturn($price);
//     }
    
//     /**
//      * 计算价格
//      * Enter description here ...
//      * @param unknown_type $data
//      */
//     public function calPrice($data, $is_front=0){

//         $is_tc = $_POST['is_tc'];

//         $paint = $_POST['ins']['paint'];

//         $per_price = $this->Ins->getFontPrice($paint, $this->tomb_id);

//         $result = array();


//         if (array_key_exists('main', $data)){
//             foreach ($data as $k=>$v) {
//                 $count = 0;
//                 if ($k == 'main'){
//                     foreach ($v['content'] as $val){
//                         $count += self::getFontNum($val);
//                     }
//                 } else {
//                     $count += self::getFontNum($v['content']);
//                 }
                
//                 $result['count'] += $count;
//                 $result['letter'] += $per_price * $count;
//             }
//         } else {
//             foreach ($data as $k=>$v) {
//                 foreach ($v as $key=>$val){
//                     if ($key == 'inscribe_date' && $this->InsImage->getShape()=='v') {
//                         $count = self::getFontNum($val['content'], true);
//                     } else {
//                         $count = self::getFontNum($val['content']);
//                     }

//                     $result['count'] += $count;

//                     $result['letter'] += $per_price * $count;
//                 }
//             }
//         }

//         if ($paint == 4) {
//             $result['letter'] = $is_front == 1 ? $per_price : 0;
//         }
//         $result['count'] = ceil($result['count']);

//         $result['tc_fee'] = 0;
//         $result['per_price'] = $per_price;

//         $is_second = $this->Ins->getIsSecond($this->tomb_id);

//         if($is_tc && $paint!=4 && !$is_second) $result['tc_fee'] = ProcessInsImageModel::TC_FEE;

//         return $result;
//     }
   

//     public static function getFontNum($str, $flag = false)
//     {
//         $tmp = str_replace(array('.','&nbsp;',',','、',' ','，','－', '—', '-', '|', '｜'),'',$str);
//         $total = mb_strlen($tmp);

//         if ($flag) {
//             return mb_strlen($tmp, 'utf-8');
//         }

//         $utf = mb_strlen($tmp, 'UTF-8');

//         $o_count = substr_count($tmp, 'O'); // o字母个数

//         $c_count = ($total - $utf)/2;  //汉字个数

//         $n_count = ($utf - $c_count - $o_count)/2;//数字个数除2, 两个数字计为一个字

//         return $c_count + $n_count + $o_count; //换算过的字数;
//     }

//     public function fontprice()
//     {
//         $font_num = $this->_get('font_num', 'intval');
//         $paint = $this->_get('paint', 'intval');
//         $tomb_id = $this->_get('tomb_id', 'intval');

//         if (empty($paint) || empty($tomb_id)) {
//             $this->ajaxReturn(null, '参数不全', 0);
//         }

//         $this->Ins = new InsModel();

//         $per_price = $this->Ins->getFontPrice($paint, $tomb_id);

//         if ($paint == 4) {
//             $this->ajaxReturn(array('price'=>$per_price), null, 1);
//         }

//         $this->ajaxReturn(array('price'=>$font_num * $per_price), null, 1);
//     }
}
