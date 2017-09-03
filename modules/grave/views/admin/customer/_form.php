<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['current_menu'] = 'grave/customer/index';
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'is_vip')->radioList([0=>'否', 1=>'是']) ?>

    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'second_ct')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'second_mobile')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'units')->textInput(['maxlength' => true])->label('客户单位') ?>

        <?= $form->field($model, 'relation')->textInput(['maxlength' => true])->label('与使用人关系') ?>

    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'vip_desc')->textarea(['rows' => 6]) ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>







    
    <?php ActiveForm::end(); ?>

</div>
