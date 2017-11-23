<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
\app\assets\ExtAsset::register($this);

$types = Yii::$app->getModule('mess')->params['menu_types'];

$users = \app\modules\user\models\User::staffs();
$users = \yii\helpers\ArrayHelper::map($users, 'id', 'username');

?>

<div class="mess-reception-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'reception_name')->widget(Select2::classname(), [
        'data' => $users,
        'options' => [
            'placeholder' => '选择接待人员 ...',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('接待人员');?>



    <?= $form->field($model, 'reception_customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reception_number')->textInput() ?>

    <?= $form->field($model, 'day_time')->textInput(['dt'=>'true']) ?>

	<div class="form-group pull-right">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('img') ?>
$(function(){
$.fn.modal.Constructor.prototype.enforceFocus = function () { };
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
