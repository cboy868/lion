<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
\app\assets\ExtAsset::register($this);
?>

<div class="set-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?php if (count($goods->sku)>1):?>
            <?php $skus = \yii\helpers\ArrayHelper::map($goods->sku, 'id', 'name') ?>
            <?= $form->field($model, 'sku_id')->dropDownList($skus, ['class'=>'sku_id form-control']) ?>
        <?php else:?>
            <input type="hidden" value="<?=$goods->sku[0]->id?>" class="sku_id form-control">
        <?php endif;?>

        <?= $form->field($model, 'num')->textInput(['type'=>'number','class'=>'form-control gnum']) ?>

        <?= $form->field($model, 'use_time')->textInput([
                'dt'=>'true',
                'min'=>date("Y-m-d",strtotime('+1 day')),
                'value'=>date("Y-m-d",strtotime('+1 day')),
                'class' => 'form-control use_time'
        ]) ?>

        <?= $form->field($model, 'note')->textArea(['class'=>'form-control gnote']) ?>
    </div>

    <div class="col-md-6">
        <h2 style="text-align: center;font-weight: 700;color: #39a;margin:0">微信扫码支付</h2>
        <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" alt="扫码支付" style="width:100%;" class="img-code">
    </div>


    <div class="form-group col-md-12">
        <?=  Html::submitButton('取 消', ['class' => 'btn btn-success closeModal']) ?>
        <?=  Html::submitButton('扫码支付', ['class' => 'btn btn-danger scanpay', 'type'=>'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<div class="clearfix"></div>
</div>


<?php $this->beginBlock('cate') ?>
$(function(){
    $('.closeModal').click(function(e){
        e.preventDefault();
        $('#modalSet').modal('hide');
    });

    LN.dtInit();



    $('.gnum,.sku_id,.use_time,.gnote').change(function (e) {
        e.preventDefault();
        removeCode();
        //initCode();
    });

    $('.gnum,.sku_id,.use_time,.gnote').focus(function (e) {
        e.preventDefault();
        removeCode();
    });

    $('.scanpay').click(function(e){
        e.preventDefault();
        initCode();
    });

    function removeCode(){
        $('.img-code').attr('src', 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==');
    }

    function initCode(){

        var num = $('.gnum').val();
        var sku_id = $('.sku_id').val();
        var use_time = $('.use_time').val();
        var note = $('.gnote').val();
        var src = "<?=Url::toRoute(['/wechat/home/order/qr-goods','tomb_id'=>$memorial->tomb_id])?>&num="+
num+"&sku_id="+sku_id+"&use_time="+use_time+"&note="+note+'&type=8';
        $('.img-code').attr('src', src);
    }


})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

