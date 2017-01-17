<?php

namespace app\core\widgets\Ueditor;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/**
 * Ueditor Widget
 *
 */
class Ueditor extends InputWidget {

    /**
     * @var string 
     */
    public $id;

    /**
     * @var string 
     */
    public $value;

    /**
     * @var string 
     */
    public $name;

    /**
     * @var style
     */
    public $style;

    /**
     * @var string/bool
     */
    public $renderTag = true;

    /**
     * @var array
     */
    public $jsOptions = [];

    public $option = [];


    public $readyEvent;

    /**
     * Initializes the widget.
     */
    public function init() {

        if (isset($this->options['id'])) {
            $this->id = $this->options['id'];
        } else {
            $this->id = $this->hasModel() ? Html::getInputId($this->model,$this->attribute) : $this->id;
        }

        $option = $this->option;
        $res_name = isset($option['res_name']) ? $option['res_name'] : '';
        $use = isset($option['use']) ? $option['use'] : '';
        $serverUrl = Url::toRoute(['ue-upload', 'res_name'=>$res_name, 'use'=>$use]);

        $jsOptions = [
            'serverUrl' => $serverUrl,
            'initialFrameWidth' => '100%',
            'initialFrameHeight' => '400',
            'lang' => (strtolower(\Yii::$app->language) == 'en-us') ? 'en' : 'zh-cn',
        ];

        $this->jsOptions = ArrayHelper::merge($jsOptions, $this->jsOptions);

        parent::init();

    }

    /**
     * Renders the widget.
     */
    public function run() {
        $this->registerScripts();

        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['id' => $this->id]);
        } else {
            return Html::textarea($this->id, $this->value, ['id' => $this->id]);
        }
    }

    
    public function registerScripts() {
        UAsset::register($this->view);
        $jsonOptions = Json::encode($this->jsOptions);
        $script = "UE.getEditor('{$this->id}', " . $jsonOptions . ")";
        $this->view->registerJs($script, View::POS_READY);
    }

}
