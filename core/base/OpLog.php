<?php

namespace app\core\base;

use Yii;
use yii\helpers\Url;
use app\core\db\ActiveRecord;


class OpLog
{
    public static function write($event)
    {
        // 排除日志表自身,没有主键的表不记录（没想到怎么记录。。每个表尽量都有主键吧，不一定非是自增id）
        if($event->sender instanceof \app\core\models\OpLog || !$event->sender->primaryKey()) {
            return;
        }

        $desc = '';

        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增 %s";
            if (!empty($event->changedAttributes)) {
                $desc = '';
                foreach($event->changedAttributes as $name => $value) {
                    if (!$event->sender->getAttribute($name)) continue;
                    $desc .= $name . ' : ' . $event->sender->getAttribute($name) . ',';
                }
                $desc = substr($desc, 0, -1);
            }
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改 %s";
            if (!empty($event->changedAttributes)) {

                foreach($event->changedAttributes as $name => $value) {
                    $oldValue = $value ? $value : 'null';
                    $newValue = $event->sender->getAttribute($name) ? $event->sender->getAttribute($name) : 'null';

                    $desc .= $name . ' : ' . $oldValue .'=>'. $newValue . ',';
                }
            }
        } else {
            $description = "%s删除 %s";
            foreach ($event->sender->getOldAttributes() as $name=>$value) {
                $desc .= $name . ' : ' . $value . ',';
            }
        }

        $desc = substr($desc, 0, -1);

        $userName = '';
        $userId = 0;
        if (!Yii::$app->user->isGuest) {
            $userName = Yii::$app->user->identity->username;
            $userId = Yii::$app->user->id;
        }

        $tableName = $event->sender->tableSchema->name;
        $description = sprintf($description, $userName, $desc);
        $route = Url::to();

        $ip = ip2long(Yii::$app->request->userIP);
        $data = [
            'table_name' => $tableName,
            'route' => $route,
            'description' => $description,
            'user_id' => $userId,
            'ip' => $ip
        ];
        $model = new \app\core\models\OpLog();
        $model->setAttributes($data);
        $model->save();
    }
}