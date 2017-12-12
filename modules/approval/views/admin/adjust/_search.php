<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\approval\models\ApprovalLeave;
use kartik\select2\Select2;
$types = Yii::$app->getModule('approval')->params['overtime_type'];
$staffs = \app\modules\user\models\User::staffs();
$staffs = \yii\helpers\ArrayHelper::map($staffs, 'id', 'username');
?>

<div class="approval-leave-search">

    <?php $form = ActiveForm::searchBegin();?>
    <input type="hidden"  name="year" value="<?=$params['year']?>">

    <input type="hidden"  name="month" value="<?=$params['month']?>">

    <div class="form-group field-searchapprovalleave-created_by">
        <?=Select2::widget([
            'name' => 'SearchApprovalLeave[created_by]',
            'data' => $staffs,
            'options' => [
                'placeholder' => '加班人',
                'class' => 'form-control'
            ]
        ]);
        ?>
    </div>

    <?= $form->field($model, 'type')->dropDownList($types); ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
