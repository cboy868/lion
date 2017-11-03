<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['current_menu'] = 'order/default/index';

$this->title = $order->id . '号订单进行退款操作';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    如果需要退墓，请在退墓手续中办理
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 order-update">


                <div class="order-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($refund, 'order_id')->hiddenInput()->label(false);?>

                    <div class="form-group">
                        <label class="control-label" for="refund-fee">订单详情</label>
                        <table class="table noborder orels" style="max-width:700px;">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th width="80">数量</th>
                                <th width="80">单价</th>
                                <th width="80">总价</th>
                                <th width="100">退款数量</th>
                                <th width="100">退款金额</th>
                            </tr>
                            </thead>

                                <div class="tr tr<?=$order->id?>" style="color:green;">
                                    已收款金额: <span><?=$opay[$order->id]?></span>,已批准退款金额: <span><?=$orefund[$order->id]?></span>
                                </div>
                                <?php foreach ($order->rels as $rel):?>
                                    <?php if($rel->type==9) continue;?>
                                    <tr class="tr tr<?=$order->id?>"
                                        data-num="<?=$rel->num?>"
                                        data-unit="<?=$rel->price_unit?>"
                                    >
                                        <td><?=$rel->title?></td>
                                        <td><?=$rel->num?></td>
                                        <td><?=$rel->price_unit?></td>
                                        <td><?=$rel->price?></td>
                                        <td style="width:100px;">
                                            <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger btn-minus" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </span>
                                                <input name="rel[<?=$rel->id?>]" class="form-control gnum" style="padding:4px 3px;width:50px" value="0">
                                                <span class="input-group-btn">
                                                <button class="btn btn-success btn-plus" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="uprice[<?=$rel->id?>]" class="uprice form-control" value="0">
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                        </table>
                    </div>


                    <?= $form->field($refund, 'fee')->textInput(['maxlength' => true,'class'=>'form-control tprice']) ?>

                    <?= $form->field($refund, 'note')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <div class="col-sm-3">
                            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block submit-refund']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>


                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('refund') ?>
    $(function() {
        var relListBox = $('.orels');

// 商品页面加减数量
        relListBox.on('click', 'button.btn-minus,button.btn-plus', function(e){
            e.preventDefault();
            var $this = $(this);
            var max = $(this).closest('tr').data('num');
            var unitPrice = $(this).closest('tr').data('unit');

            var relItem = $this.parents('tr');
            var target = relItem.find('.gnum');
            var targetPrice = relItem.find('.uprice');
            var val = parseInt(target.val());

            var num=0;
            if ($this.hasClass('btn-minus')) {
                if (val > 0) {
                    num = --val;
                }
            } else{
                var num = (val+1) > max ? val : ++val;
            }
            target.val(num);
            targetPrice.val(num*unitPrice);

            calPrice();

        });

        $('.uprice').change(function(){
            calPrice();
        });

        $(".submit-refund").click(function () {
            var flag = false;
            $('.gnum').each(function () {
                if ($(this).val() != 0) {
                    flag = true;
                }
            })
            if (!flag) {
                alert('请选择要退款的商品');
                return false;
            }

        });

    });
    function calPrice(){
        var total = 0;

        $('.uprice').each(function () {
            total += parseFloat($(this).val());
console.dir(total);
        });

        $('.tprice').val(total);

    }
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['refund'], \yii\web\View::POS_END); ?>  
