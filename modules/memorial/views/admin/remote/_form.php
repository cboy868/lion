<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;


$this->params['current_menu'] = 'memorial/remote/index';

?>

<div class="remote-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'start')->textInput() ?>

    <?= $form->field($model, 'end')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
