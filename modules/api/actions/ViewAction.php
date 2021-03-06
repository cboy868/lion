<?php

namespace app\modules\api\actions;

use Yii;

class ViewAction extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        return $model;
    }
}
