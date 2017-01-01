<?php

namespace app\core\widgets\Ueditor;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Url;
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

    public $serverUrl;

    public $readyEvent;

    /**
     * Initializes the widget.
     */
    public function init() {
        parent::init();
        if (empty($this->id)) {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if (empty($this->name)) {
            $this->name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->id;
        }
        if (empty($this->value) && $this->hasModel() && $this->model->hasAttribute($this->attribute)) {
            $this->value = $this->model->getAttribute($this->attribute);
        }

        $option = $this->option;
        $res_name = isset($option['res_name']) ? $option['res_name'] : '';
        $use = isset($option['use']) ? $option['use'] : '';
        $this->serverUrl = Url::toRoute(['ue-upload', 'res_name'=>$res_name, 'use'=>$use]);
        
        $this->jsOptions['serverUrl'] = $this->serverUrl;

    }

    /**
     * Renders the widget.
     */
    public function run() {

        UAsset::register($this->view);
        $this->registerScripts();

        if ($this->renderTag) {
            return $this->renderTag();
        }
    }

    public function renderTag() {
        $id = $this->id;
        $content = $this->value;
        $name = $this->name;
        $style = $this->style ? " style=\"{$this->style}\"" : '';
        return <<<EOF
<script id="{$id}" name="{$name}"$style type="text/plain">{$content}</script>
EOF;
    }

    public function registerScripts() {
        $jsonOptions = Json::encode($this->jsOptions);
        $script = "UE.getEditor('{$this->id}', " . $jsonOptions . ")";

        // var_dump($this->readyEvent);die;
        if ($this->readyEvent) {
            $script .= ".ready(function(){{$this->readyEvent}})";
        }
        $script .= ';';
        $this->view->registerJs($script, View::POS_READY);
    }

}
