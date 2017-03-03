<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\InsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ins-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?=\app\modules\grave\widgets\TombSearch::widget(['form'=>$form])?>

    <?= $form->field($model, 'guide')->label('导购') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
