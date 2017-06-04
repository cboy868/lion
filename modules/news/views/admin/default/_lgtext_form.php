<?php

use app\core\helpers\Html;

use app\modules\news\models\Category;
use yii\helpers\Url;
use app\core\models\Attachment;

?>

<?= $form->field($lg_model, "[$lg_model->language]title")->textInput(['maxlength' => true]) ?>

<?= $form->field($lg_model, "[$lg_model->language]subtitle")->textInput(['maxlength' => true]) ?>

<?= $form->field($lg_model, "[$lg_model->language]summary")->textarea(['rows' => 6]) ?>

<?= $form->field($lg_model,"[$lg_model->language]body")->widget('app\core\widgets\Ueditor\Ueditor',[
    'option' =>['res_name'=>'news_text', 'use'=>'ue'],
    'value'=>$lg_model->body,
    ]);?>


