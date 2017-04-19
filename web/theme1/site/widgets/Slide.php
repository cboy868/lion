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
class Slide extends Widget {


    public $options;

    /**
     * Renders the widget.
     */
    public function run() {
        $focus = $this->getFocus();
        return $this->render('slide', ['focus'=>$focus]);
    }

    public function getFocus()
    {
        return Focus::getFocusByCategory($this->options['cate'], $this->options['limit'], $this->options['size']);
    }

}
