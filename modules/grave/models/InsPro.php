<?php

namespace app\modules\grave\models;

use app\core\helpers\Url;
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
use app\core\base\Upload;


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
class InsPro extends Ins
{

    public $ins_info;

    public function freeSave()
    {
        $post = Yii::$app->request->post();

        $this->handleIns();
        $this->type = InsProcess::TYPE_FREE;

        $front_case = $post['front_case'];
        $back_case  = $post['back_case'];
        $cover_case = $post['cover_case'];


        $this->tpl_cfg = json_encode([
            'front' => $front_case,
            'back'  => $back_case,
            'cover' => $cover_case
        ]);

        $this->content = json_encode([
            'front' => $this->combinDbData($front_case),
            'back'  => $this->combinDbData($back_case),
            'attach' => isset($post['attach']) ? $post['attach'] : ''
            // 'cover' => $this->combinDbData($cover_case),
        ]);


        $str = str_pad($this->tomb_id, 8, "0", STR_PAD_LEFT);
        $path = '/upload/ins/' . substr($str,0,2).'/'.substr($str,2,3).'/'.substr($str,5);


        $img = (array)json_decode($this->img);


        if ($post['front-canvas-img']) {
            $front_img_info = Upload::base64($post['front-canvas-img'], $path.'/'.$this->tomb_id.'front.png', $res="ins",  $this->id);
            $img['front'] =  $front_img_info['mid'];
        }

        if ($post['back-canvas-img']) {
            $back_img_info = Upload::base64($post['back-canvas-img'], $path.'/'.$this->tomb_id.'back.png', $res="ins", $this->id);
            $img['back'] = $back_img_info['mid'];
        }

        $this->img = json_encode($img);

        $this->changed = 0;
        $this->op_id = Yii::$app->user->id;

        return $this->save();
    }



    public function autoSave()
    {

        $post = Yii::$app->request->post();

        $this->handleIns();
        $this->type = self::TYPE_AUTO;

        $front_case = $post['front_case'];
        $back_case  = $post['back_case'];
        $cover_case = $post['cover_case'];


        $this->tpl_cfg = json_encode([
            'front' => $front_case,
            'back'  => $back_case,
            'cover' => $cover_case
        ]);




        $this->content = json_encode([
            'front' => $this->combinDbData($front_case),
            'back'  => $this->combinDbData($back_case),
            // 'cover' => $this->combinDbData($cover_case),
        ]);

        $str = str_pad($this->tomb_id, 8, "0", STR_PAD_LEFT);  
        $path = '/upload/ins/' . substr($str,0,2).'/'.substr($str,2,3).'/'.substr($str,5);


        $img = (array)json_decode($this->img);


        if ($post['front_img']) {
            $front_img = Yii::getAlias('@app/web' . substr($post['front_img'], 0, strpos($post['front_img'], '?')));
            $front_img_info = Upload::upload($front_img, $path.'/'.$this->tomb_id.'_front.png', 'ins', $this->id);
            $img['front'] =  $front_img_info['mid'];
        }

        if ($post['back_img']) {
            $back_img = Yii::getAlias('@app/web' . substr($post['back_img'], 0, strpos($post['back_img'], '?')));
            $back_img_info = Upload::upload($back_img, $path.'/'.$this->tomb_id.'_back.png', 'ins', $this->id);
            $img['back'] = $back_img_info['mid'];
        }

        $this->img = json_encode($img);

        $this->changed = 0;
        $this->op_id = Yii::$app->user->id;


        return $this->save();

    }

    public function imgSave()
    {
        $this->type = self::TYPE_IMG;
        $post = Yii::$app->request->post();

        $this->img = json_encode($post['Ins']['img']);
        $this->op_id = Yii::$app->user->id;
        return $this->save();
    }



    /**
     * @name 取碑文字体位置配置
     */
    public function getCfg($cfgcase_id)
    {

        $case = InsCfgCase::findOne($cfgcase_id);

        if (!$case) {
            return ;
        }
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
                        'ttt'  => $v['text'],
                        'is_big' => isset($v['is_big']) ? $v['is_big'] : 1
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
                $ins_info = $this->getBackContent();
                if (empty($ins_info['main']['content'][0])) {
                    return ['data'=>[], 'size'=>[$case->width, $case->height], 'is_front'=>$is_front];
                }
                break;
            case 1:
                $ins_info = $this->getFrontContent();
                break;
            case 2:
                $ins_info = $this->getCoverContent();
                break;
            default:
                break;
        }


