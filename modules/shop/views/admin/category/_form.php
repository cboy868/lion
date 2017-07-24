<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\Category;
use app\modules\shop\models\Type;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList(Category::selTree(),['prompt'=>'顶级']) ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'title')) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'is_show')->radioList([0=>'不显示', 1=>'显示'])->label('前台显示') ?>

    <?= $form->field($model, 'sort')->textInput()->label('排序')->hint('数字越大越靠前') ?>

    <?= $form->field($model, 'body')->textArea(['rows'=>6])->label('描述') ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
