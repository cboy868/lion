<?php

namespace app\modules\approval\controllers\admin;

use Yii;
use app\modules\approval\models\Approval;
use app\modules\approval\models\SearchApproval;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Approval model.
 */
class ProfileController extends \app\core\web\ProfileController
{
    /**
     * Lists all Approval models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWork()
    {
        return $this->render('work');
    }

}
