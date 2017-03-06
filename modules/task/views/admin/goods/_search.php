<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Info;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\search\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <?php $form = ActiveForm::searchBegin(); ?>


    <?= $form->field($model, 'info_id')->dropDownList(ArrayHelper::map(Info::find()->where(['status'=>Info::STATUS_NORMAL])->all(), 'id', 'name')) ?>

    <?php // echo $form->field($model, 'msg') ?>

    <?php // echo $form->field($model, 'msg_time') ?>

    <?php // echo $form->field($model, 'trigger') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
