<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\cms\models\Category;

/* @var $this yii\web\View */
/* @var $model shop\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $cates = Category::selTree(['mid'=>Yii::$app->request->get('mid')]);
    ?>

    <?= $form->field($model, 'pid')->dropDownList($cates, ['prompt'=>'请选择父级分类']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'covert')->fileInput() ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'seo_title')->textInput() ?>

    <?= $form->field($model, 'seo_keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
