<?php
namespace app\modules\grave\widgets;

use yii;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Tomb as TombModel;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Ins;
use app\modules\order\models\Order;
use app\modules\grave\models\CarRecord;
use app\modules\grave\models\Bury;
use app\modules\order\models\Refund;
use app\modules\task\models\Task;
use app\modules\sys\models\Note;
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
        'refund',  //退款记录
        'car',       //派车
        // 'memorial',  //纪念馆
        'dead',      //逝者
        'task',      //任务
        'note',      //备注
        'bury',        // 安葬记录
        'withdraw',    // 退墓记录
        // 'photo',       // 相册
        'todo',    // 墓位待办事项
        'refund',
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
      $orders = Order::find()->where(['tid'=>$this->tomb_id, 'status'=>Order::STATUS_NORMAL])->all();
      return $this->render('tomb/order', ['orders'=>$orders]);
    }

    /**
     * @name 退款记录
     */
    public function refund()
    {
      $refunds = Refund::find()->where(['tid'=>$this->tomb_id, 'status'=>Order::STATUS_NORMAL])->all();
      return $this->render('tomb/refund', ['refunds'=>$refunds]);
    }
    public function car()
    {
      $records = CarRecord::find()->where(['tomb_id'=>$this->tomb_id, 'status'=>Order::STATUS_NORMAL])->all();

      $records = ArrayHelper::index($records, 'id', 'car_type');
      return $this->render('tomb/car', ['records'=>$records]);
    }
    public function memorial()
    {
      return $this->render('tomb/memorial');
    }
    /**
     * @name 使用人信息
     */
    public function dead()
    {
      $deads = $this->tomb->deads;
      return $this->render('tomb/dead', ['deads'=>$deads]);
    }
    public function task()
    {
      $tasks = Task::find()->where(['res_id'=>$this->tomb_id, 'res_name'=>'tomb'])->orderBy('id asc')->all();
      $tasks = ArrayHelper::index($tasks, 'id', 'cate_id');
      return $this->render('tomb/task', ['tasks'=>$tasks]);
    }
    public function note()
    {
      $notes = Note::find()->where(['res_name'=>['tomb'], 'res_id'=>$this->tomb_id])->all();
      $notes = ArrayHelper::index($notes, 'id', 'res_name');

      return $this->render('tomb/note', ['notes'=>$notes]);
    }
    public function bury()
    {
      $burys = Bury::find()->where(['tomb_id'=>$this->tomb_id, 'status'=>[Bury::STATUS_NORMAL, Bury::STATUS_OK]])->orderBy('id asc')->all();
      $burys = ArrayHelper::index($burys, 'id', 'status');
      return $this->render('tomb/bury', ['burys'=>$burys]);
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