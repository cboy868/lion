<?php
use app\modules\mess\models\MessMenu;
use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$all = MessMenu::find()->where(['<>', 'status', MessMenu::STATUS_DEL])->all();
$sel = ArrayHelper::map($all, 'id', 'name');
$price = json_encode(ArrayHelper::map($all, 'id', 'default_price'));

?>
<script type="text/javascript">
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
</script>

<div class="mess-day-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day_time')->textInput(['readonly'=>'true'])->label(false) ?>

    <?= $form->field($model, 'mess_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

    <div class="form-group field-messdaymenu-real_price required">
        <label class="control-label" for="messdaymenu-real_price">选择菜单</label>
        <?=Select2::widget([
            'name' => 'MessDayMenu[menu_id]',
            'data' => $sel,
            'options' => [
                'placeholder' => '选择菜单',
                'class' => 'selmenu'
            ]
        ]);
        ?>

        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'real_price')->textInput(['maxlength' => true,'class'=>'form-control real_price']) ?>

	<div class="form-group">
        <div class="pull-right col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('img') ?>
$(function(){
    $('.selmenu').change(function(e){
        var price = JSON.parse('<?=$price?>');
        var id = $(this).val();
        try {
            var price = price[id];
        } catch (err) {
            var price = 0;
        }
        $('.real_price').val(price);
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
