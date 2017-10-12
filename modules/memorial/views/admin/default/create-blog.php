<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\blog\models\Blog;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">

                <?php $form = ActiveForm::begin(); ?>

            <?=$form->field($model,'title')?>

            <?= $form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
                'option' =>['res_name'=>'blog', 'use'=>'ue'],
                'value'=>$model->body,
                'jsOptions' => [
                    'initialFrameHeight'=>400,
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

            <?=$form->field($model,'privacy')->radioList(\app\modules\blog\models\Blog::privacys())?>
            <?=$form->field($model,'res')->hiddenInput()->label(false)?>

            <div class="form-group">
                <div class="x1-move x4">
                    <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('tree') ?>
$(function(){
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

