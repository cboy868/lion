<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\approval\models\ApprovalProcess;


$process = ApprovalProcess::process();

$types = ArrayHelper::map($process, 'id', 'type');
?>
<?=\app\core\widgets\Alert::widget()?>
<div class="approval-form">
    <style>
        .attach{
            margin-bottom:5px;
        }
        .attachfile{
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 3px;
            margin-right: 10px;
        }
        .attachfile a{
            margin-left: 10px;
            font-size: 15px;
        }
    </style>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'process_id')
        ->dropDownList(ArrayHelper::map($process, 'id', 'title'),['prompt'=>'请选择审批流程','class'=>'form-control m-process'])
        ->label('选择对应流程');
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6])->label('主内容')
        ->hint('简洁清晰的描述，更容易审批通过哟');
    ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'class'=>'form-control m-total']) ?>

    <?= $form->field($model, 'yet_money')
        ->hiddenInput(['maxlength' => true, 'class'=>'form-control m-yet'])
        ->label(false)
    ?>

    <?= $form->field($model, 'pay')->textInput(['maxlength' => true, 'class'=>'form-control m-pay'])
        ->hint('可按需求分批申请')
    ?>

    <table class="table table-bordered">
        <?php if (isset($attachs) && $attachs):?>
        <tr>
            <th style="text-align: center">已上传文件
                <br>
                <span style="color:#ab422d">单击文件下载</span>
            </th>
            <td>
                <?php foreach ($attachs as $attach):?>
                <span class="attachfile"><?=Html::a($attach->title, [$attach->url],
                        ['download'=>$attach->title.'.'.$attach->ext])?> <a href="#">x</a>
                </span>
                <?php endforeach;?>
            </td>
        </tr>
        <?php endif;?>
        <tr>
            <th width="150" style="text-align: center">上传附件<br><span style="color:#ab422d">上传大小不要超过10M</span></th>
            <td>
                <span><input type="file" class="attach" name="attach[]"></span>
                <span><input type="file" class="attach" name="attach[]"></span>
                <span><input type="file" class="attach" name="attach[]"></span>
                <span><input type="file" class="attach" name="attach[]"></span>
            </td>
        </tr>
    </table>

	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

<?php $this->beginBlock('tree') ?>
    $(function(){
        types();
        $('.m-total').change(function (e) {
            e.preventDefault();
            $('.m-pay').val($(this).val() - $('.m-yet').val());
        });

        $('.m-process').change(function(){
            types();
        });
    })

function types()
{
    var types = <?=json_encode($types)?>;
    var pro = $('.m-process').val();
    if (!pro) {
        $('.m-total').closest('.form-group').hide();
        $('.m-pay').closest('.form-group').hide();
        return;
    };

    if (types[pro]==1 || types[pro] == 2){
        $('.m-total').closest('.form-group').hide();
        $('.m-pay').closest('.form-group').hide();
    } else {
        $('.m-total').closest('.form-group').show();
        $('.m-pay').closest('.form-group').show();
    }

}


<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

