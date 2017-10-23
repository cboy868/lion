<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

?>
<div class="approval-search">
    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'tit')->label('审批标题') ?>
    <input type="hidden" name="pro" value="<?=Yii::$app->request->get('pro')?>">
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
