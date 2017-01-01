<?php
namespace app\modules\sys\controllers\admin;

use Yii;

/**
 * @name 系统信息
 * @panel 10
 */
class InfoController extends \app\core\web\BackController
{

    /**
     * @name PHP信息
     * @menu true
     */
    public function actionPhp()
    {
        return $this->render('php');
    }

    /**
     * @name 数据库信息
     * @menu true
     */
    public function actionDb()
    {
        $tables = Yii::$app->db->schema->getTableSchemas();
        return $this->render('db', ['tables'=>$tables]);
    }


    /**
     * @name 公共方法
     */
    public function actionF()
    {
        return $this->render('f');
    }

}

