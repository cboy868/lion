<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
        'option' =>['res_name'=>'blog', 'use'=>'ue'],
        'value'=>trim($model->body),
        'jsOptions' => [
            'initialFrameHeight'=>400,
            'scaleEnabled'=>true,
            'toolbars' => [
                [
                    'source', 'undo', 'redo', '|',
                    'fontsize',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                    'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', '|',
                    'lineheight', 'simpleupload', '|',
                    'indent', '|'
                ],
            ]
        ]
    ])->label('内容');
    ?>

    <div class="form-group row">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
