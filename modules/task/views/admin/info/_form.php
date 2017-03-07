<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;

use app\core\widgets\ActiveForm;
use app\modules\user\models\User;
use app\modules\task\models\Info;

$users = User::find()->where(['status' => User::STATUS_ACTIVE, 'is_staff'=>User::STAFF_YES])->asArray()->all();

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
                标题
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
                提醒方式
            </th>
            <td>
                <?= $form->field($model, 'msg_type')->checkBoxList(Info::msgType())->label(false)->hint('消息提醒类型，可多选') ?>
            </td>
        </tr>

        <tr>
            <th>
                提醒时间
            </th>
            <td>
                <?= $form->field($model, 'msg_time')->textarea(['rows' => 6, 'id'=>'inputTagator'])->label(false)->hint('1马上, 0当天，-1提前1天,-2提前2天以此类推,多个提醒请用逗号分隔') ?>
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

        <tr>
            <th>
                任务接收人
            </th>
            <td>
                <?= $form->field($model, 'user')->checkBoxList(ArrayHelper::map($users, 'id', 'username'))->label(false) ?>
            </td>
        </tr>
        <tr>
            <th>
                任务处理人
            </th>
            <td>
                <?= $form->field($model, 'default')->radioList($sels)->label(false) ?>
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
<?php $this->beginBlock('sel') ?>  
$(function () {
    var defaultBox = $('#infoform-default');

    $('#infoform-user input').click(function(e){
        var that = this;        
        var userId = $(this).val();
        //alert(userId);
        if ( $(this).is(':checked') ) {
            var userId = $(this).val();
            var username = $(this).closest('label').text();

            var html = '<label><input type="radio" name="InfoForm[default]" value="'+userId+'"> ' + username + '</label>';

            defaultBox.append(html);
        } else {
            defaultBox.find('input[value='+userId+']').closest('label').remove();
        }
        
    });
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['sel'], \yii\web\View::POS_END); ?>  

