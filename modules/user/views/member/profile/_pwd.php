<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>

<style type="text/css">
    .form-x .form-group .label {
    width: 50%;
    text-align: left;
}
</style>

<?php $form = ActiveForm::memberBegin(); ?>
<?php 
    $form->fieldConfig['template'] = '{label}{input}{hint}{error}';
 ?>

    <div class="xb6 xl8">
        <?= $form->field($model, 'oldpassword')->passwordInput(['maxlength' => true])->label('Original password'); ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('New password') ?>
        <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => true])->label('Enter new password again') ?>
    </div>
    

    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x4">
                <?=  Html::submitButton('Save', ['class' => 'button button-block bg-sub']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>




