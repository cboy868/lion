<?php

namespace app\modules\user;


class Module extends \app\core\base\Module
{

    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config.php'));
        // custom initialization code goes here
    }

}
