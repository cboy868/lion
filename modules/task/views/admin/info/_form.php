<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]);?>

    <?php if($model->pid):?>
        <?= $form->field($model, 'pid')->hiddenInput()->label(false) ?>
    <?php else:?>
        <?= $form->field($model, 'pid')->dropDownList(Info::getInfos(),['prompt'=>'请选择任务项目']) ?>
    <?php endif;?>

    <?= $form->field($model, 'msg_type')->checkBoxList(Info::msgType())->hint('消息提醒类型，可多选') ?>

    <?php if($model->pid):?>
    <?= $form->field($model, 'task_time')->textarea(['rows' => 6, 'id'=>'inputTagator'])
        ->hint('<span style="color:green">atonce 马上, 0当天，-1提前1天,-2提前2天以此类推,多个提醒请用逗号分隔;<br>
如果值大于0，则为延后提醒,1表示延后1天，2个示延后2天,以此类推。</span>') ?>

    <?= $form->field($model, 'msg_time')->textarea(['rows' => 6, 'id'=>'inputTagator'])
        ->hint('<span style="color:green">atonce 马上, 0任务当天，-1提前1天,-2提前2天以此类推,多个提醒请用逗号分隔;</span>') ?>

    <?php endif;?>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6, 'class'=>'ctent form-control']) ?>
    <div class="shortcut">插入参数
        <?php
        $replace = $this->context->module->params['shortcut'];
        ?>
        <?php foreach ($replace as $k => $v): ?>
            <a href="#" rel="<?=$k?>"><?=$v?></a>
        <?php endforeach ?>
    </div>
    <?= $form->field($model, 'intro')->textarea(['rows' => 6]); ?>

    <?= $form->field($model, 'user')->checkBoxList(ArrayHelper::map($users, 'id', 'username'))?>

    <?php if (isset($sels)): ?>
        <?= $form->field($model, 'default')->radioList($sels) ?>
    <?php else: ?>
        <?= $form->field($model, 'default')->radioList([]) ?>
    <?php endif ?>


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

    $('.shortcut a').click(function(e){
        e.preventDefault();
        var val = $(this).attr('rel');
        $('.ctent').insertContent(val);

    });
});



(function($) { 
$.fn.extend({ 
insertContent: function(myValue, t) { 
var $t = $(this)[0]; 
if (document.selection) { //ie 
this.focus(); 
var sel = document.selection.createRange(); 
sel.text = myValue; 
this.focus(); 
sel.moveStart('character', -l); 
var wee = sel.text.length; 
if (arguments.length == 2) { 
var l = $t.value.length; 
sel.moveEnd("character", wee + t); 
t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length); 
sel.select(); 
} 
} else if ($t.selectionStart || $t.selectionStart == '0') { 
var startPos = $t.selectionStart; 
var endPos = $t.selectionEnd; 
var scrollTop = $t.scrollTop; 
$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length); 
this.focus(); 
$t.selectionStart = startPos + myValue.length; 
$t.selectionEnd = startPos + myValue.length; 
$t.scrollTop = scrollTop; 
if (arguments.length == 2) { 
$t.setSelectionRange(startPos - t, $t.selectionEnd + t); 
this.focus(); 
} 
} 
else { 
this.value += myValue; 
this.focus(); 
} 
} 
}) 
})(jQuery); 

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['sel'], \yii\web\View::POS_END); ?>  

