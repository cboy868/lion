<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
app\assets\ExtAsset::register($this);
?>
<style>
    .hid .help-block{
        margin:0;
    }
</style>
<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="hid">
        <?= $form->field($model, 'tomb_id')->hiddenInput(['class'=>'tomb_id'])->label(false) ?>
    <?= $form->field($model, 'box_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'area_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'action')->hiddenInput()->label(false) ?>
    </div>
    <?=\app\modules\grave\widgets\TombSearch::widget(['form'=>$form])?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true,'class'=>'form-control contact']) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true, 'class'=>'form-control mobile']) ?>

    <?= $form->field($model, 'relation')->textInput(['maxlength' => true, 'class'=>'form-control relation']) ?>

    <?= $form->field($model, 'deads')->textInput(['maxlength' => true,'class'=>'form-control deads']) ?>

    <?= $form->field($model, 'bury_date')->textInput(['dt'=>'true']) ?>

    <?= $form->field($model, 'out_way')->dropDownList([1=>'自取',2=>'工作人员代取']) ?>

    <?= $form->field($model, 'save_user')->textInput(['maxlength' => true,'class'=>'form-control save_user']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('sel') ?>
$(function(){
    $('.gv').change(function(){
        getTombInfo();
    });
})

function getTombInfo()
{
    var gid = $('.ggrave').val();
    var row = $('.grow').val();
    var col = $('.gcol').val();
    var url = "<?=\yii\helpers\Url::toRoute(['/ashes/admin/log/tomb'])?>"
    if (!gid || !row || !col)  {return;}
    var data = {grave_id:gid,row:row,col:col};
    $.get(url,data,function(xhr){
        if (!xhr.status) {
            $('.contact').val('');
            $('.mobile').val('');
            $('.relation').val('');
            $('.deads').val('');
            $('.save_user').val('');
            retrn;
        }

        $('.tomb_id').val(xhr.data.tomb.id);

        if ('customer' in xhr.data){
            var c = xhr.data.customer;
            $('.contact').val(c.name);
            $('.mobile').val(c.mobile);
            $('.relation').val(c.relation);
            $('.save_user').val(c.name);
        } else {
            $('.contact').val('');
            $('.mobile').val('');
            $('.relation').val('');
            $('.save_user').val('');
        }

        if ('deads' in xhr.data){
            var d = xhr.data.deads;
            var title='';
            for(i in d){
                title += d[i].dead_name + ',';
            }
            $('.deads').val(title);

        } else {
            $('.deads').val('');
        }

    },'json');

}
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['sel'], \yii\web\View::POS_END); ?>

