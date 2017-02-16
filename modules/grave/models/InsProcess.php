<?php

namespace app\modules\grave\models;

use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Ins;
use app\modules\grave\models\Portrait;
use app\modules\grave\models\Bury;
use app\modules\user\models\User;
use app\modules\grave\models\InsCfg;
use app\modules\grave\models\InsCfgCase;
use app\modules\grave\models\InsCfgValue;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\Goods;


/**
 * This is the model class for table "{{%grave_ins}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $op_id
 * @property string $position
 * @property integer $shape
 * @property string $content
 * @property string $img
 * @property integer $is_tc
 * @property integer $font
 * @property integer $font_num
 * @property integer $new_font_num
 * @property integer $is_confirm
 * @property string $confirm_date
 * @property integer $confirm_by
 * @property string $pre_finish
 * @property string $finish_at
 * @property string $note
 * @property integer $version
 * @property integer $paint
 * @property integer $is_stand
 * @property string $paint_price
 * @property string $letter_price
 * @property string $tc_price
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class InsProcess extends Ins
{

    public $ins_info;

    public $shape = 'v';

    // public function getFront()
    // {

    //     return $this->ins_info['front'];
    //     // $content = json_decode($this->content);

    //     // return $content['front'];
    // }


    public function getFront(){
        
        $content = $this->ins_info['front'];

        $dead_keys = array('title', 'name', 'birth', 'fete', 'age','follow', 'second_name');
        $dead_list = $this->getDead();


        foreach ($dead_list as $k => $v) {
            if ($v['follow_id']) {
                unset($dead_list[$k]);
            }
        }
        $dead_ids = ArrayHelper::getColumn($dead_list, 'id');

        if ($this->shape == 'v') {
            $dead_ids = array_reverse($dead_ids);
        }


        $info = array();
        foreach ($content as $k=>$v) {
            if (in_array($k, $dead_keys)) {
                foreach ($dead_ids as $val) {
                    $info[$k][$val]['content'] = isset($content[$k][$val]['content']) ? $content[$k][$val]['content']:'';
                }
            } else {
                $info[$k][] = $content[$k];
            }
        }



        $content = $info;
        foreach ($content['birth'] as $k=>&$v) {
            $v['content'] = $this->getRelDate($v['content'], $dead_list[$k]['birth_type']);
            $content['fete'][$k]['content'] = $this->getRelDate($content['fete'][$k]['content'], $dead_list[$k]['fete_type']);
            $content['age'][$k]['content']  = self::numberToChar($content['age'][$k]['content'], true, $this->is_tc);
        }unset($v);

        return $content;
    }





    public function getBack()
    {
        return $this->ins_info['back'];


        // $content = json_decode($this->content);

        // return $content['back'];
    }

    public function getCover()
    {
        return $this->ins_info['cover'];
        // $content = json_decode($this->content);

        // return $content['cover'];
    }

    public function initFront()
    {
        
        $inscribe = $this->getInscribe();
        $honorific = $this->getHonorific();

        if ($this->shape == 'v') {
            $inscribe_date = self::numberToChar(date('Y'),false). '年' . self::numberToChar(date('m'),true). '月' ;
            $die = '故于'; $born = '生于';
        } else {
            $inscribe_date = date('Y、m');
            $die = $born = '—';
        }

        $current = $this->getFront();
        $deads = $this->getDead();
                         
        $info = array(
            'honorific' => array('content'=>$honorific),
            'tail'      => array('content'=>'之墓'),
            'inscribe_date' => array('content'=>$inscribe_date),
            'inscribe'  => array('content'=>$inscribe),
            'die'   => array('content'=>$die),
            'born'  => array('content'=>$born),
            'agelabel1'=> array('content'=>'享年') ,
            'agelabel2'=> array('content'=>'岁'),
            'second_name_label'=> array('content'=>'圣名')
        );


        foreach ($deads as $k=>$v) {
            if ($v['is_ins'] == 1) {

                $birth = $this->getBirth($v);
                $fete = $this->getFete($v);

                if ($v['follow_id']) {
                    $tit = $v['gender'] ? '携子' : '携女';
                    $data[$v['follow_id']]['follow']=array('content' => $tit.$v['dead_name']);
                    unset($v);
                } else {
                    $data[$k] = array(
                        'name' => array('content' => $v['dead_name'], 'is_die'=>!$v['is_alive']),
                        'title' => array('content' => $this->getDeadTitle($v['dead_title'])),
                        'birth' => array('content' => $birth),
                        'fete'  => array('content' =>$fete),
                        'age'   =>array('content' =>$v['ages']),
                        'second_name' => array('content' =>$v['second_name'])
                    );
                }
            }
        }

        $info['dead'] = $data;
        $this->ins_info['front'] = $info;
    }

    public function initBack()
    {

        if (empty($this->ins_info['back']['main'])) {
            $inscribe = $this->getInscribe();

            if ($this->shape == 'v') {
                $inscribe_date = self::numberToChar(date('Y'),false) . '年' .  self::numberToChar(date('m'),true). '月' ;
            } else {
                $inscribe_date = date('Y、m');
            }

            // $god = $this->getIsGod($this->tomb_id);

            // $back_str = $god ? array('安息主怀') : array('父恩如山','母爱似海');

            $back_str = array('父恩如山','母爱似海');

            if (!empty($this->ins_info['back'])) {
                $old_back = explode(',', trim($this->ins_info['back'],','));
                $back_str = $old_back;
            }

            $this->ins_info['back'] = array(
                'main' => array('content'=>$back_str),
            );
        }

    }

    public function initCover()
    {
        //
    }

    /**
     * 
     * 处理post过来的碑文数据
     * @param unknown_type $data
     */
    public function handleIns(){

        $data = Yii::$app->request->post();

        $this->font = $data['font_style'];
        $this->is_tc = $data['is_tc'];
        
        $front_info = $data['front'];
        $back_info  = $data['back'];
        $cover_info = $data['cover'];
        $dead  = $data['dead'];




        $keys = array('title', 'name', 'birth', 'age', 'fete', 'second_name', 'follow');
        $dead_info = array();
        foreach ($dead as $k=>$v) {
            foreach ($keys as $val){
                $dead_info[$val][$k] = $dead[$k][$val];
            }
        }

        
        $info = array_merge($front_info, $dead_info);


        $this->ins_info['front'] = $info;
        $this->ins_info['back']  = $back_info;
        $this->ins_info['cover'] = $cover_info;

        
        $add = array(
            'is_tc'     => $this->is_tc,
            // 'front_img' => $data['img'][$this->type],
            // 'back_img'  => $data['img']['back'],
            'front_type'    => $this->type,
            'dt_pre_mn'     => $data['dt_pre_mn'],
            'font'    => $this->font,
            'new_font_num'  => $data['new_font_num'],
            'note'          => trim($data['note']),
            'type'          => 1
        );
        $this->ins_info = $add + $this->ins_info;


        return $this;
    }

    public function getFont(){
        $font_style = $this->font;

        $font_list = Yii::$app->controller->module->params['ins']['font'];
        $tc = $this->is_tc ? 't' : 's';
        return $font_list[$font_style][$tc];
    }

    public static function getBirth($dead)
    {

        $birth = $dead['birth'];

        // $birth = $dead['birth_type'] == 2 ? $dead['solar_birthday'] : $dead['lunar_birthday'];
        // $fete = $dead['fete_type']   == 2 ? $dead['solar_feteday'] : $dead['lunar_feteday'];

        if (self::isNullDt($birth)) {
            if($dead['birth_year'])
                $birth = $dead['birth_year'];
            if($dead['birth_month'])
                $birth .= '-'.$dead['birth_month'];
            if($dead['birth_day'])
                $birth .= '-'.$dead['birth_day'];
        }

        $birth = str_replace('-', '.', $birth);


        self::isNullDt($birth) && $birth = '';

        return $birth;
    }

    public static function getFete($dead)
    {
        $fete = $dead['fete'];

        // $birth = $dead['birth_type'] == 2 ? $dead['solar_birthday'] : $dead['lunar_birthday'];
        // $fete = $dead['fete_type']   == 2 ? $dead['solar_feteday'] : $dead['lunar_feteday'];

        if (self::isNullDt($fete)) {
            if($dead['fete_year'])
                $fete = $dead['fete_year'];
            if($dead['fete_month'])
                $fete .= '-'.$dead['fete_month'];
            if($dead['fete_day'])
                $fete .= '-'.$dead['fete_day'];
        }

        $fete  = str_replace('-', '.', $fete);


        self::isNullDt($fete) && $fete = '';

        return $fete;
    }

    public static function isNullDt($value)
    {
        if ( $value != NULL) {
            if (in_array($value, array('0000-00-00 00:00:00', '0000-00-00', ''))) {
                $value = NULL;
            }
        }
        return !(boolean)$value;
    }

    public function syncFront()
    {
        $current_ins_info= $this->ins_info['front'];

        $deads = $this->getDead();

        if (empty($current_ins_info)) {return $this->initFront();}

        $i= 0 ;
        foreach ($deads as $k=>$v) {
            if ($v['is_ins']) {

                $birth = static::getBirth();
                $fete = static::getFete();

                if (empty($current_ins_info['birth'][$i]['content'])){
                    $birth = $birth;
                } else {
                    $birth = $current_ins_info['birth'][$i]['content'];
                }
                
                if (empty($current_ins_info['fete'][$i]['content'])){
                    $fete = $fete;
                } else {
                    $fete = $current_ins_info['fete'][$i]['content'];
                }

                if (empty($current_ins_info['age'][$i]['content'])){
                    $age = $v['age'];
                    empty($age) && $age = '';
                } else {
                    $age = $current_ins_info['age'][$i]['content'];
                }
                
                $newdata[$k] = array(
                    'name' => array('content' => $v['dead_name'], 'is_die'=>!$v['is_alive']),
                    'title' => array('content' => $this->getDeadTitle($v['dead_title'])),
                    'birth' => array('content' => $birth),
                    'fete'  => array('content' =>$fete),
                    'age'   =>array('content' =>$age),
                    'follow'  =>array('content' =>$current_ins_info['follow'][$i]['content']),
                    'second_name'  =>array('content' =>$v['second_name'])
                );
            }
            $i++;
        }

        $data['dead'] = $newdata;

        return $data;
    }

    /**
     * 
     * 取碑文整体信息
     */
    public function getInsInfo(){
        $info = $this->ins_info;

        if (empty($this->ins_info['front'])) {

            $this->initFront();
            $this->initBack();
            $this->initCover();

            // $paint = M('tomb')->where(array('id'=>$this->tomb_id))->getField('inscription_paint');
            // if ($paint == '反喷') {
            //     $this->inscription_info['font_style'] = 2;
            // } else if ('金箔') {
            //     $this->inscription_info['font_style'] = 0;
            // }

        } else {
            $dead_keys = array('name', 'title', 'birth', 'fete', 'age', 'follow', 'second_name');
            $dead = array();
            foreach ($info['front_info'] as $k=>$v) {
                if (in_array($k, $dead_keys)) {
                    foreach ($v as $key=>$val) {
                        $dead['dead'][$key][$k]=$val;
                    }
                } else {
                    $dead[$k] =$v;
                }
            }

            $data = $this->syncFront($dead);
            $this->ins_info['front'] = $data;
        }

        return $this->ins_info;
    }

    /**
     * @name 取碑文字体位置配置
     */
    public function getCfg($cfgcase_id)
    {

        $case = InsCfgCase::findOne($cfgcase_id);
        $shape = $case->cfg->shape;

        $cfg = InsCfgValue::find()->where(['case_id'=>$cfgcase_id])->orderBy('sort asc')->asArray()->all();

        $cfg_info = array();
        foreach ($cfg as $k=>$v){
            $cfg_info[$v['mark']][$v['sort']-1] = array(
                        'x' => $v['x'], 
                        'y' => $v['y'], 
                        'size' => $v['size'],
                        'color' => $v['color'],
                        'direction' => $v['direction'],
                        'shape'     => $shape,
                        'ttt'  => $v['text']
                );
        }

        return $cfg_info;
    }

    public function getCfgIns($cfgcase_id)
    {

        $case = InsCfgCase::findOne($cfgcase_id);
        $cfg = InsCfg::findOne($case->cfg_id);
        $is_front = $cfg->is_front;


        switch ($is_front) {
            case 0:
                $ins_info = $this->getBack();
                break;
            case 1:
                $ins_info = $this->getFront();
                break;
            case 2:
                $ins_info = $this->getCover();
                break;
            default:
                break;
        }


        $cfg_info = $this->getCfg($cfgcase_id);

        $cfg_info = $this->combinCfgIns($cfg_info, $ins_info, $cfg->shape, array($case->width, $case->height), $is_front);
        $cfg_info = $this->inverseAlign($cfg_info);



        //碑型
        $shape = $cfg_info[0]['shape'];

        //碑后文全重算一下
        if (($shape == 'v' && $is_front != 2) || ($shape=='h' && $is_front==0)){
            $newdata = array();

            foreach ($cfg_info as $v) {
                if (isset($v['angle'])) {
                    $arr[] = $v;
                } else {
                    $arr = self::verText($v['text'],$v['x'], $v['y'], $v['size'], $v['color'], 1.25, $shape);
                }
                $newdata = array_merge($newdata, $arr);
            }

            return ['data'=>$newdata, 'size'=>[$case->width, $case->height], 'is_front'=>$is_front];
        }
        return ['data'=>$cfg_info, 'size'=>[$case->width, $case->height], 'is_front'=>$is_front];
    }


    public function combinDbData($cfgcase_id)
    {
        $case = InsCfgCase::findOne($cfgcase_id);
        $cfg = InsCfg::findOne($case->cfg_id);
        $is_front = $cfg->is_front;


        $case_info = M('ins_cfg_case')->where(array('id'=>$cfg_case_id))->find();
        $is_front = M('ins_cfg')->where(array('id'=>$case_info['cfg_id']))->getField('is_front');
        
        if ($is_front==1){
            $ins_info = $this->getFront();
        } else if($is_front==0){
            $ins_info = $this->getBack();
        } else{
            $ins_info = $this->getCover();
        }

        $shape = $this->shape;

        $cfg_info = $this->getCfg($cfgcase_id);
        $new_cfg_data = array();

        if (array_key_exists('main', $cfg_info)){
            foreach ($cfg_info as $k=>$v) {
                $new_cfg_data[$k] = $ins_info[$k];
            }unset($v);
        } else {
            $tmp_ins_info = $ins_info;
            foreach ($cfg_info as $k=>&$v){
                foreach ($v as $key => &$val){
                   // $data = array_pop($tmp_ins_info[$k]); 
                   $data = $shape == 'v' ? array_pop($tmp_ins_info[$k]) : array_shift($tmp_ins_info[$k]); 
                    if (empty($data['content']) && in_array($k, array('die', 'born', 'honorific', 'second_name_label'))) {
                        $data = $new_cfg_data[$k][0];
                    }
                    $new_cfg_data[$k][] = $data;
                }unset($val);
                
            }unset($v);

        }

        $label_num = count($cfg_info['born']);
        if ($label_num > 1) {
            foreach ($new_cfg_data as $k=>&$v){
                foreach ($v as $key=>&$val){
                    switch ($k){
                        case 'die':
                        case 'born':
                            if (empty($new_cfg_data['birth'][$key]['content'])){
                                unset($new_cfg_data[$k][$key]);
                            }
                            break;
                        case 'title':
                            if (empty($new_cfg_data['name'][$key]['content'])){
                                unset($new_cfg_data[$k][$key]);
                            }
                    }
                }unset($val);
            }unset($v);
        } else if ($label_num ==1){
            $flag = true;
            foreach ($new_cfg_data['birth'] as $key=>$val){
                if (empty($new_cfg_data['birth'][$key]['content'])){
                    continue;
                }
                $flag = false;
            }
            if ($flag) unset($new_cfg_data['die']);

            //处理 born 标签
            $flag = true;
            foreach ($new_cfg_data['birth'] as $key=>$val){
                if (empty($new_cfg_data['birth'][$key]['content'])){
                    continue;
                }
                $flag = false;
            }
            if ($flag) unset($new_cfg_data['born']);

        }
        return $new_cfg_data;
    }
    public function combinCfgIns($cfg_info, $ins_info, $shape, $size=NULL, $is_front=0)
    {

        $new_cfg = [];

        if (array_key_exists('main', $cfg_info)){
            if ($shape == 'v') {
                $ins_info['main']['content']= array_reverse($ins_info['main']['content']);
            }

            foreach ($cfg_info as $k=>$v) {
                if ($k == 'main') {
                    $v[0]['text'] = $ins_info['main']['content'];
                    $new_cfg[$k] = $v[0];
                } else {
                    $v = $v[0];
                    $v['text'] = $ins_info[$k]['content'];
                    $new_cfg[] = $v;
                }
            };
            $new_cfg = $this->calPosition($new_cfg, $size, $is_front, $shape);
        } else {
            $tmp_info = array();
            foreach ($cfg_info as $k=>$v){

                foreach ($v as $key => $val){
                    $d = array_values($ins_info[$k]);

                    $val['text'] = $d[$key]['content'];

                    if (empty($d[$key]['content']) && in_array($k, array('die', 'born', 'honorific', 'second_name_label'))){
                        $val['text'] = $d[0]['content'];
                    }

                    if ($k == 'name') {
                        $val['is_die'] = $d[$key]['is_die'];
                    }

                    $tmp_info[$k][$key] = $val;
                }
            }

        }

//        $label_num = count($cfg_info['die']);
        $label_num = count($cfg_info['born']);
        if ($label_num > 1) {
            foreach ($tmp_info as $k=>&$v){
                foreach ($v as $key=>&$val){
                    switch ($k){
                        case 'die':
                        case 'born':
                            if (empty($tmp_info['birth'][$key]['text'])){
                                unset($tmp_info[$k][$key]);
                            }
                            break;
                        case 'title':
                            if (empty($tmp_info['name'][$key]['text'])){
                                unset($tmp_info[$k][$key]);
                            }
                    }
                }unset($val);
            }unset($v);
        } else if ($label_num ==1){

            //永安习惯 有生日就要把die标签显示出来
            //处理 die 标签
            $flag = true;
            foreach ($tmp_info['birth'] as $key=>$val){
                if (empty($tmp_info['birth'][$key]['text'])){
                    continue;
                }
                $flag = false;
            }
            if ($flag) unset($tmp_info['die']);

            //处理 born 标签
            $flag = true;
            foreach ($tmp_info['birth'] as $key=>$val){
                if (empty($tmp_info['birth'][$key]['text'])){
                    continue;
                }
                $flag = false;
            }
            if ($flag) unset($tmp_info['born']);

        }

        //处理圣名标签
        if ($tmp_info['second_name_label']) {
            foreach ($tmp_info['second_name_label'] as $k => $v) {
                if (empty($tmp_info['second_name'][$k]['text'])){
                    unset($tmp_info['second_name_label'][$k]);
                }
            }
        }

        foreach ($tmp_info as $k=>$v){
            if ($k == 'name') {
                foreach ($v as $kk=>$vv) {
                    if ($vv['is_die']) {
                        $new_cfg[] = $this->angle($vv);
                    }
                }
            }
            foreach ($v as $val){
                $new_cfg[] = $val;
            }
        }
        return $new_cfg;
    }

    public function angle()
    {
        $shape = $this->getShape();
        if ($shape == 'v') {
            $x2 = $vv['x'] + $vv['size']*1.3;
            $y2 = $vv['y'] + $vv['size'] * mb_strlen($vv['text'], 'utf-8') * 1.3 - $vv['size'];
        } else {
            $y2 = $vv['y'] + $vv['size']*0.3;
            $x2 = $vv['x'] + $vv['size'] * mb_strlen($vv['text'], 'utf-8') * 1.3 + $vv['size']*0.3;
        }
        return array(
            'angle' => 1,
            'x1' => $vv['x'],
            'y1' => $vv['y'] - $vv['size']*1.1,
            'x2' => $x2,
            'y2' => $y2
        );
    }

    public function maxLength($array)
    {
        $length = 0;
        foreach ($array as $v){
            $length = $length < mb_strlen($v, 'utf-8') ? mb_strlen($v, 'utf-8') : $length;
        }
        return $length;
    }

    public function calPosition($ins_info, $size, $is_front=0)
    {
        $ratio = 10;
        $main_info = $ins_info['main'];
        unset($ins_info['main']);

        $rows = count($main_info['text']);
        $shape = $main_info['shape'];
        //横着也要对齐呀
        $length = $this->maxLength($main_info['text']);

        $width = $size[0];
        $height = $size[1];


        if ($shape == 'h' || $is_front==2){
            $v_size = $height / (2*$rows+1);
            $h_size = ($width-120)/(1.2*$length);

            $main_info['size'] = $v_size > $h_size ? $h_size : $v_size;
            $main_info['x'] = ($width - $length*$main_info['size']*1.3)/2;
            $step = $main_info['size']/1.2;
            $direct = 'y';

            $boundary = $height / ($rows*2 + 1) + $main_info['size'];
        } else {
            $v_size = $width / (2*$rows+1);
            $h_size = ($height-120)/(1.2*$length);

            $main_info['size'] = $v_size > $h_size ? $h_size : $v_size;

            $step = $main_info['size']/1.2;

            $main_info['y'] = ($height - $length*$main_info['size']*1.3)/2 + $main_info['size'];

            $boundary = $width / ($rows*2 + 1);
            $direct = 'x';
        }

        $new_ins = array();
        foreach ($main_info['text'] as $k=>$v){
            $new_ins[$k] = $main_info;
            $new_ins[$k][$direct] = $boundary + ($main_info['size'] + $step) * $k;
            $new_ins[$k]['text']=$main_info['text'][$k];
        }
        return array_merge($ins_info, $new_ins);
    }


    public function inverseAlign($data)
    {
        $shape = $data[0]['shape'];
        $dire = $shape=='h' ? 'x' : 'y';
        foreach ($data as $k=>&$v){
            if ($v['direction'] == 1) {
                $v[$dire] = $v[$dire] - mb_strlen($v['text'], 'utf-8') * $v['size'];
            }
        }unset($v);
        return $data;
    }
    /**
     * @name 取使用人数量
     */
    public function getDead()
    {
        return Dead::find()->where(['tomb_id'=>$this->tomb_id])
                           ->andWhere(['status'=>Dead::STATUS_NORMAL])
                           ->indexBy('id')
                           ->asArray()
                           ->all();

    }

    /**
     * @name 取使用人数量
     */
    public function getDeadCount($ext_follow = true){
        return count($this->getDead());
    }

    public function order()
    {

    }


    /**
     * 
     * 按碑型取得时间的表示方法
     * @param unknown_type $date
     * @param unknown_type $type
     */
    public function getRelDate($date, $is_lunar=null){
        
        // $is_lunar = $is_lunar==1? true:false;
        
        if (empty($date)) return '';

        $da = str_replace('.','-',$date);
        
         if (!strpos($da, '-') && !is_numeric($date)) {
             return $date;
         }

        if ($this->shape == 'v'){
            $d = explode('-', $da);
            $y = !empty($d[0]) ? self::numberToChar($d[0],false,$this->is_tc).'年' : '';
            $m = !empty($d[1]) ? self::numberToChar($d[1],true,$this->is_tc).'月' : '';
            $d = !empty($d[2]) ? self::numberToChar($d[2],true,$this->is_tc).'日' : '';
            return $y.$m.$d;
        }

        // if ($shape == 'v'){
        //     $d = explode('-', $da);
        //     $y = !empty($d[0]) ? numberToChar($d[0],false,$this->is_tc).'年' : '';
        //     $m = !empty($d[1]) ? solarToLunar(numberToChar($d[1],true,$this->is_tc).'月',$is_lunar) : '';
        //     $d = !empty($d[2]) ? solarToLunar(numberToChar($d[2],true,$this->is_tc).'日',$is_lunar) : '';
        //     return $y.$m.$d;
        // }

        return $date;
    }

    /**
     * 
     * 取落款
     */
    public function getInscribe(){
        $config = Yii::$app->controller->module->params['ins']['inscribe'];

        $tomb = $this->tomb();
        $person = $tomb->mnt_by;
        $inscribe = $config[$person] ? $config[$person] : '亲人泣立';//.'敬立';
        return $inscribe;
    }

    public function tomb($field = null)
    {
        $model = Tomb::findOne($this->tomb_id);
        if ($field) {
            return $model->$field;
        }
        return $model;
    }



    
    public function getDeadTitle($title){
        $conf = Yii::$app->controller->module->params['ins']['ins_title'];
        $conf = $this->shape == 'v' ? $conf['v'] : $conf['h'];
        return isset($conf[$title]) ? $conf[$title]: $title;
    }

    public function getHonorific() {
        $mnt_by = $this->tomb('mnt_by');

        if(in_array($mnt_by,array('儿子','女儿','儿子女儿','儿子儿媳','女儿女婿'))) {
            $honorific = '先';
        }else {
            $honorific = '';
        }
        
        $dead_list = $this->ins_info['dead'];

        $dead_list = $this->getDead();

        foreach($dead_list as $k=>$v) {
            if (in_array($v['title'], array('祖父', '祖母'))) {
                $honorific = '祖';
            }
            if ($this->shape == 'v') {
                switch ($v['title']){
                    case '姐姐':
                        $honorific = '姐';break;
                    case '妹妹':
                        $honorific = '妹';break;
                    case '哥哥':
                        $honorific = '哥';break;
                    case '弟弟':
                        $honorific = '弟';break;
                }
            }
        }
        return $honorific;
    }





    

    public function getInsCfgCases(){


        $tomb = $this->tomb();
        $grave_id = $tomb->grave_id;

        
        $cfg_ids = InsCfgRel::find()->where(['grave_id'=>$grave_id])->asArray()->all();

        $cfg_ids = ArrayHelper::getColumn($cfg_ids, 'cfg_id');

        $cfgs = InsCfg::find()->where(['id'=>$cfg_ids])
                              // ->andWhere(['is_front'=>1, 'shape'=>$this->shape])
                              ->asArray()
                              ->all();


        $cfg_info = [];

        foreach ($cfgs as $v) {
            $cfg_info[$v['is_front']][] = $v['id'];
        }

        $num = $this->getDeadCount();

        $front_filter = [
            'cfg_id' => $cfg_info[1],
            'num' => $num,
            'status' => 1
        ];

        $back_filter = [
            'cfg_id' => $cfg_info[0]
        ];

        $cover_filter = [
            'cfg_id' => $cfg_info[2]
        ];


        $front_cases = InsCfgCase::find()->where($front_filter)
                                         ->andWhere(['is not', 'img', `null`])
                                         ->orderBy('sort asc')
                                         ->asArray()
                                         ->all();


        $tmp_cases = InsCfgCase::find()->where($back_filter)
                                         ->andWhere(['is not', 'img', `null`])
                                         ->orderBy('sort asc')
                                         ->asArray()
                                         ->all();

        $tmp_cover_cases = InsCfgCase::find()->where($cover_filter)
                                         ->andWhere(['is not', 'img', `null`])
                                         ->orderBy('sort asc')
                                         ->asArray()
                                         ->all();


        $tmp = [];
        foreach ($cfgs as $v) {
            if ($v['is_front'] == 1) continue;
            $tmp[$v['id']] = $v['shape'] == $this->shape ? 'array_unshift' : 'array_push';
        }


        $back_cases = [];//back_cases
        foreach($tmp_cases as &$v) {
            $method = $tmp[$v['cfg_id']];
            $method($back_cases, $v);
        }unset($v);


        $cover_cases = [];
        foreach ($tmp_cover_cases as &$v) {
            $method = $tmp[$v['cfg_id']];
            $method($cover_cases, $v);
        }unset($v);


        $cases = [];
        is_array($front_cases) && $cases = array_merge($cases, $front_cases);
        is_array($tmp_cases) && $cases = array_merge($cases, $back_cases);
        is_array($tmp_cover_cases) && $cases = array_merge($cases, $cover_cases);


        $cfg_ids = ArrayHelper::getColumn($cases, 'cfg_id');


        $cfg_info = InsCfg::find()->where(['id'=>$cfg_ids])->select(['id', 'note'])->asArray()->all();
        $cfg_info = ArrayHelper::map($cfg_info, 'id', 'note');




        $result = array(
            'front_cases' => $front_cases,
            'back_cases'  => $back_cases,
            'cover_cases' => $cover_cases,
        );

        foreach ($result as $key => &$val) {
            foreach ($val as $k => &$v) {
                $v['note'] = $cfg_info[$v['cfg_id']];
            }unset($v);
        }unset($val);


        $front = $this->getCfg('front');
        $back = $this->getCfg('back');
        $cover = $this->getCfg('cover');

        $front_current_case_id = empty($front) ? $front_cases[0]['id']:substr($front,strrpos($front,'_')+1);
        $back_current_case_id = empty($back) ? $back_cases[0]['id']:substr($back,strrpos($back,'_')+1);
        $cover_current_case_id = empty($cover) ? $cover_cases[0]['id'] : substr($cover, strrpos($cover, '_')+1);



        return [
            'front_current_case_id' => $front_current_case_id,
            'back_current_case_id'  => $back_current_case_id,
            'cover_current_case_id' => $cover_current_case_id
        ] + $result;















//         //取出配置
//         $sql = <<<SQL
// SELECT * FROM ins_cfg_grave_rel rel
// INNER JOIN ins_cfg c ON c.id=rel.cfg_id
// WHERE rel.grave_id = %d and ((c.is_front=1 AND c.shape='%s') OR c.is_front=0)
// SQL;

//         $shape = $this->getShape();
//         $sql = sprintf($sql, $grave_id, $shape);
//         $info = M()->query($sql);

//         $cfg_info = array();
//         foreach ($info as $v){
//             $cfg_info[$v['is_front']][] = $v['cfg_id'];
//         }

//         $num = M('tomb_user')->where(array('tomb_id'=>$this->tomb_id, 'follow_id'=>0, 'status'=>1))->count();

//         $front_filter = array(
//             'cfg_id' => array('in', $cfg_info[1]),
//             'num'    => $num,
//             'status' => 1,
//             'img'   => array('exp','is not null')
//         );
//         $back_filter = array(
//             'cfg_id' => array('in', $cfg_info[0]),
//             'img'   => array('exp','is not null')
//         );

//         $front_cases = M('ins_cfg_case')->where($front_filter)->order('sort asc')->select();
//         $tmp_cases = M('ins_cfg_case')->where($back_filter)->order('sort asc')->select();

//         $tmp = array();
//         foreach ($info as $v) {
//             if ($v['is_front'] == 1) continue;
//             $tmp[$v['cfg_id']] = $v['shape'] == $shape ? 'array_unshift' : 'array_push';
//         }


//         $back_cases = array();//back_cases
//         foreach($tmp_cases as &$v) {
//             $tmp[$v['cfg_id']]($back_cases, $v);
//         }

//         // $cover_cases = M('ins_cfg_case')->where($cover_filter)->select();

//         $cases = array();
//         is_array($front_cases) && $cases = array_merge($cases, $front_cases);
//         is_array($tmp_cases) && $cases = array_merge($cases, $back_cases);
//         // is_array($cover_cases) && $cases = array_merge($cases, $cover_cases);

//         $cfg_ids = extractField($cases, 'cfg_id');

//         $cfg_info = M('ins_cfg')->where(array('id'=>array('in', $cfg_ids)))
//             ->field(array('id', 'note'))
//             ->select();

//         $cfg_info = valueToKey($cfg_info, 'id', 'note');

//         $result = array(
//             'front_cases' => $front_cases,
//             'back_cases'  => $back_cases,
//             // 'cover_cases' => $cover_cases,
//         );

//         foreach ($result as $key => &$val) {
//             foreach ($val as $k => &$v) {
//                 $v['note'] = $cfg_info[$v['cfg_id']];
//             }unset($v);

//         }unset($val);


//         $inscription_info = $this->getInscriptionInfo();
//         $f_type = $inscription_info['front_type'];
//         $b_type = $inscription_info['back_type'];

//         $front_current_case_id = empty($f_type) ? $front_cases[0]['id']:substr($f_type,strrpos($f_type,'_')+1);
//         $back_current_case_id = empty($b_type) ? $back_cases[0]['id']:substr($b_type,strrpos($b_type,'_')+1);
//         // $cover_current_case_id = empty($c_type) ? $cover_cases[0]['id'] : substr($c_type, strrpos($c_type, '_')+1);

//         return array(
//             'front_current_case_id' => $front_current_case_id,
//             'back_current_case_id'  => $back_current_case_id,
//             // 'cover_current_case_id' => $cover_current_case_id
//         ) + $result;

    }

    public static function numberToChar($num,$mode=true,$is_tc = false){

        if (!is_numeric($num)) {
            return $num;
        }
        $char = array('O','一','二','三','四','五','六','七','八','九');
        $dw = array('','十','百','千','','万','亿','兆');
        $dec = '点';  
        $retval = '';
        if($mode){
            preg_match_all('/^0*(\d*)\.?(\d*)/',$num, $ar);
        }else{
            preg_match_all('/(\d*)\.?(\d*)/',$num, $ar);
        }
        if($ar[1][0] != ''){
            $str = strrev($ar[1][0]);
            for($i=0;$i<strlen($str);$i++) {
                $out[$i] = $char[$str[$i]];
                if($mode){
                    if(($i == 1) && ($str[$i] == 1)) {
                        $out[$i] = $str[$i] != '0'? $dw[$i%4] : '';
                    }else {
                        $out[$i] .= $str[$i] != '0'? $dw[$i%4] : '';
                    }
                    if($str[$i]+$str[$i-1] == 0){
                        $out[$i] = '';
                    }
                    if($i%4 == 0){
                        $out[$i] .= $dw[4+floor($i/4)];
                    }
                }
            }
            $retval = join('',array_reverse($out)) . $retval;
        }
        return $retval;
    }

    /**
     * 竖字时，传入字符串及位置，函数把串分成数组，计算每一个字的位置
     * @param 字符串 $text
     * @param 横坐开始位置 $startX
     * @param 纵坐标开始位置 $startY
     * @param 字体大小  $fontsize
     * @parm 颜色　$color
     * @parm 字间距 $step
     */
    public static function verText($text, $startX=0, $startY=0, $fontsize, $color='#222222', $step=1.25, $shape="v"){

        preg_match_all( '/./u',$text,$tmp);

        $font_arr = array();

        if ($shape == 'v') {
            foreach($tmp[0] as $k=>$v) {
                $font_arr[$k] = array(
                    'text' => $v,
                    'size' => $fontsize,
                    'x'     => $startX,
                    'y'     => $startY + $k*($fontsize*$step),
                    'color'=> $color,
                );
            }
        } else {
            foreach($tmp[0] as $k=>$v) {
                $font_arr[$k] = array(
                    'text' => $v,
                    'size' => $fontsize,
                    'x'     => $startX + $k*($fontsize*$step),
                    'y'     => $startY,
                    'color'=> $color,
                );
            }
        }

        return $font_arr;
    }

    public static function insGoods($tomb_id, $goods, $rel)
    {
        $ins = self::find()->where(['tomb_id'=>$tomb_id])
                         ->andWhere(['status'=>Dead::STATUS_NORMAL])
                         ->one();

        $tomb = Tomb::findOne($tomb_id);

        if (!$ins) {
            $ins = new self();
            $ins->tomb_id = $tomb_id;
        }

        $ins->order_rel_id = $rel->id;
        $ins->goods_id = $goods->id;
        $ins->shape = self::getInsGoodsShape($goods->id);
        $ins->user_id = $tomb->user_id;
        $ins->guide_id = $tomb->guide_id;
        return $ins->save();
    }

    public static function getInsGoodsShape($goods_id)
    {
        $cnf = Yii::$app->controller->module->params['ins']['goods_attr'];
        $attr_id = $cnf['id'];
        $shape = $cnf['shape'];

        $rel = AvRel::find()->where(['goods_id'=>$goods_id, 'attr_id'=>$attr_id])->asArray()->all();

        if (!$rel) {
            return null;
        }

        return isset($shape[$rel['av_id']]) ? $shape[$rel['av_id']] : null;
    }

    /**
     * @name 取碑信息
     */
    public function getGoodsInfo()
    {
        return  Goods::findOne($this->goods_id);
    }

   
}
