<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\ExtAsset::register($this);


$this->params['current_menu'] = 'grave/free/index';
?>

<div class="free-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bury_type')->dropDownList(\app\modules\grave\models\Free::types()) ?>

    <?= $form->field($model, 'bury_date')->textInput(['dt'=>'true']) ?>

    <?= $form->field($model, 'max_num')->textInput()->hint('最大安葬数量,为0则不限制,如果超过，则需要移动到其它批次') ?>

    <?= $form->field($model, 'stage')->textInput(['maxlength' => true])->hint('本次免费葬的一个标识，比如:201702') ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?php
        $staffs = \app\modules\user\models\User::staffs();
    ?>
    <?= $form->field($model, 'op_id')->dropDownList(\yii\helpers\ArrayHelper::map($staffs, 'id', 'username'),['prompt'=>'请选择主要联系人'])->label('主要联系人')
        ->hint('本次免费葬主要联系人,可不选') ?>


    <div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
