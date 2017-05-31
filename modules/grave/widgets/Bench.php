<?php
namespace app\modules\grave\widgets;

use app\modules\sys\models\Menu;
use app\modules\user\models\MenuRel;
use yii;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Task;
use app\modules\mod\models\Code;
use app\core\db\ActiveRecord;
use app\modules\client\models\Client;
use app\core\helpers\Url;

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

//    $tasks = Task::find()->where(['op_id'=>$this->uid, 'status'=>Task::STATUS_NORMAL])
//                         ->andWhere(['like', 'pre_finish', date('Y-m-d')])
//                         ->orderBy('pre_finish asc')
//                         ->limit($this->limit)
//                         ->all();


        $tasks = Task::find()->where(['op_id'=>$this->uid, 'status'=>Task::STATUS_NORMAL])
            ->andWhere(['>=', 'pre_finish', date('Y-m-d', strtotime('-1 day'))])
            ->andWhere(['<=', 'pre_finish', date('Y-m-d', strtotime('+1 day'))])
            ->orderBy('pre_finish asc')
            ->limit($this->limit)
            ->all();

        $result = [];
        foreach ($tasks as $v) {
            $date = date('Y-m-d', strtotime($v['pre_finish']));

            switch ($v['pre_finish']) {
                case date('Y-m-d') == $date :$result['today'][] = $v;
                    break;
                case date('Y-m-d', strtotime('-1 day')) == $date :$result['yestoday'][] = $v;
                    break;
                case date('Y-m-d', strtotime('+1 day')) == $date :$result['tomorrow'][] = $v;
                    break;
            }
        }

        return $this->render('bench/task', ['models'=>$result]);
    }

    private function client()
    {

      $client = Client::find()->where(['guide_id'=>$this->uid, 'status'=>Task::STATUS_NORMAL])
                         ->orderBy('id desc')
                         ->limit($this->limit)
                         ->all();

      return $this->render('bench/client', ['models'=>$client]);
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

      return $this->render('bench/post', ['models'=>$list]);
    }

    private function buttons()
    {
        $menus = MenuRel::find()->where(['user_id'=>Yii::$app->user->id])->asArray()->all();
        $panels = Yii::$app->getModule('sys')->params['panels'];
        $result = [];

//        $menus = false;
        if (!$menus) {
            $menus = Menu::authMenu('ico is not null and panel is not null');
        }

        foreach ($menus as $v) {
                $auth_name = substr_replace($v['auth_name'], '/admin', strpos($v['auth_name'], '/'), 0);
                $v['url'] = Url::toRoute(['/'.$auth_name]);
                $result[$v['panel']][] = $v;
        };

      return $this->render('bench/buttons', ['menus'=>$result, 'panels'=>$panels]);
    }





}