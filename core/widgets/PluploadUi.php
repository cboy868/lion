<?php

namespace app\core\widgets;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use app\assets\PluploaduiAssets;
use yii\base\Widget;

/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['formData'=>['res_name'=>'article', 'db'=>true]]]);?>
 */
class PluploadUi extends Widget {
   
    public $options = [
    	'formData' => [
    		'res_name' => 'ad',
            'server' => ''
    	]
    ];

    /**
     * Renders the widget.
     */
    public function run() {

        $this->options['formData']['server'] = \yii\helpers\Url::toRoute(['pl-upload']);

        PluploaduiAssets::register($this->view);

        return $this->render('plupload', ['options'=>$this->options]);
    }

}
