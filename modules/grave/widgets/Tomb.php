<?php
namespace app\modules\grave\widgets;

use yii;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Tomb as TombModel;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Ins;
/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class Tomb extends \yii\base\Widget
{

    public $tomb_id;

    public $tomb;
    
    public $method;

    protected $methods = array(
        'tomb',      //墓位详情
        'customer',  //客户信息
        'ins',       //碑文
        'portrait',  //瓷像
        'order',     //订单
        'car',       //派车
        'memorial',  //纪念馆
        'dead',      //逝者
        'task',      //任务
        'note',      //备注
        'pre_bury',    // 预葬记录
        'bury',        // 安葬记录
        'withdraw',    // 退墓记录
        // 'photo',       // 相册
        'todo',    // 墓位待办事项
        // 'attachment',  // 墓位待办事项
        // 'complaint',   // 投诉
        // 'goods',       //墓位购买商品
    );

    /**
     * Renders the widget.
     */
    public function run() {
      $this->tomb = TombModel::findOne($this->tomb_id);
      $method = $this->method;
      return $this->$method();
    }

    public function tomb()
    {
      return $this->render('tomb/tomb', ['tomb'=>$this->tomb]);
    }
    public function customer()
    {
      $customer = Customer::find()->where(['tomb_id'=>$this->tomb_id, 'status'=>Customer::STATUS_NORMAL])->one();
      return $this->render('tomb/customer', ['customer'=>$customer]);
    }
    public function ins()
    {
      $ins = Ins::find()->where(['tomb_id'=>$this->tomb_id, 'status'=>Ins::STATUS_NORMAL])->one();
      return $this->render('tomb/ins', ['ins'=>$ins]);
    }
    public function portrait()
    {
      return $this->render('tomb/portrait');
    }
    public function order()
    {
      return $this->render('tomb/order');
    }
    public function car()
    {
      return $this->render('tomb/car');
    }
    public function memorial()
    {
      return $this->render('tomb/memorial');
    }
    public function dead()
    {
      return $this->render('tomb/dead');
    }
    public function task()
    {
      return $this->render('tomb/task');
    }
    public function note()
    {
      return $this->render('tomb/note');
    }
    public function pre_bury()
    {
      return $this->render('tomb/pre_bury');
    }
    public function bury()
    {
      return $this->render('tomb/bury');
    }
    public function withdraw()
    {
      return $this->render('tomb/withdraw');
    }
    public function todo()
    {
      return $this->render('tomb/todo');
    }

    




}