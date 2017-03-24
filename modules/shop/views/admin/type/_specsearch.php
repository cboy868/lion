<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\search\Attr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attr-search">

    <?php $form = ActiveForm::searchBegin(); ?>
    <?php $form->action=Url::toRoute(['spec', 'id'=>Yii::$app->request->get('id')]) ?>

     <?= $form->field($model, 'name')->label('规格名')?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>