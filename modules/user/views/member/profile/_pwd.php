<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>



<?php $form = ActiveForm::memberBegin(); ?>


    <div class="xb6 xl12">
        <?= $form->field($model, 'oldpassword')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'repassword')->textInput(['maxlength' => true]) ?>
    </div>
    

    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x4-move x4">
                <?=  Html::submitButton('保 存', ['class' => 'button button-block bg-sub']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>







