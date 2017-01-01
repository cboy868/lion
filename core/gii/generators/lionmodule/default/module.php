<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */



echo "<?php\n";
?>

namespace app\modules\<?= $generator->moduleDir?>;


class Module extends \app\core\base\Module
{

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
   
}
