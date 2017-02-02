<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\core\web\BackController;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class ProcessController extends BackController
{
    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

  
}
