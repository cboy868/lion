<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use kartik\select2\Select2;

$users = \app\modules\user\models\User::staffs();
$users = \yii\helpers\ArrayHelper::map($users, 'id', 'username');
?>

<div class="mess-reception-search">

    <?php $form = ActiveForm::searchBegin(); ?>
    <style>
        .select2-container--krajee{
            display: inline-block;
        }
    </style>
    <?= $form->field($model, 'reception_name')->widget(Select2::classname(), [
        'data' => $users,
        'options' => [
            'placeholder' => '不限',
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'width'=>'200px'
        ],
    ])->label('接待人员');?>

    <?= $form->field($model, 'reception_customer') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
