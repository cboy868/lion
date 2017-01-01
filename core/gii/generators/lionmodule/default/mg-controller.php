<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace app\modules\<?= $generator->moduleDir?>\controllers\mg;


class DefaultController extends \app\core\web\MgController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
