<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\sys\models\Announce;

\app\assets\ExtAsset::register($this);
?>

<div class="announce-form">

    <?php $form = ActiveForm::begin(['id'=>'annForm']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'start')->textInput(['dt'=>'true'])->hint('如不填写，则从即日起展示') ?>

    <?= $form->field($model, 'end')->textInput(['dt'=>'true'])->hint('如不填写，则从展示截止本月底') ?>

    <?php if ($model->type):?>
        <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
    <?php else:?>
        <?= $form->field($model, 'type')->radioList(Announce::types()) ?>
    <?php endif;?>

	<div class="form-group">
        <?=  Html::button('取 消', [
            'class' => 'btn btn-lg pull-right cancel'
        ]) ?>

        <?=  Html::submitButton('保 存', [
                'class' => 'btn btn-warning btn-lg pull-right saveAnn',
                'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> 保存中，请稍后"
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->beginBlock('auth') ?>
$(function(){
    jQuery('form#annForm').on('beforeSubmit', function (e) {
        var $form = $(this);
        var btn = $(this).find('.saveAnn').button('loading');

        $.post($form.attr('action'),$form.serialize(),function(xhr){
            if (xhr.status) {
                location.reload();
            } else {
                btn.button('reset');
                alert(xhr.info);
                //$('#modalAdd').modal('hide')
            }
        },'json');

        return false;
    })
    $('.cancel').click(function(e){
        $('#modalEdit').modal('hide')
    });
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>
