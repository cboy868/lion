<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\news\models\Category;
use yii\helpers\Url;
use app\assets\PluploadAssets;
PluploadAssets::register($this);
use app\core\models\Attachment;
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?php 
        $category = Category::find()->where(['status'=>Category::STATUS_NORMAL])->asArray()->all();

        $options = [];
        foreach ($category as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }
    ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList([0=>'默认分类'] + Category::selTree(['status'=>Category::STATUS_NORMAL]),['class'=>'new form-control', 'options' => $options]) ?>

            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <div class="form-group field-newstextform-thumb">
            <label></label>
                <a href="javascript:;" id="filePicker-thumb" 
                    class="thumbnail filelist-thumb filePicker" 
                    style="width:150px;" 
                    data-url="<?=Url::toRoute(["pl-upload"])?>" 
                    data-res_name="news"
                    data-use="original">
                      <img src="<?=Attachment::getById($model->thumb, '150x150', '/static/images/cover.png')?>"  style="width:150px;height:150px;">
                      <?= $form->field($model, "thumb")->hiddenInput(['class'=>'news-thumb', 'value'=>$model->thumb])->label(false) ?>
                </a>
                <div class="help-block"></div>
            </div>
        </div>
    </div>


    <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
        'option' =>['res_name'=>'news_text', 'use'=>'ue'], 
        'value'=>$model->body,
        ]);?>

	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
