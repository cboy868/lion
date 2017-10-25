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

    <?= $form->field($model, 'cate_id')->dropDownList(
            ArrayHelper::map(Info::find()->where(['status'=>Info::STATUS_NORMAL])->all(), 'id', 'name'),
        ['prompt'=>'不限']
    ) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'start')->textInput(['dt'=>'true','dt-month'=>'true'])->label('任务时间: ') ?> -
    <?= $form->field($model, 'end')->textInput(['dt'=>'true','dt-month'=>'true'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm',
            'name'=>"excel", 'value'=>0]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i>  导出excel',['class'=>'btn btn-info btn-sm',
            'name'=>'excel', 'value'=>1]);?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
