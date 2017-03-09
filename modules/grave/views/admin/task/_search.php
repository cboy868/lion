<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Info;

\app\assets\ExtAsset::register($this);
?>

<div class="task-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'cate_id')->dropDownList(ArrayHelper::map(Info::find()->where(['status'=>Info::STATUS_NORMAL])->all(), 'id', 'name'), ['prompt'=>'--任务分类 不限--']) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'pre_finish')->textInput(['dt'=>'true']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
