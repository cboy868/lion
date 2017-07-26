<?php

use app\core\helpers\Html;

use app\core\widgets\ActiveForm;
use app\modules\task\models\Info;

?>

<style type="text/css">
    table.table > tbody > tr > th{
        background: #337ab7;
        vertical-align: middle;

    }
    table.table > tbody > tr > td, table.table > tbody > tr > th{
        padding:0;
    }
    .help-block{
        margin-top: 0;
        margin-bottom: 0;
    }
    table.table > tbody > tr > td #infoform-user input {
        border-radius:0;
    }
    table.table > tbody > tr > td{
        border-top:1px solid #fff;
    }

    table.table > tbody > tr > td .form-group{
        margin-bottom: 0;
    }
    #infoform-user label, #infoform-default label{
        width:100px;
    }
</style>
<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table">

        <tr>
            <th width="100px">
                项目名
            </th>
            <td>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
            </td>
        </tr>

        <tr>
            <th>
                触发方式
            </th>
            <td>
                <?= $form->field($model, 'trigger')->radioList(Info::trig())->label(false) ?>
            </td>
        </tr>

        <tr>
            <th>
                描述
            </th>
            <td>
                <?= $form->field($model, 'intro')->textarea(['rows' => 6])->label(false) ?>
            </td>
        </tr>

    </table>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