        $cfg_info = $this->getCfg($cfgcase_id);

        $cfg_info = $this->combinCfgIns($cfg_info, $ins_info, $cfg->shape, array($case->width, $case->height), $is_front);

        $cfg_info = $this->inverseAlign($cfg_info);

        //碑型
        reset($cfg_info);
        $first = current($cfg_info);
        $shape = $first['shape'];// $cfg_info[0]['shape'];

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


    public function getFreeCfgIns($cfgcase_id)
    {

        $case = InsCfgCase::findOne($cfgcase_id);
        $cfg = InsCfg::findOne($case->cfg_id);
        $is_front = $cfg->is_front;


        switch ($is_front) {
            case 0:
                $ins_info = $this->getBackContent();
                if (empty($ins_info['main']['content'][0])) {
                    return ['data'=>[], 'size'=>[$case->width, $case->height], 'is_front'=>$is_front];
                }
                break;
            case 1:
                $ins_info = $this->getFrontContent();

                break;
//            case 2:
//                $ins_info = $this->getCoverContent();
//                break;
            default:
                break;
        }

        $cfg_info = $this->getCfg($cfgcase_id);

        $cfg_info = $this->combinFreeIns($cfg_info, $ins_info, $cfg->shape, array($case->width, $case->height), $is_front);

        return $cfg_info;
    }


