<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\MixCate;
/* @var $this yii\web\View */
/* @var $model modules\foods\models\MixSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mix-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'mix_cate')->dropDownList(MixCate::selTree(), ['prompt'=> '分类选择'])->label(false) ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
