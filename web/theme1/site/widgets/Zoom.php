<?php

namespace app\web\theme\site\widgets;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;

use app\modules\focus\models\Focus;
/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['formData'=>['res_name'=>'article', 'db'=>true]]]);?>
 */
class Zoom extends Widget {

    public $imgs;

    /**
     * Renders the widget.
     */
    public function run() {

    	if (!$this->imgs) {
    		return ;
    	}
        return $this->render('zoom', ['imgs'=>$this->imgs]);
    }


}
