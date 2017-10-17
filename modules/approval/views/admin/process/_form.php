<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
    {
        padding:3px;
    }
</style>
<div class="approval-process-form">

    <?=\app\core\widgets\Alert::widget()?>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList($types) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <div class="form-group field-approvalprocess-can required">
        <label class="control-label" for="approvalprocess-can">可发起此审批人员</label>
        <?=Select2::widget([
            'name' => 'ApprovalProcess[can_user]',
            'data' => $staffs,
            'value' => isset($can_user) ? $can_user : '',
            'options' => [
                'placeholder' => '选择可发起此审批的人员',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <div class="hint-block">不选择，则默认为所有人员可发此审批</div>
    </div>

    <hr>
    <h4>审批步骤</h4>
    <table class="table noborder">
        <tr>
            <th>#</th>
            <th>审批步骤名</th>
            <th>审批人选择</th>
        </tr>
        <tr>
            <td width="20">1</td>
            <td>
                <?= $form->field($step, '[1]step')->hiddenInput(['value'=>1])->label(false) ?>
                <?= $form->field($step, '[1]step_name')->textInput([
                    'value' => isset($stepval[1]['step_name']) ? $stepval[1]['step_name'] : ''
                ])->label(false) ?>
            </td>
            <td>
                <?=Select2::widget([
                    'name' => 'ApprovalProcessStep[1][approval_user]',
                    'data' => $staffs,
                    'value' => isset($stepval[1]['approval_user']) ? explode(',',$stepval[1]['approval_user']) : '',
                    'options' => [
                        'placeholder' => '选择可发起此审批的人员',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </td>
        </tr>
        <tr>
            <td width="20">2</td>
            <td width="200">
                <?= $form->field($step, '[2]step')->hiddenInput(['value'=>2])->label(false) ?>
                <?= $form->field($step, '[2]step_name')->textInput([
                        'value' => isset($stepval[2]['step_name']) ? $stepval[2]['step_name'] : ''
                ])->label(false) ?>
            </td>
            <td>
                <?=Select2::widget([
                    'name' => 'ApprovalProcessStep[2][approval_user]',
                    'data' => $staffs,
                    'value' => isset($stepval[2]['approval_user']) ? explode(',',$stepval[2]['approval_user']) : '',
                    'options' => [
                        'placeholder' => '选择可发起此审批的人员',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </td>
        </tr>
        <tr>
            <td width="20">3</td>
            <td width="200">
                <?= $form->field($step, '[3]step')->hiddenInput(['value'=>3])->label(false) ?>
                <?= $form->field($step, '[3]step_name')->textInput([
                    'value' => isset($stepval[3]['step_name']) ? $stepval[3]['step_name'] : ''
                ])->label(false) ?>
            </td>
            <td>
                <?=Select2::widget([
                    'name' => 'ApprovalProcessStep[3][approval_user]',
                    'data' => $staffs,
                    'value' => isset($stepval[3]['approval_user']) ? explode(',',$stepval[3]['approval_user']) : '',
                    'options' => [
                        'placeholder' => '选择可发起此审批的人员',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </td>
        </tr>
    </table>



	<div class="form-group">
        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
