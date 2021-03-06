<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
$this->params['current_menu'] = 'cms/subject/index';
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cate')->dropDownList(\app\modules\cms\models\Subject::cates()) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true])
        ->hint('专题的连接，如果是上传的文件，则无需填写。')
    ?>

    <?= $form->field($model, 'cover')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true])->hint('如果是上传的专题，请填写文件名到此处') ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
