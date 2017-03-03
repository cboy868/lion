<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
use app\assets\ExtAsset;
use app\assets\SelectAsset;

ExtAsset::register($this);
SelectAsset::register($this);

?>



<style type="text/css">
.form-inline .form-group{
        /*margin-bottom: 10px;*/
    }
    .selectize-control{
        display: inline-block;
    }

    .selectize-input {
    border: 1px solid #d0d0d0;
    padding: 2px 8px;
    width: 100%;
    overflow: visible;
}
</style>

<?= $form->field($model, 'grave_id')->dropDownList($grave, ['class'=>'sel-ize', 'style'=>'width:200px;', 'prompt'=>'请选择墓区']) ?>
<?= $form->field($model, 'row')->textInput(['style'=>'width:60px']) ?>
<?= $form->field($model, 'col')->textInput(['style'=>'width:60px']) ?>



<?php $this->beginBlock('sel') ?>  

$(function(){
    $('.grave').selectpicker({
        'selectedText': 'cat'
    });
})



<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['sel'], \yii\web\View::POS_END); ?> 












