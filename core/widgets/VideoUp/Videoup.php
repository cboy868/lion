<?php

namespace app\core\widgets\Videoup;

use app\core\widgets\Videoup\VideoAsset;
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
class Videoup extends Widget {
   
    public $options = [
            // 'res_name' => 'ad',
    ];

    /**
     * Renders the widget.
     */
    public function run() {

        $this->options['server'] = \yii\helpers\Url::toRoute(['video-upload']);
        $this->options['id'] = isset($this->options['id']) ? $this->options['id'] : '';

        VideoAsset::register($this->view);

        return $this->render('web', ['options'=>$this->options]);
    }


}
