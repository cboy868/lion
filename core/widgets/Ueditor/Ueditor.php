<?php

namespace app\core\widgets\Ueditor;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


// 例

// $form->field($dataModel,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
// 'option' =>['res_name'=>'post'.$mod, 'use'=>'ue'], 
// 'value'=>$dataModel->body,
// 'jsOptions' => [
//     'toolbars' => [
//         [
//             'fullscreen', 'source', 'undo', 'redo', '|',
//             'fontsize',
//             'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
//             'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
//             'forecolor', 'backcolor', '|',
//             'lineheight', 'simpleupload', '|',
//             'indent', '|'
//         ],
//     ]
// ]
// ])


/**
 * Ueditor Widget
 *
 */
class Ueditor extends InputWidget {

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
            $this->id = $this->hasModel() ? Html::getInputId($this->model,$this->attribute) : $this->getId();
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
            'autoFloatEnabled' => false,
            'toolbars' => [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch',
                    'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'insertcode', 'pagebreak', 'background', '|',//'template',
                    'horizontal', 'spechars', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                    'print'
                ]]
        ];

        $this->jsOptions = array_merge($jsOptions, $this->jsOptions);

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
        $this->id = str_replace('-', '_', $this->id);
        $script = "editor_".$this->id." = UE.getEditor('{$this->id}', " . $jsonOptions . ")";
        $this->view->registerJs($script, View::POS_READY);
    }

}






