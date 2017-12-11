<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

$leave_types = Yii::$app->getModule('approval')->params['leave_type'];

\app\assets\ExtAsset::register($this);
\app\assets\DateTimeAsset::register($this);
?>

<div class="approval-leave-form">
    <style>
         .nopadding > tbody > tr > td{
            padding:0;
            vertical-align:middle
        }
         .input-group{
             width:100%;
         }
    </style>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => '']
    ]);
    $form->fieldConfig['template']='{input}{hint}{error}';
    ?>

    <table class="table noborder nopadding">
        <tr>
            <td width="60">
                <label class="control-label">请假类型</label>
            </td>
            <td colspan="2">
                <?= $form->field($model, 'type')->radioList($leave_types)->label(false)?>
            </td>
        </tr>
        <tr>
            <td width="60">
                <label class="control-label">开始</label>
            </td>
            <td>
                <?= $form->field($model, 'start_day',[
                    'template'=>"<div class='input-group'><span class='input-group-addon fix-border'>日期</span>\n{input}\n{hint}\n</div>{error}"
                ])->textInput(['dt'=>'true']) ?>
            </td>
            <td>
                <?= $form->field($model, 'start_time',[
                        'template'=>"<div class='input-group'><span class='input-group-addon fix-border'>时间</span>\n{input}\n{hint}\n</div>{error}"
                ])->textInput(['dttime'=>'true']) ?>
            </td>
        </tr>
        <tr>
            <td width="60">
                <label class="control-label">结束</label>
            </td>
            <td>
                <?= $form->field($model, 'end_day',[
                    'template'=>"<div class='input-group'><span class='input-group-addon fix-border'>日期</span>\n{input}\n{hint}\n</div>{error}"
                ])->textInput(['dt'=>'true']) ?>
            </td>
            <td>
                <?= $form->field($model, 'end_time',[
                    'template'=>"<div class='input-group'><span class='input-group-addon fix-border'>时间</span>\n{input}\n{hint}\n</div>{error}"
                ])->textInput(['dttime'=>'true']) ?>
            </td>
        </tr>
        <tr>
            <td width="60">
                <label class="control-label">总时长</label>
            </td>
            <td colspan="2">
                <?= $form->field($model, 'hours',[
                    'template'=>"<div class='input-group'>\n{input}<span class='input-group-addon'>小时</span>\n{hint}\n</div>{error}"
                ])->textInput() ?>
            </td>
        </tr>
        <tr>
            <td width="60">
                <label class="control-label">请假事由</label>
            </td>
            <td colspan="2">
                <?= $form->field($model, 'desc')->textarea() ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary pull-right']) ?>
            </td>
        </tr>
    </table>

    <?php ActiveForm::end(); ?>
</div>

<?php $this->beginBlock('foo') ?>
$(function(){
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

