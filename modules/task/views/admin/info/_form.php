<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Info */
/* @var $form yii\widgets\ActiveForm */
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
    table.table > tbody > tr > td input {
        border-radius:0;
    }
    table.table > tbody > tr > td{
        border-top:1px solid #fff;
    }

    table.table > tbody > tr > td .form-group{
        margin-bottom: 0;
    }
</style>
<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>


    <table class="table">
        
        <tr>
            <th width="100px">
                标题
            </th>
            <td>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
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
        <tr>
            <th>
                消息内容 
            </th>
            <td>
                <?= $form->field($model, 'msg')->textarea(['rows' => 6])->label(false) ?>
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
