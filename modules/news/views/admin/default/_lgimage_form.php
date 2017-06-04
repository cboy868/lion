<?php

use app\core\helpers\Html;

use app\modules\news\models\Category;
use yii\helpers\Url;
use app\core\models\Attachment;

?>

<?= $form->field($lg_model, "[$lg_model->language]title")->textInput(['maxlength' => true]) ?>

<?= $form->field($lg_model, "[$lg_model->language]subtitle")->textInput(['maxlength' => true]) ?>

<?= $form->field($lg_model, "[$lg_model->language]summary")->textarea(['rows' => 6]) ?>

