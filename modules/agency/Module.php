<?php

namespace app\modules\agency;


class Module extends \app\core\base\Module
{

    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config.php'));


        // custom initialization code goes here
    }


    public function categorys($id=null)
    {
        $categorys = $this->params['category'];

        if ($id !== null && isset($categorys[$id])) {
            return $categorys[$id];
        }

        return $categorys;
    }
    
   
}
