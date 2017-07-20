<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
\app\assets\DateTimeAsset::register($this);
\app\assets\ExtAsset::register($this);
?>

<div class="dead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'dead_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'dead_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birth')->textInput(['dt'=>"true"]) ?>

        <?= $form->field($model, 'fete')->textInput() ?>

        <?= $form->field($model, 'age')->textInput() ?>

    </div>

    <div class="col-md-6">


        <?= $form->field($model, 'bone_type')->dropDownList(\app\modules\grave\models\Dead::getBoneTypes()) ?>

        <?= $form->field($model, 'bone_box')->dropDownList(\app\modules\grave\models\Dead::getBoneBoxs()) ?>

        <?= $form->field($model, 'pre_bury')->textInput(['dttime'=>'true']) ?>

        <?= $form->field($model, 'bury')->textInput(['dttime'=>'true']) ?>

        <?= $form->field($model, 'gender')->radioList([1=>'男',2=>'女']) ?>

        <?= $form->field($model, 'is_alive')->radioList([0=>'否',1=>'是']) ?>

        <?= $form->field($model, 'is_adult')->radioList([0=>'否',1=>'是'])->label('是否已成年') ?>

        <?= $form->field($model, 'is_ins')->radioList([0=>'否',1=>'是'])->label('是否立碑') ?>
    </div>

    <div class="col-md-12">

        <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
    </div>


	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
