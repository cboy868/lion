<?php

namespace app\modules\grave\models;

use app\modules\shop\models\Goods;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;


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
class Ins extends \app\core\db\ActiveRecord
{

    const PAINT_JINBO = 1;
    const PAINT_TONG =2;
    const PAINT_QI =3;
    const PAINT_PEN =4;


    const SHAPE_H = 'h'; //横
    const SHAPE_V = 'v'; //竖

    const CONFIRM_YES = 1;
    const CONFIRM_NO = 0;


    const TC_YES = 1;
    const TC_NO = 0;

    const TYPE_IMG = 0;
    const TYPE_AUTO = 1;
    const TYPE_FREE = 2;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }


    public function getFontStyle()
    {

        $fonts = [
            0 => "华文新魏", 
            1 => "行楷",
            2 => "方正隶书", 
            3 => "宋体", 
            4 => "楷体",
        ];

        return $fonts[$this->font];
    }

    public function confirm($uid)
    {
        $this->confirm_by = $uid;
        $this->confirm_date = date('Y-m-d H:i:s');
        $this->is_confirm = self::CONFIRM_YES;
        return $this->save();
    }


    public static function paint($paint = null)
    {
        $paints = [
            self::PAINT_JINBO => '金箔',
            self::PAINT_TONG => '铜粉',
            self::PAINT_QI => '红漆'
            // self::PAINT_PEN => '反喷',
            
        ];
        return $paint === null ? $paints : $paints[$paint];
    }

    public function getPaintTxt()
    {
        return $this->paint ? self::paint($this->paint) : '';
    }


    public static function shapes($shape = null)
    {
        $shapes = [
            self::SHAPE_H => '横',
            self::SHAPE_V => '竖'
        ];
        return $shape === null ? $shapes : $shapes[$shape];
    }

    public function getShape()
    {
        return self::shapes($this->shape);
    }

    public function getFront($size=null)
    {
        $img = (array)json_decode($this->img);
        return Attachment::getById($img['front'], $size);
    }

    public function getBack($size=null)
    {
        $img = (array)json_decode($this->img);
        return Attachment::getById($img['back'], $size);
    }

    public function getImg($position = 'front', $default='#')
    {

        $img = (array)json_decode($this->img);

        return (isset($img[$position]) && !empty($img[$position])) ? Attachment::getById($img[$position], '', $default) : $default;

        $img = isset($img[$position]) && !empty($img[$position]) ? $img[$position] : '#';

        return $img == '#' ? '#' : Attachment::getById($img);
    }


    public static function getIsConfirm($is_confirm = null)
    {
        $confirm = [
            self::CONFIRM_NO => '未确认',
            self::CONFIRM_YES => '已确认'
        ];

        return $is_confirm === null ? $confirm : $confirm[$is_confirm];
    }

    public static function getIsTc($is_tc = null)
    {
        $tc = [
            self::TC_YES => '繁体',
            self::TC_NO => '简体'
        ];

        $tc = $tc === null ? $tc : $tc[$is_tc];

        return $tc;
    }

    public function getFrontCfg()
    {
        $tpl_cfg = $this->tpl_cfg;
        if (!$tpl_cfg) {
            return null;
        }

        $cfg = json_decode($tpl_cfg);

        return $cfg['front'];

    }

    public function getTplCfg($pos = 'front')
    {
        $tpl_cfg = $this->tpl_cfg;
        if (!$tpl_cfg) {
            return null;
        }

        $cfg = json_decode($tpl_cfg);

        return $cfg[$pos];
    }

        /**
     * @name 取使用人
     */
    public function deads()
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
    public function deadCount($ext_follow = true){

        return count($this->deads());
    }

    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id'], 'required'],
            [['pre_finish'], 'required', 'on'=>'handleIns'],
            [['guide_id', 'user_id', 'tomb_id', 'op_id', 'is_tc', 'final_tc', 'font', 'is_confirm', 'confirm_by', 
            'version', 'paint', 'is_stand', 'status', 'updated_at', 'created_at', 'type',
            'big_num','small_num','new_big_num', 'new_small_num', 'changed', 'goods_id'], 'integer'],
            [['content', 'note'], 'string'],
            [['confirm_date', 'pre_finish', 'finish_at'], 'safe'],
            [['paint_price', 'letter_price', 'tc_price'], 'number'],
            [['position', 'shape'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guide_id' => '导购员',
            'user_id' => '用户账号',
            'tomb_id' => '墓位ID',
            'op_id' => '操作员',
            'position' => '位置',
            'shape' => '碑型',
            'content' => '碑文内容',
            'img' => '碑文图片',
            'is_tc' => '是否繁体',
            'final_tc' => '支付时是否繁体',
            'font' => '字体',
            'big_num' => '大字数',
            'small_num' => '小字数',
            'new_big_num' => '大字数',
            'new_small_num' => '小字数',
            'is_confirm' => '是否确认',
            'confirm_date' => '确认日期',
            'confirm_by' => '确认人',
            'pre_finish' => '预定完成日期',
            'finish_at' => '实际完成日期',
            'note' => '备注',
            'version' => '版本',
            'paint' => '颜料',
            'is_stand' => '是否已立碑',
            'paint_price' => '颜料费',
            'letter_price' => '刻字费',
            'tc_price' => '繁体费',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
            'guide.username' => '导购',
            'op.username' => '操作员',
            'user.username' => '账号',
            'confirm.username'=> '确认人',
            'paintTxt'=> '颜料'

        ];
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(),['id'=>'tomb_id']);
    }

    public function getConfirm()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'confirm_by']);
    }

    public function getGuide()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'guide_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getOp()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'op_id']);
    }

    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    /**
     * @name 支付完成后的动作
     */
    public static function afterPay($event)
    {

        $pay = $event->sender;

        $order = $pay->order;

        if (!in_array($order->progress, [\app\modules\order\models\Order::PRO_PAY, \app\modules\order\models\Order::PRO_OK])) {
            return ;
        }

        if (!isset($order->tid) || empty($order->tid)) {
            return;
        }

        $model = self::find()->where(['tomb_id'=>$order->tid])->one();

        if (!$model) {
            return ;
        }

        $model->big_num += $model->new_big_num;
        $model->new_big_num = 0;
        $model->small_num += $model->new_small_num;
        $model->new_small_num = 0;

        $model->final_tc = $model->is_tc;

        $model->is_confirm = 0;
        $model->confirm_date = null;
        $model->confirm_by = 0;

        return $model->save();

    }


    // public function getImgs($size=, $default='/static/images/defaut.png')
    // {
    //     $imgs = json_decode($this->img);


    //     foreach ($imgs as $k => &$v) {
    //         $v['img'] = Attachment::getById($v, $size, $default);
    //         $v['id'] = $v;
    //     }unset($v);
        

    //     return $imgs;

    // }
}
