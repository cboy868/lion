<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\cms\models\Category;
use app\modules\cms\models\Album;
use app\core\widgets\Webup\Webup;
use app\core\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Album */
/* @var $form yii\widgets\ActiveForm */
$class = '\\'.get_class($model);
?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $category = Category::find()->asArray()->all();
        $options = [];
        foreach ($category as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }
    ?>

    <?= $form->field($model, 'category_id')->dropDownList([0=>'默认分类'] +Category::selTree(['res_name'=>'album' . Yii::$app->request->get('mod')]),['class'=>'new form-control', 'options' => $options]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'class'=>'new form-control']) ?>

    <?= $form->field($model, 'intro')->textArea(['class'=>'form-control new']) ?>


    <?php foreach ($attach as $k => $v): ?>
        <?php if ($v['html'] == 'input'): ?>
            <?= $form->field($model, $v['name'])->textInput(['value'=>isset($model)?$model->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'textarea'): ?>
            <?= $form->field($model, $v['name'])->textarea(['rows' => 6, 'value'=>isset($model)?$model->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'fulltext'): ?>
            <?= $form->field($model,$v['name'])->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'album', 'use'=>'ue'], 'value'=>isset($model)?$model->$v['name']:''])->label($v['title']); ?>
        <?php endif ?>
    <?php endforeach ?>
   

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
