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
			<div class="col-xs-12 memorial-create">

                <?php $form = ActiveForm::begin(); ?>
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

                <?= $form->field($model, 'dead_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'birth')->textInput(['maxlength' => true, 'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true','default'=>'1955-'.date('m-d'),]) ?>

                <?= $form->field($model, 'fete')->textInput(['maxlength' => true,'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true'])->label('去逝日期') ?>

                <?= $form->field($model, 'gender')->radioList([1=>'男',2=>'女']) ?>

                <?= $form->field($model, 'age')->textInput() ?>

                <?= $form->field($model, 'second_name')->textInput()->label('别名') ?>

                <?= $form->field($model, 'dead_title')->textInput() ?>

                <?= $form->field($model, 'birth_place')->textarea(['rows'=>5]) ?>

                <div class="xb12 xl12">
                    <div class="form-group">
                        <div class="x1-move x4">
                            <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('tree') ?>
$(function(){
    LN.dtInit();
    LN.plupload();
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