    public function combinDbData($cfgcase_id)
    {
        $case = InsCfgCase::findOne($cfgcase_id);
        $cfg = InsCfg::findOne($case->cfg_id);
        $is_front = $cfg->is_front;


        if ($is_front==1){
            $ins_info = $this->getFrontContent();
        } else if($is_front==0){
            $ins_info = $this->getBackContent();
        } else{
            $ins_info = $this->getCoverContent();
        }

        $shape = $this->shape;

        $cfg_info = $this->getCfg($cfgcase_id);
        $new_cfg_data = array();

        if (array_key_exists('main', $cfg_info)){
            foreach ($cfg_info as $k=>$v) {
                $new_cfg_data[$k] = isset($ins_info[$k]) ? $ins_info[$k] : '';
            }unset($v);
        } else {
            $tmp_ins_info = $ins_info;
            foreach ($cfg_info as $k=>&$v){
                foreach ($v as $key => &$val){
                    if (!isset($tmp_ins_info[$k])) {
                        continue ;
                    }
                   $data = $shape == 'v' ? array_pop($tmp_ins_info[$k]) : array_shift($tmp_ins_info[$k]); 
                    if (empty($data['content']) && in_array($k, array('die', 'born', 'honorific', 'second_name_label'))) {
                        $data = isset($new_cfg_data[$k][0]) ?  $new_cfg_data[$k][0] : '';
                    }
                    $new_cfg_data[$k][] = $data;
                }unset($val);
                
            }unset($v);
        }




        $label_num = isset($cfg_info['born']) ? count($cfg_info['born']) : 0;
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

    public function combinFreeIns($cfg_info, $ins_info, $shape, $size=NULL, $is_front=0)
    {

        $new_cfg = [];

        if (array_key_exists('main', $cfg_info)){

            if (isset($ins_info['attach'])) {
                $attach = $ins_info['attach'];

                $step = 30;
                foreach ($attach as $k => &$v) {

                    $tmp = [
                        'color' => '',
                        'direction' => 0,
                        'shape' => $this->shape,
                        'text' => $v['content'],
                        'size' => isset($v['is_big']) ? 58 : 18,
                    ];
                    if (isset($v['pos']) && strpos($v['pos'], '_')) {
                        $pos = explode('_', $v['pos']);
                        $v = [
                                'x' => $pos[0],
                                'y' => $pos[1],
                            ] + $tmp;
                    } else {
                        $v = [
                                'x' => ($k + 1) * $step,
                                'y' => 20,
                            ] + $tmp;
                    }

                }unset($v);

                $new_cfg['attach_back'] = $attach;
            }


            foreach ($cfg_info as $k=>$v) {
                if ($k == 'main') {
                    $v[0]['text'] = $ins_info['main']['content'];
                    $v[0]['pos'] = isset($ins_info['main']['pos']) ? $ins_info['main']['pos'] : '';
                    $new_cfg[$k] = $v[0];
                } else {
                    $v = $v[0];
                    $v['text'] = isset($ins_info[$k]['content']) ? $ins_info[$k]['content'] : '';
                    $new_cfg[$k] = $v;
                }
            };

            $new_cfg = self::calPosition($new_cfg, $size, $is_front, $shape);

        } else {
            $tmp_info = array();
            $tins_info = $ins_info;

            if (isset($ins_info['attach'])) {
                $attach = $ins_info['attach'];

                $step = 30;
                foreach ($attach as $k => &$v) {

                    $size = isset($v['is_big']) ? 58 : 18;
                    $tmp = [
                        'color' => '',
                        'direction' => 0,
                        'shape' => $this->shape,
                        'text' => $v['content'],
                        'size' => $size
                    ];
                    if (isset($v['pos']) && strpos($v['pos'], '_')) {
                        $pos = explode('_', $v['pos']);
                        $v = [
                            'x' => $pos[0],
                            'y' => $pos[1],
                        ] + $tmp;
                    } else {
                        $v = [
                            'x' => ($k + 1) * $step,
                            'y' => 20,
                        ] + $tmp;
                    }

                } unset($v);

                $tmp_info['attach_front'] = $attach;
            }

            foreach ($cfg_info as $k=>$v){

                if (!isset($tins_info[$k])) {
                    continue;
                }

                $ins_keys = array_keys($tins_info[$k]);

                foreach ($v as $key => $val){
                    $d = array_values($tins_info[$k]);

                    if (isset($d[$key]['pos']) && strpos($d[$key]['pos'], '_')) {
                        $pos = explode('_', $d[$key]['pos']);
                        $val['x'] = $pos[0];
                        $val['y'] = $pos[1];
                        $val['size'] = $pos[2];
                    }

                    $val['text'] = isset($d[$key]['content'])? $d[$key]['content'] : '';

                    if (empty($d[$key]['content']) && in_array($k, array('die', 'born', 'honorific', 'second_name_label'))){
                        $val['text'] = $d[0]['content'];
                    }

                    if ($k == 'name') {
                        $val['is_die'] = isset($d[$key]['is_die']) ? $d[$key]['is_die'] : 0;
                    }



                    if (!isset($tmp_info[$k])) {
                        $tmp_info[$k] = [];
                    }

                    if (!isset($ins_keys[$key])) {
                        $ins_keys[$key] = $ins_keys[0];
                    }
                    $tmp_info[$k][$ins_keys[$key]] = $val;
                }
            }

        }


//        $label_num = count($cfg_info['die']);
        $label_num = isset($cfg_info['born']) ? count($cfg_info['born']) : 0;

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


        if (isset($tmp_info)) {
            //处理圣名标签
            if (isset($tmp_info['second_name_label']) && !empty($tmp_info['second_name_label'])) {
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
                            $new_cfg['angle'.$k.$kk] = $this->angle($vv);
                        }
                    }
                }
                foreach ($v as $kson=>$val){
                    $new_cfg[$k.$kson] = $val;
                }
            }
        }

        return $new_cfg;
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
                    $v['text'] = isset($ins_info[$k]['content']) ? $ins_info[$k]['content'] : '';
                    $new_cfg[] = $v;
                }
            };



            $new_cfg = self::calPosition($new_cfg, $size, $is_front, $shape);
        } else {
            $tmp_info = array();

            foreach ($cfg_info as $k=>$v){
                foreach ($v as $key => $val){

                    if (!isset($ins_info[$k])) {
                        continue;
                    }

                    $d = array_values($ins_info[$k]);

                    $val['text'] = isset($d[$key]['content'])? $d[$key]['content'] : '';

                    if (empty($d[$key]['content']) && in_array($k, array('die', 'born', 'honorific', 'second_name_label'))){
                        $val['text'] = $d[0]['content'];
                    }

                    if ($k == 'name') {
                        $val['is_die'] = isset($d[$key]['is_die']) ? $d[$key]['is_die'] : 0;
                    }

                    $tmp_info[$k][$key] = $val;
                }
            }
        }
