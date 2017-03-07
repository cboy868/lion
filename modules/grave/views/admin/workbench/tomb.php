<?php 
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\core\helpers\Html;
use app\core\helpers\Url;

use kartik\select2\Select2;

?>

<style type="text/css">
	.form-inline .form-group, .navbar-form .form-group{
		margin-bottom: 10px;
	}
</style>

<div class="tomb-search">

    <?php $form = ActiveForm::searchBegin();?>




    <?php


echo $form->field($model, 'grave_id')->widget(Select2::classname(), [
    'data' => Grave::selTree(['is_leaf'=>1]),
    // 'language' => 'zh',
    'options' => ['placeholder' => '--选择墓区--'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

    ?>


    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow']) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol']) ?>

    <div class="form-group">
    	<button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 预定</button>
    	<button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 办理业务</button>
        <button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 续费</button>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>