<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\grave\models\Withdraw;
\app\assets\ExtAsset::register($this);
$type = Yii::$app->request->get('type');
?>
<style type="text/css" media="screen">
    table.table-goods td{
        vertical-align: middle!important;
    }
    .form-inline .form-group{
        /*margin-bottom: 10px;*/
    }
    .selectize-control{
        display: inline-block;
    }

    .selectize-input {
        border: 1px solid #d0d0d0;
        padding: 3px 8px;
        width: 10em;
        overflow: visible;
        border-radius:0;
    }
</style>
<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (in_array($type, [Withdraw::TYPE_DING_CHANGE,Withdraw::TYPE_REFUND_IN])): ?>


        <div class="form-group field-withdraw-ct_mobile">
            <label class="control-label" for="withdraw-ct_mobile">换至墓位</label>
            <div>
                <?=Html::dropDownList('grave_id', null,
                    $graves,['class'=>'sel-ize gv grave','prompt'=>'请选择墓区'])?>
                -

                <input class="tombinfo trow" type="text" placeholder="排"
                       name="row" value="<?=isset($tomb->row) ? $tomb->row:''?>" style="width:3em">
                -
                <input class="tombinfo tcol" type="text" placeholder="列"
                       name="col" value="<?=isset($tomb->col) ? $tomb->col : ''?>" style="width:3em">
                <p class="infonote"></p>
            </div>
        </div>

        <?= $form->field($model, 'in_tomb_id')
            ->hiddenInput(['maxlength' => true,'class'=>'intomb'])->label(false) ?>
    <?php endif;?>

    <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ct_relation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reson')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true])->hint('曾付款:'. $oprice) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block', 'id'=>'submitRefund']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

    <input type="hidden" value="<?=Url::toRoute(['/grave/admin/tomb/info', 'type'=>\app\modules\grave\models\Tomb::STATUS_EMPTY])?>" class="uri">
</div>
<?php $this->beginBlock('foo') ?>
    $('.grave,.trow,.tcol').change(function (e) {
        var grave = $('.grave').val();
        var row = $('.trow').val();
        var col = $('.tcol').val();

        if (!grave || !row || !col) {
            return ;
        }
        var csrf = $('meta[name="csrf-token"]').attr('content');
        var data = {grave:grave,row:row,col:col,_csrf:csrf};
        var url = $('.uri').val();
        $.post(url,data,function(xhr){
            if (xhr.status) {
                var tomb = xhr.data.tomb;
                $('.intomb').val(tomb.id);

                $('.infonote').removeClass('text-danger').addClass('text-success').text("墓位状态:" + xhr.data.tombStatus + '符合要求');
            } else {
                $('.intomb').val('');
                $('.infonote').removeClass('text-success').addClass('text-danger').text(xhr.info+ '或状态不符');
            }2
        },'json');
    });

    $('#submitRefund').click(function(){
        var tomb_id = $('.intomb').val();
        if ($('.intomb').hasClass('intomb') && !tomb_id) {
            alert('请先选择要迁入的墓位');
            return false;
        }
    });


<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>