<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\InsCfgRel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ins-cfg-rel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grave_id')->textInput() ?>

    <?= $form->field($model, 'cfg_id')->textInput() ?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
