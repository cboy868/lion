<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\grave\models\Free;
$this->params['current_menu'] = 'grave/free/index';
?>

<div class="free-dead-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contact_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dead')->textInput(['maxlength' => true])->hint('多位逝者请用逗号隔开,如张三,李四') ?>

    <?= $form->field($model, 'relation')->textInput(['maxlength' => true])->label('联系人与逝者关系')
        ->hint('多位请按逝者顺序一致用逗号隔开，如父亲,母亲') ?>

    <?php if ($free_id=Yii::$app->request->get('free_id')):?>
        <?= $form->field($model, 'free_id')->textInput(['value'=>$free_id]) ?>
    <?php else:?>
        <?php
        $frees = Free::sel();
        $frees = [0=>'请选择期次']+$frees;
        ?>
        <?= $form->field($model, 'free_id')->dropDownList($frees)->hint('此处不选择，则为待定') ?>
    <?php endif;?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
