<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\news\models\Category;
/* @var $this yii\web\View */
/* @var $model app\modules\news\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList(Category::pids(), ['prompt'=>'请选择顶级分类']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('分类名<font color="red">(*)</font>') ?>

    <?= $form->field($model, 'covert')->fileInput() ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true])->label('SEO标题')->hint('seo设置有利于搜索引擎收录') ?>

    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true])->label('SEO关键词') ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6])->label('SEO描述') ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
