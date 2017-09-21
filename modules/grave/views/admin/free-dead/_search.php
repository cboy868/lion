<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\search\FreeDead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="free-dead-search">

    <?php $form = ActiveForm::searchBegin(); ?>
    <?php
    $form->action = Url::toRoute(['index', 'free_id'=>Yii::$app->request->get('free_id')]);
    ?>

    <?= $form->field($model, 'contact_user') ?>

    <?= $form->field($model, 'dead') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index',
            'free_id'=>Yii::$app->request->get('free_id')]),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