//        $label_num = count($cfg_info['die']);
        $label_num = isset($cfg_info['born']) ? count($cfg_info['born']) : 0;

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

        if (isset($tmp_info)) {
            //处理圣名标签
            if (isset($tmp_info['second_name_label']) && !empty($tmp_info['second_name_label'])) {
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
        }

        return $new_cfg;
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



    public function tomb($field = null)
    {
        $model = Tomb::findOne($this->tomb_id);
        if ($field) {
            return $model->$field;
        }
        return $model;
    }


    public function getInsCfgCases($shape='v'){


        $tomb = $this->tomb();
        $grave_id = $tomb->grave_id;

        $cfg_ids = InsCfgRel::find()->where(['grave_id'=>$grave_id])->asArray()->all();


        if (!$cfg_ids) {
            $link = '<a href="'.Url::toRoute(['/grave/admin/ins-cfg/index']).'" target="_blank">点这里</a>';
            Yii::$app->session->setFlash('success', '请先配置对应墓区的碑型'.$link);
            return;
        }

        $cfg_ids = ArrayHelper::getColumn($cfg_ids, 'cfg_id');


        $cfgs = InsCfg::find()->where(['id'=>$cfg_ids])
                              ->andWhere(['shape'=>$shape])
                              // ->andWhere(['is_front'=>1, 'shape'=>$this->shape])
                              ->asArray()
                              ->all();
        $cfg_info = [];

        foreach ($cfgs as $v) {
            $cfg_info[$v['is_front']][] = $v['id'];
        }


        $num = $this->deadCount();

        $front_filter = [
            'cfg_id' => isset($cfg_info[1])? $cfg_info[1] : [],
            'num' => $num,
            'status' => 1
        ];

        $back_filter = [
            'cfg_id' => isset($cfg_info[0])? $cfg_info[0] : [],
        ];

        $cover_filter = [
            'cfg_id' => isset($cfg_info[2])? $cfg_info[2] : [],
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


        $front = $this->getTplCfg('front');
        $back = $this->getTplCfg('back');
        $cover = $this->getTplCfg('cover');


        if (empty($front)) {
            $front_current_case_id = isset($front_cases[0]['id']) ? $front_cases[0]['id'] : 0;
        } else {
            $front_current_case_id = $front;
        }

        if (empty($back)) {
            $back_current_case_id = isset($back_cases[0]['id']) ? $back_cases[0]['id'] : 0;
        } else {
            $back_current_case_id = $back;
        }

        if (empty($cover)) {
            $cover_current_case_id = isset($cover_cases[0]['id']) ? $cover_cases[0]['id'] : 0;
        } else {
            $cover_current_case_id = $cover;
        }

        return [
            'front_current_case_id' => $front_current_case_id,
            'back_current_case_id'  => $back_current_case_id,
            'cover_current_case_id' => $cover_current_case_id
        ] + $result;

    }


    //////////////////////////////////////////// ------ 做过调整 ------ //////////////////////////////////////
    ///

    public function getFrontContent(){

        $content = $this->ins_info['front'];

        $dead_keys = array('title', 'name', 'birth', 'fete', 'age','follow', 'second_name');
        $dead_list = $this->deads();


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
                    $info[$k][$val] = isset($content[$k][$val]) ? $content[$k][$val]:'';
                }
            } else {
                $info[$k][] = $content[$k];
            }
        }

        $content = $info;


        foreach ($content['birth'] as $k=>&$v) {
            if (!isset($v['content'])) {
                continue;
            }
            $v['content'] = $this->getRelDate($v['content'],1);
            $content['fete'][$k]['content'] = isset($content['fete'][$k]['content']) ?
                $this->getRelDate($content['fete'][$k]['content'], 1) : '';
            $content['age'][$k]['content']  = isset($content['age'][$k]['content']) ?
                self::numberToChar($content['age'][$k]['content'], true, $this->is_tc) : '';
        }unset($v);


        if (isset($this->ins_info['attach']['front'])) {
            $content['attach'] = $this->ins_info['attach']['front'];
        }

        return $content;
    }



    public function getBackContent()
    {
        $content = $this->ins_info['back'];
        if (isset($this->ins_info['attach']['back'])) {
            $content['attach'] = $this->ins_info['attach']['back'];
        }

        return $content;
    }

    public function angle($vv)
    {
        $shape = $this->shape;
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

    public static function maxLength($array)
    {
        $length = 0;
        foreach ($array as $v){
            $length = $length < mb_strlen($v, 'utf-8') ? mb_strlen($v, 'utf-8') : $length;
        }
        return $length;
    }

    /**
     * @param $ins_info
     * @param $size
     * @param int $is_front
     * @return array
     * @name 计算位置
     */
    public static function calPosition($ins_info, $size, $is_front=0)
    {
        $ratio = 10;
        $main_info = $ins_info['main'];
        unset($ins_info['main']);

        $rows = count($main_info['text']);
        $shape = $main_info['shape'];
        //横着也要对齐呀
        $length = self::maxLength($main_info['text']);

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
        $cnt = count($main_info['text']);
        foreach ($main_info['text'] as $k=>$v){
            $new_ins['main'.$k] = $main_info;

            if (isset($main_info['pos'][$k]) && $main_info['pos'][$k]) {
                $pos = explode('_', $main_info['pos'][$k]);

                $new_ins['main'.$k]['x'] = $pos[0];
                $new_ins['main'.$k]['y'] = $pos[1];
            } else if ($shape == 'v') {
                $new_ins['main'.$k][$direct] = $boundary + ($main_info['size'] + $step) * ($cnt - $k - 1);//竖碑反转
            } else {
                $new_ins['main'.$k][$direct] = $boundary + ($main_info['size'] + $step) * $k;
            }
            $new_ins['main'.$k]['text']=$main_info['text'][$k];
        }

        if (isset($ins_info['attach_back']) && is_array($ins_info['attach_back'])) {
            foreach ($ins_info['attach_back'] as $k=>$v) {
                $new_ins['attach_back'.$k] = $v;
            }
            unset($ins_info['attach_back']);
        }

        return array_merge($ins_info, $new_ins);
    }


    public function inverseAlign($data)
    {
        reset($data);
        $first = current($data);
        $shape = $first['shape'];

        $dire = $shape=='h' ? 'x' : 'y';
        foreach ($data as $k=>&$v){
            if (isset($v['direction']) && $v['direction'] == 1) {
                $v[$dire] = $v[$dire] - mb_strlen($v['text'], 'utf-8') * $v['size'];
            }
        }unset($v);
        return $data;
    }

    /**
     *
     * 取落款
     */
    public function getInscribe(){
        $config = Yii::$app->controller->module->params['ins']['inscribe'];

        $tomb = $this->tomb();
        $person = $tomb->mnt_by;
        $inscribe = isset($config[$person]) ? $config[$person] : '亲人泣立';//.'敬立';
        return $inscribe;
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

        $dead_list = $this->deads();


        foreach($dead_list as $k=>$v) {
            if (in_array($v['dead_title'], array('祖父', '祖母'))) {
                $honorific = '祖';
            }
            if ($this->shape == 'v') {
                switch ($v['dead_title']){
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

    /**
     *
     * 处理post过来的碑文数据
     * @param unknown_type $data
     */
    public function handleIns(){
        $data = Yii::$app->request->post();

        $this->font = $data['font_style'];
        $this->is_tc = $data['is_tc'];
        $this->type = $data['type'];

        $front_info = $data['front'];
        $back_info  = $data['back'];
        $dead  = $data['dead'];

        $keys = array('title', 'name', 'birth', 'age', 'fete', 'second_name', 'follow');
        $dead_info = array();
        foreach ($dead as $k=>$v) {
            foreach ($keys as $val){
                $dead_info[$val][$k] = isset($dead[$k][$val]) ? $dead[$k][$val] : '';
            }
        }

        $info = array_merge($front_info, $dead_info);


        $this->ins_info['front'] = $info;
        $this->ins_info['back']  = $back_info;
        $this->ins_info['attach'] = isset($data['attach']) ? $data['attach'] : [];

        $add = array(
            'is_tc'     => $this->is_tc,
            'front_type'    => $this->type,
            'dt_pre_mn'     => $data['InsPro']['pre_finish'],
            'font'    => $this->font,
            'note'          => trim($data['InsPro']['note']),
            'type'          => $this->type
        );
        $this->ins_info = $add + $this->ins_info;

        return $this;
    }
    /**
     *
     * 取碑文整体信息
     */
    public function insInfo(){

        $ins_info = (array)json_decode($this->content, true);

        if (!isset($ins_info['front']) || empty($ins_info['front'])) {

            $this->initFront();
            $this->initBack();
        } else {
            $dead_keys = array('name', 'title', 'birth', 'fete', 'age', 'follow', 'second_name');
            $dead = array();
            foreach ($ins_info['front'] as $k=>$v) {
                if (in_array($k, $dead_keys)) {
                    foreach ($v as $key=>$val) {
                        $dead['dead'][$key][$k]=$val;
                    }
                } else {
                    $dead[$k] =$v;
                }
            }
            $data = $this->syncFront($dead);
            $this->ins_info = $ins_info;
            $this->ins_info['front'] = $data;
        }


        return $this->ins_info;
    }

    /**
     * @name 初始化碑前文
     */
    private function initFront()
    {
        $inscribe = $this->getInscribe();
        $honorific = $this->getHonorific();

        if ($this->shape == 'v') {
            $inscribe_date = self::numberToChar(date('Y'),false). '年'
                . self::numberToChar(date('m'),true). '月' ;
            $die = '故于';
            $born = '生于';
        } else {
            $inscribe_date = date('Y、m');
            $die = $born = '—';
        }

        $deads = $this->deads();

        $info = array(
            'honorific' =>[['content'=>$honorific, 'pos'=>'']],
            'tail'      => [['content'=>'之墓', 'pos'=>'']],
            'inscribe_date' => [['content'=>$inscribe_date, 'pos'=>'']],
            'inscribe'  => [['content'=>$inscribe, 'pos'=>'']],
            'die'   => [['content'=>$die, 'pos'=>'']],
            'born'  => [['content'=>$born, 'pos'=>'']],
            'agelabel1'=> [['content'=>'享年', 'pos'=>'']],
            'agelabel2'=> [['content'=>'岁', 'pos'=>'']],
            'second_name_label'=> [['content'=>'圣名', 'pos'=>'']]
        );

        foreach ($deads as $k=>$v) {
            if ($v['is_ins'] == 1) {
                $birth = $this->getBirth($v);
                $fete = $this->getFete($v);

                $birth = $this->getRelDate($birth);
                $fete = $this->getRelDate($fete);

                if ($v['follow_id']) {
                    $tit = $v['gender'] ? '携子' : '携女';
                    $data[$v['follow_id']]['follow']=['content' => $tit.$v['dead_name'], 'pos'=>''];
                    unset($v);
                } else {
                    $data[$k] = [
                        'name' => ['content' => $v['dead_name'], 'is_die'=>!$v['is_alive'], 'pos'=>''],
                        'title' => ['content' => $this->getDeadTitle($v['dead_title']), 'pos'=>''],
                        'birth' => ['content' => $birth, 'pos'=>''],
                        'fete'  => ['content' =>$fete, 'pos'=>''],
                        'age'   =>['content' =>$v['age'], 'pos'=>''],
                        'second_name' => ['content' =>$v['second_name'], 'pos'=>'']
                    ];
                }
            }
        }

        $info['dead'] = $data;
        $this->ins_info['front'] = $info;
    }

    /**
     * @name 初始碑后文
     */
    private function initBack()
    {

        if (empty($this->ins_info['back']['main'])) {
            $inscribe = $this->getInscribe();

            if ($this->shape == 'v') {
                $inscribe_date = self::numberToChar(date('Y'),false) . '年' .  self::numberToChar(date('m'),true). '月' ;
            } else {
                $inscribe_date = date('Y、m');
            }

            $back_str = array('父恩如山','母爱似海');

            if (!empty($this->ins_info['back'])) {
                $old_back = explode(',', trim($this->ins_info['back'],','));
                $back_str = $old_back;
            }

            $this->ins_info['back'] = array(
                'main' => ['content'=>$back_str, 'pos'=>''],
                'inscribe' => ['content'=>$inscribe, 'pos'=>''],
                'inscribe_date' => ['content'=>$inscribe_date, 'pos'=>'']
            );
        }

    }

    private function syncFront($data)
    {
        $ins_info = (array)json_decode($this->content, true);

        $co = $current_ins_info= $ins_info['front'];

        $deads = $this->deads();

        if (empty($current_ins_info)) {return $this->initFront();}

        $i= 0 ;
        $newdata = [];
        foreach ($deads as $k=>$v) {
            if ($v['is_ins']) {

                $birth = static::getBirth($v);
                $fete = static::getFete($v);
                $age = empty($v['age']) ? '' : $v['age'];

                if (!empty($current_ins_info['birth'][$i]['content'])){
                    $birth = $current_ins_info['birth'][$i]['content'];
                }

                if (!empty($current_ins_info['fete'][$i]['content'])){
                    $fete = $current_ins_info['fete'][$i]['content'];
                }

                if (!empty($current_ins_info['age'][$i]['content'])){
                    $age = $current_ins_info['age'][$i]['content'];
                }

                $newdata[$k] = [
                    'name' => ['content' => $v['dead_name'], 'is_die'=>!$v['is_alive'], 'pos'=>isset($co['name'][$i]['pos'])?$co['name'][$i]['pos']:''],
                    'title' => ['content' => $this->getDeadTitle($v['dead_title']), 'pos'=>isset($co['title'][$i]['pos'])?$co['title'][$i]['pos']:''],
                    'birth' => ['content' => $birth, 'pos'=>isset($co['birth'][$i]['pos'])?$co['birth'][$i]['pos']:''],
                    'fete'  => ['content' =>$fete, 'pos'=>isset($co['fete'][$i]['pos'])?$co['fete'][$i]['pos']:''],
                    'age'   =>['content' =>$age, 'pos'=>isset($co['age'][$i]['pos'])?$co['age'][$i]['pos']:''],
                    'follow'  =>['content' =>isset($current_ins_info['follow'][$i]['content']) ?
                        $current_ins_info['follow'][$i]['content'] : '' , 'pos'=>isset($co['follow'][$i]['pos'])?$co['follow'][$i]['pos']:''],
                    'second_name'  =>['content' =>$v['second_name'], 'pos'=>isset($co['second_name'][$i]['pos'])?$co['second_name'][$i]['pos']:'']
                ];
            }
            $i++;
        }

        if (empty($newdata)) {return $this->initFront();}

        $data['dead'] = $newdata;

        return $data;
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
            if(isset($dead['birth_year']))
                $birth = $dead['birth_year'];
            if(isset($dead['birth_month']))
                $birth .= '-'.$dead['birth_month'];
            if(isset($dead['birth_day']))
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
            if(isset($dead['fete_year']))
                $fete = $dead['fete_year'];
            if(isset($dead['fete_month']))
                $fete .= '-'.$dead['fete_month'];
            if(isset($dead['fete_day']))
                $fete .= '-'.$dead['fete_day'];
        }

        $fete  = str_replace('-', '.', $fete);

        self::isNullDt($fete) && $fete = '';

        return $fete;
    }


    ////////////////////////////////////////////--- 一些静态方法 ----/////////////////////////

    /**
     * @param $num
     * @param bool $mode
     * @param bool $is_tc
     * @return string
     */
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
                    // if($str[$i]+$str[$i-1] == 0){
                    //     $out[$i] = '';
                    // }

                    if ($str[$i] == 0) {
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

    public static function isNullDt($value)
    {
        if ( $value != NULL) {
            if (in_array($value, array('0000-00-00 00:00:00', '0000-00-00', ''))) {
                $value = NULL;
            }
        }
        return !(boolean)$value;
    }

    public static function insGoods($tomb_id, $sku, $rel)
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
        $ins->goods_id = $sku->goods->id;
        $ins->shape = self::getInsGoodsShape($sku->goods->id);
        $ins->user_id = $tomb->user_id;
        $ins->guide_id = $tomb->guide_id;
        $ins->pre_finish = null;
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

        if (!isset($rel['av_id'])) return null;

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
