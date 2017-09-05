<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\helpers\Url;

\app\assets\TagAsset::register($this);
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>


        <div class="col-md-4">
            <div class="form-group field-dead-dead_avatar">
                <label class="control-label" for="dead-dead_avatar">博客封面</label>

                <div style="">
                    <a href="javascript:;" id="filePicker-k"
                       class=" filelist-k filePicker"
                       style="max-width:380px;max-height:280px;"
                       rid="0"
                       data-url="<?=Url::toRoute(["pl-upload"])?>"
                       data-res_name="dead"
                       data-use="original">
                        <img src="<?=Attachment::getById($model->thumb, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                        <?= $form->field($model, "thumb")->hiddenInput(['class'=>'thumb'])->label(false) ?>
                    </a>
                </div>

                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-md-8">
            <?= $form->field($model, 'memorial_id')->dropDownList($memorials, ['prompt'=>'发布到纪念馆'])->hint('博客可发布到相应纪念馆') ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
                'option' =>['res_name'=>'blog', 'use'=>'ue'],
                'value'=>$model->body,
                'jsOptions' => [
                    'initialFrameHeight'=>200,
                    'toolbars' => [
                        [
                            'source', 'undo', 'redo', '|',
                            'fontsize',
                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                            'forecolor', 'backcolor', '|',
                            'lineheight', 'simpleupload','|',
                            'indent', '|'
                        ],
                    ]
                ]
            ])->label('内容');
            ?>
            <?= $form->field($model, 'tags')->textInput(['id'=>'inputTagator', 'value'=>$tags])->hint('多关键词，请用半角逗号分隔') ?>
            <?= $form->field($model, 'privacy')->radioList(\app\modules\blog\models\Blog::privacys())->label('是否公开') ?>
            <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('tree') ?>
$(function(){
    LN.plupload();
    tag();
})
function tag()
{
    if ($('#inputTagator').data('tagator') === undefined) {
        $('#inputTagator').tagator({
        autocomplete: []
        });
        $('#activate_tagator').val('销毁 tagator');
    } else {
        $('#inputTagator').tagator('destroy');
        $('#activate_tagator').val('激活 tagator');
    }
}
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

