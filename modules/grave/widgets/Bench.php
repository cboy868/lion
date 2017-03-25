<?php
namespace app\modules\grave\widgets;

use yii;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Task;
use app\modules\mod\models\Code;
use app\core\db\ActiveRecord;
use app\modules\client\models\Client;

/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class Bench extends \yii\base\Widget
{


    public $name;

    public $uid;

    public $mod;//只有文章和图册部分用的到

    public $limit = 20;
    /**
     * Renders the widget.
     */
    public function run() {
      $method = $this->name;
      $this->uid = Yii::$app->user->id;
      return $this->$method();
    }

    private function task()
    {

    $tasks = Task::find()->where(['op_id'=>$this->uid, 'status'=>Task::STATUS_NORMAL])
                         ->andWhere(['like', 'pre_finish', date('Y-m-d')])
                         ->orderBy('pre_finish asc')
                         ->limit($this->limit)
                         ->all();

      return $this->render('bench\task', ['models'=>$tasks]);
    }

    private function client()
    {

      $client = Client::find()->where(['guide_id'=>$this->uid, 'status'=>Task::STATUS_NORMAL])
                         ->orderBy('id desc')
                         ->limit($this->limit)
                         ->all();

      return $this->render('bench\client', ['models'=>$client]);
    }

    private function post()
    {
      $mod = $this->mod;


      Code::createObj('post', $mod);
      $class = '\app\modules\cms\models\mods\Post' . $mod;

      $list = $class::find()->where(['status'=>ActiveRecord::STATUS_NORMAL])
                            ->andWhere(['<', 'created_at', strtotime(date('Y-m-d') . ' +1 day')])
                            ->andWhere(['>', 'created_at', strtotime(date('Y-m-d'))])
                            ->limit($this->limit)
                            ->orderBy('id asc')
                            ->all();

      return $this->render('bench\post', ['models'=>$list]);
    }

    private function buttons()
    {
      return $this->render('bench\buttons');
    }




}