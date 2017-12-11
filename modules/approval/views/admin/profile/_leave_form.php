<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

$leave_types = Yii::$app->getModule('approval')->params['leave_type'];

\app\assets\ExtAsset::register($this);
\app\assets\DateTimeAsset::register($this);
?>

<div class="approval-leave-form">
    <style>
         .nopadding > tbody > tr > td{
            //padding:0;
            vertical-align:middle
        }
         .input-group{
             width:100%;
         }
        .error{
            color: red;
            display: none;
        }
    </style>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => '']
    ]);
    ?>

    <?= $form->field($model, 'type')->radioList($leave_types)->label('请假类型(<font color="red">*</font>)')?>
    <?= $form->field($model, 'start')->textInput(['dttime'=>'true','step'=>'30','id'=>'start', 'defaultTime'=>'09:00'])
        ->label('开始(<font color="red">*</font>)') ?>
    <?= $form->field($model, 'end')->textInput(['dttime'=>'true','step'=>'30','id'=>'end','defaultTime'=>'18:00'])
        ->label('结束(<font color="red">*</font>)') ?>

    <?= $form->field($model, 'hours',[
        'template'=>"{label}<div class='input-group'>{input}<span class='input-group-addon'>小时</span>\n{hint}\n</div>{error}"
    ])->textInput(['id'=>'hours'])->label('总时长(<font color="red">*</font>)') ?>


    <?= $form->field($model, 'desc')->textarea() ?>
    <span class="error">不支持跨年或跨月请假</span>
    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary pull-right btn-leave']) ?>

    <?php ActiveForm::end(); ?>
</div>

<?php $this->beginBlock('foo') ?>
$(function(){

    $('#start, #end').change(function(){
        var end    = $('#end').val();
        var start  = $('#start').val();
        if(!end || !start) return false;


        if ((new Date(start).format("yyyy-MM")) !== (new Date(end).format("yyyy-MM"))) {
            $('.error').show();
            return false;
        } else {
            $('.error').hide();
        }

        start = start.replace(/-/g, '/');
        end   = end.replace(/-/g, '/');

        var hours = 0;
        var beginTime = Date.parse(new Date(start));
        var endTime   = Date.parse(new Date(end));
        if(beginTime >= endTime) return false;

        var worktime = {
            signIn:'09:00',
            signOut:'18:00',
            totalHours : 8
        };


        var signInTime = Date.parse(new Date(end).format("yyyy-MM-dd") + ' ' + worktime.signIn);
        var signOutTime = Date.parse(new Date(start).format("yyyy-MM-dd") + ' ' + worktime.signOut);

        var hoursStart=0,
            hoursEnd=0,
            hoursContent=0;


        if ((new Date(end).format("yyyy-MM-dd")) == (new Date(start).format("yyyy-MM-dd"))) {
            hours = Math.round((endTime - beginTime)/(3600*1000)*100)/100;
            if(hours > worktime.totalHours) hours = parseFloat(worktime.totalHours);
        } else {
            if(beginTime < signOutTime) hoursStart = Math.round((signOutTime - beginTime)/(3600*1000)*100)/100;
            if(hoursStart > worktime.totalHours) hoursStart = parseFloat(worktime.totalHours);
            if(endTime > signInTime) hoursEnd = Math.round((endTime - signInTime)/(3600*1000)*100)/100;
            if(hoursEnd > worktime.totalHours) hoursEnd = parseFloat(worktime.totalHours);
            var days = Math.floor((Date.parse(new Date(end)) - Date.parse(new Date(start)))/(24*3600*1000));
            if(days > 1) hoursContent = (days - 1) * worktime.totalHours;
            hours = hoursStart + hoursEnd + hoursContent;
        }

        $('#hours').val(hours);
    });

    $('.btn-leave').click(function () {
        start = $('#start').val();
        end = $('#end').val();

        if ((new Date(start).format("yyyy-MM")) !== (new Date(end).format("yyyy-MM"))) {
            $('.error').show();
            return false;
        } else {
            $('.error').hide();

        }
    });
})


    // 对Date的扩展，将 Date 转化为指定格式的String
    // 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
    // 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
    // 例子：
    // (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
    // (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
    Date.prototype.format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

