<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

use app\core\models\Attachment;
\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '添加纪念馆';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">

                <?php $form = ActiveForm::begin(); ?>

                <div class="col-md-12">

                    <div class="form-group field-dead-dead_avatar">
                        <label class="control-label" for="dead-dead_avatar">头像</label>

                        <div style="">
                            <a href="javascript:;" id="filePicker-k"
                               class=" filelist-k filePicker"
                               style="max-width:380px;max-height:280px;"
                               rid="0"
                               data-url="<?=Url::toRoute(["pl-upload"])?>"
                               data-res_name="dead"
                               data-use="original">
                                <img src="<?=Attachment::getById($model->avatar, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                                <?= $form->field($model, "avatar")->hiddenInput(['class'=>'avatar'])->label(false) ?>
                            </a>
                        </div>

                        <div class="help-block"></div>
                    </div>
                </div>

            <div class="col-md-6">
                <?= $form->field($model, 'dead_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'second_name')->textInput()->label('别名') ?>

                <?php
                if ($model->dead_title && !in_array($model->dead_title, $dead_titles)) {
                    $dead_titles[$model->dead_title] = $model->dead_title;
                }
                ?>
                <?= $form->field($model, "dead_title")->dropDownList($dead_titles,[
                    'class'=>'selize-rel'
                ])->hint('如无选项 请直接输入'); ?>

                <?= $form->field($model, 'gender')->radioList([1=>'男',2=>'女']) ?>

            </div>

            <div class="col-md-6">

                <?= $form->field($model, 'birth')->textInput(['maxlength' => true, 'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true','default'=>'1955-'.date('m-d'),]) ?>

                <?= $form->field($model, 'fete')->textInput(['maxlength' => true,'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true'])->label('去逝日期') ?>

                <?= $form->field($model, 'age')->textInput() ?>
                <?= $form->field($model, 'birth_place')->textarea(['rows'=>3]) ?>

            </div>

            <div class="col-md-12">

            </div>

            <div class="col-md-12">
                <?= $form->field($model,'desc')->widget('app\core\widgets\Ueditor\Ueditor',[
                    'option' =>['res_name'=>'dead', 'use'=>'ue'],
                    'value'=>$model->desc,
                    'jsOptions' => [
                        'initialFrameHeight'=>150,
                        'toolbars' => [
                            [
                                'fullscreen', 'source', 'undo', 'redo', '|',
                                'fontsize',
                                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                                'forecolor', 'backcolor', '|',
                                'lineheight', 'simpleupload', '|',
                                'indent', '|'
                            ],
                        ]
                    ]
                ])->label('生平');
                ?>
            </div>

            <div class="col-md-12">
                    <div class="form-group">
                        <div class="x1-move x4">
                            <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

				<div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('tree') ?>
$(function(){
    LN.dtInit();
    LN.plupload();

    $('.selize-rel').each(function(index, item){
        var $this = $(item);
        if ( !$this.data('select-init') ) {
            $this.selectize({
                create: true
            });
        }
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

