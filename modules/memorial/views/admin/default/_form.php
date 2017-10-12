<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\helpers\Url;
\app\assets\PluploadAssets::register($this);


$this->params['current_menu'] = 'memorial/default/index';
?>

<div class="memorial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-dead-dead_name required">
        <label class="control-label" for="dead-dead_name">封面</label>

        <div style="">
            <a href="javascript:;" id="filePicker-k"
               class=" filelist-k filePicker"
               style="max-width:380px;max-height:280px;"
               rid="<?=$model->id?>"
               data-url="<?=Url::toRoute(["pl-upload"])?>"
               data-res_name="dead"
               data-use="original">
                <img src="<?=Attachment::getById($model->thumb, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                <?= $form->field($model, "thumb")->hiddenInput(['class'=>'avatar', 'value'=>$model->thumb])->label(false) ?>
            </a>
        </div>

        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'privacy')->dropDownList(\app\modules\memorial\models\Memorial::privacys()) ?>

    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x1-move x4">
                <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
