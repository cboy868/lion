<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Info;

use app\assets\ExtAsset;

ExtAsset::register($this);

?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cate_id')->dropDownList(ArrayHelper::map(Info::find()->where(['status'=>Info::STATUS_NORMAL])->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pre_finish')->textInput(['dt'=>'true', "style"=>'width:50%'])->label('完成时间'); ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('tag') ?>

$(function () {
LN.dtInit();
});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tag'], \yii\web\View::POS_END); ?>


