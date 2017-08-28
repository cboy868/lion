<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
    .pics img{
        width:80px;
        height:80px;
        margin:10px;
        margin-bottom:0;
    }
    .pics a.active img{
        border: 1px solid #4f838f;
    }
    .pics a img{
        border: 1px solid #eee;
    }
    .btns button{
        width:100px;
    }
    a.typesel{
        display: inline-block;
    }
    a.typesel p{
        text-align: center;
        color: #999;
    }
</style>
<div class="">

    <?php $form = ActiveForm::begin(); ?>
    <div class="pics">
        <?php foreach ($types as $key => $type):?>
            <a class="typesel" href="#" data-tid="<?=$key?>">
                <img src="<?=$type['cover']?>" title="<?=$type['title']?>">
                <p><?=$type['title']?></p>
            </a>
        <?php endforeach;?>
        <?= $form->field($model, 'type')->hiddenInput(['class'=>'input-type'])->label(false)?>

    </div>

    <?= $form->field($model, 'msg')->textarea(['maxlength' => true,'minlength' => true,'style'=>'height:200px;width:100%;'])->label(false) ?>

    <div class="form-group" style="text-align: right">
        <?=  Html::submitButton(' 取 消 ', [
                'class' => 'button bg-sub btn btn-default btn-lg',
            'style'=>'width:100px',
            'data-dismiss'=>"modal"
        ]) ?>
        <?=  Html::submitButton(' 保 存 ', ['class' => 'button btn btn-success btn-lg btn-save','style'=>'width:100px;']) ?>

    </div>
    <?php ActiveForm::end(); ?>


</div>

<?php $this->beginBlock('cate') ?>
$(function(){

    $('.typesel').click(function(e){
        e.preventDefault();
        var type = $(this).data('tid');
        $('.typesel').removeClass('active');
        $(this).addClass('active');
        $('.input-type').val(type);
    });

    $('.btn-save').click(function (e) {
        e.preventDefault();
        var type = $(this).closest('form').find('.input-type').val();

        if (type == '') {
            alert('您好，请先选择一个小礼物');
            return;
        }

        var data = $(this).closest('form').serialize();

        $.post('<?=Url::toRoute(['candle-flower','id'=>$model->memorial_id])?>',data,function (xhr) {
            if (xhr.status) {
                alert('您好，您的祝福已成功');
                location.reload();
                //$('#modalAdd').modal('hide');
            } else {
                alert(xhr.info);
            }
        },'json')
    });


})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>


