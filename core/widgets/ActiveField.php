<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\widgets;

use app\core\helpers\Html;
// use app\assets\UeditorAsset;

/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class ActiveField extends \yii\widgets\ActiveField
{



	/**
	 * @name checkboxlists 分组使用见/mg.php/shop/goods/create?category_id=2
	 */
    public function checkboxLists($items, $options = [])
    {
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeCheckboxLists($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * @name radiolists 分组使用见/mg.php/shop/goods/create?category_id=2
     */
    public function radioLists($items, $options = [])
    {

        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioLists($this->model, $this->attribute, $items, $options);

        return $this;
    }

// 	public function ueditor($options = [])
//     {
//         UeditorAsset::register($this->form->getView());

//         $options = array_merge($this->inputOptions, $options);
//         $this->adjustLabelFor($options);
//         if(!isset($options['id'])) {
//         	$options['id'] = 'editor';
//         }
//         $this->parts['{input}'] = static::activeUeditor($this->model, $this->attribute, $options);

//         return $this;
//     }


//     public function activeUeditor($model, $attribute, $options = [])
//     {
//         $name = isset($options['name']) ? $options['name'] : Html::getInputName($model, $attribute);

//         $value = Html::getAttributeValue($model, $attribute);

//         if (!array_key_exists('id', $options)) {
//             $options['id'] = static::getInputId($model, $attribute);
//         }
//         $style = isset($options['style']) ? "style=\"{$options['style']}\"" : '';

//         $script = <<<SCRIPT
//         <script name="%s" id="%s" type="text/plain" %s>%s</script>
//         <script>
//             $(function(){
//                 var ue = UE.getEditor('%s');
//             });
//         </script>
// SCRIPT;
//         return sprintf($script, $name, $options['id'], $style, $value, $options['id']);
//     }

}