<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;

$staffs = User::staffs();
$staffs = ArrayHelper::map($staffs, 'id', 'username');
?>

<div class="agency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mobile')->hiddenInput()->label(false) ?>

    <table class="table table-bordered">
        <tr>
            <td colspan="4">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('办事处名称(*)') ?>
            </td>
        </tr>
        <tr>

            <td>
                <?= $form->field($model, 'category')
                    ->dropDownList($this->context->module->categorys(), ['prompt'=>'请选择办事处'])
                ->label('办事处隶属(*)')?>
            </td>
            <td>
                <?= $form->field($model, 'kefu_qq')->textInput(['maxlength' => true]) ?>
            </td>
            <td>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </td>

            <td>
                <?= $form->field($model, 'is_real')->radioList(['0'=>'否', '1'=>'是']) ?>
            </td>

        </tr>
        <tr>
            <td colspan="2">
                <div class="form-group field-approvalprocess-can required">
                    <label class="control-label" for="approvalprocess-can">此办事处负责人</label>
                    <?=Select2::widget([
                        'name' => 'Agency[leader]',
                        'data' => $staffs,
                        'value' => $model->leader,
                        'options' => [
                            'placeholder' => '选择此办事处负责人',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </td>
            <td colspan="2">
                <div class="form-group field-approvalprocess-can required">
                    <label class="control-label" for="approvalprocess-can">此办事处接待员</label>
                    <?=Select2::widget([
                        'name' => 'Agency[guide]',
                        'data' => $staffs,
                        'value' => $model->guide,
                        'options' => [
                            'placeholder' => '选择此办事处接待员',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?= $form->field($model, 'addr')->textarea(['rows' => 6])->label('详细地址') ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>
            </td>
        </tr>
    </table>

    <div class="form-group">
        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
        <?=  Html::button('取 消', ['class' => 'btn btn-default btn-lg pull-right',
            'data-dismiss'=>"modal", 'aria-hidden'=>"true"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
