
<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'description') ?>
    <?= $form->field($model, 'real_title') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success create-menu hidden' : 'btn btn-primary update-menu hidden']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
