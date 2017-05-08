<?php

namespace app\core\widgets\Webup;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use app\core\widgets\Webup\WAsset;
use yii\base\Widget;
// use yii\widgets\InputWidget;

/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['res_name'=>'goods', 'id'=>'goods']]);?>
 */
class Webup extends Widget {
   
    public $options = [
            // 'res_name' => 'ad',
    ];

    /**
     * Renders the widget.
     */
    public function run() {

        $this->options['server'] = \yii\helpers\Url::toRoute(['web-upload']);
        $this->options['id'] = isset($this->options['id']) ? $this->options['id'] : '';

        WAsset::register($this->view);

        return $this->render('web', ['options'=>$this->options]);
    }


}
