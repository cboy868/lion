<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Tomb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tomb-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-lg-3" style="padding-right:0">
        <?php $form->fieldConfig = [
            'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>',
            'labelOptions' => [
                'class' => 'control-label col-sm-6'
            ]
        ];?>
            <?= $form->field($model, 'row_start')->textInput()->label('起始排/列') ?>
        </div>
        <div class="col-lg-3" style="padding-left:0">
            <?= $form->field($model, 'col_start')->textInput()->label(false) ?>
        </div>
    </div>

    <div class="row">
         <div class="col-lg-3" style="padding-right:0">
            <?= $form->field($model, 'row_end')->textInput()->label('截止排/列') ?>
        </div>
        <div class="col-lg-3" style="padding-left:0">
            <?= $form->field($model, 'col_end')->textInput()->label(false) ?>
        </div>
    </div>

    <?php $form->fieldConfig = [
            'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
            'labelOptions' => [
                'class' => 'control-label col-sm-2'
            ]
        ];?>

    <div class="col-lg-6">


         <?php 
        $graves = Grave::find()->where(['<>', 'status', Grave::STATUS_DELETE])->asArray()->all();
        $options = [];
        foreach ($graves as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }
         ?>


        <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(), ['prompt'=> '请选择墓区', 'options' => $options]) ?>

        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'hole')->textInput() ?>

        <?= $form->field($model, 'thumb')->fileInput() ?>
    </div>

    <div class="col-lg-6">
        <?= $form->field($model, 'area_total')->textInput() ?>

        <?= $form->field($model, 'area_use')->textInput() ?>

        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    </div>


    <div class="row">
        <div class="form-group col-xs-12">
            <div class="col-sm-offset-1 col-sm-3">
                <?=  Html::submitButton('生成墓位', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>
	
    
    <?php ActiveForm::end(); ?>

</div>
