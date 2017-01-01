<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\sys\models\Set;
/* @var $this yii\web\View */
/* @var $model app\models\SetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="set-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'sname') ?>

    <?php echo $form->field($model, 'smodule')->dropDownList(Set::getModule(),['prompt'=>'不限']) ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['list']),['class'=>'btn btn-danger btn-sm']);?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
