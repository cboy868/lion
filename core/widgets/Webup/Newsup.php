<?php

namespace app\core\widgets\Webup;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use app\core\widgets\Webup\AreaAsset;
use yii\base\Widget;
// use yii\widgets\InputWidget;

/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['formData'=>['res_name'=>'article']]]);?>
 */
class Newsup extends Widget {
   
    public $options;

    /**
     * Renders the widget.
     */
    public function run() {

        $this->options['server'] = \yii\helpers\Url::toRoute(['web-upload']);
        $this->options['id'] = isset($this->options['id']) ? $this->options['id'] : '';

        NewsAsset::register($this->view);

        return $this->render('news', ['options'=>$this->options]);
    }

}
