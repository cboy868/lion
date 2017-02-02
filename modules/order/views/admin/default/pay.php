<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\order\models\Pay;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '订单明细';
?>

<style type="text/css">
    #paytypelist .table>tbody>tr>td{
        border:none;
    }
    .tb{
        border-top: 1px solid #999;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?=$model->id?>号订单收款</h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="orderlist">
                    <table class="table table-striped table-hover table-bordered table-condensed" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <th width="15%">订单号：</th>
                            <td><code><?=$model->id?></code></td>
                        </tr>
                        <tr>
                            <th>下单用户：</th>
                            <td colspan="3"><?=$model->user->username?></td>
                        </tr>
                            <tr><th>操作员：</th>
                            <td colspan="3">manage</td>
                        </tr>
                        <tr>
                            <th>应付款：</th>
                            <td colspan="3"><?=$model->price?> 元</td>
                        </tr>
                        <tr>
                            <th>已支付：</th>
                            <td colspan="3"><?=$model->getTotalPay()?> 元</td>
                        </tr>
                        <tr>
                            <th>未支付：</th>
                            <td colspan="3"><?=$model->price - $model->getTotalPay()?> 元</td>
                        </tr>
                        <tr>
                            <th>支付进度：</th>
                            <td colspan="3"><?=$model->getStaLabel()?></td>
                        </tr>
                        <tr>
                            <th>下单时间：</th>
                            <td><?=date('Y-m-d H:i', $model->created_at)?></td>
                        </tr>
                    </tbody></table>
                </div>    
            </div>


            <div class="col-xs-12">
                <h4>订单收款</h4>
                <div class="well">
                    <form name="form" action="" method="post">

                    <input type="hidden" name="order_id" value="<?=$model->id?>" />
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    <div id="paytypelist">
                        <div class="form-tb-box">
                        <div id="pay-type-list">
                        <table class="table">
                           <tr>
                               <td width="120">付款类型：</td>
                               <td>
                                 <?=Html::dropDownList('pay_type[]',null ,Pay::getMethods(), ['class'=>'form-control', "style"=>"width:200px;"])?>
                              </td>
                           </tr>
                           <tr>
                               <td>付款金额(元)：</td>
                               <td>
                                   <input rel="price" type="text" name="price[]" class="form-control"  style="width:200px;" value="<?=$model->price - $model->getTotalPay()?>" />
                               </td>
                           </tr>
                           <tr>
                               <td>付款说明：</td>
                               <td>
                                   <textarea rel="note" name="note[]" class="form-control" style="width:400px;" rows="5" ></textarea>
                               </td>
                           </tr>
                        </table>
                        </div>
                        <p class="button-box">
                            <input class="btn btn-primary btn-xs" id="form-submit" type="submit" value="确认收款" />
                            <input class="btn btn-success btn-xs" id="add-type" type="button" value="增加付款类型"  />
                        </p>
                        </div>
                    </div>
                    </form>
                </div>

                <div id="pay-type-tpl" style="display:none;width:850px;">
                <hr>
                    <table class="table tb">
                       <tr>
                          <td width="120px">付款类型：</td>
                           <td>
                               <?=Html::dropDownList('pay_type[]',null ,Pay::getMethods(),['class'=>'form-control', "style"=>"width:200px;display:inline-block;"])?>
                               <a class="del-type" href="#" style="margin-left:20px;">删除</a>
                          </td>
                       </tr>
                       <tr class="strip">
                           <td>付款金额：</td>
                           <td>
                              <input rel="price" type="text" style="width:200px;" class="char-input" name="price[]" size="10" /> 元
                           </td>
                       </tr>
                       <tr>
                           <td>付款说明：</td>
                           <td>
                              <textarea rel="note" name="note[]" style="width:400px;" rows="5" class="small"></textarea>
                           </td>
                       </tr>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('order') ?>  
var order_id = "<?=$model->id?>";
// 应付款金额
var totalPrice =  "<?=$model->price - $model->getTotalPay()?>";
// 当前已经选择的价格
var selPrice = 0;

// 计算当前已经选择的价格
var calSelPrice = function()
{
    var total = 0;
    $('#pay-type-list').find('input[rel=price]').each(function(){
        total += parseFloat($(this).val()); 
    });
    return total;
}

$(function() {

    selPrice = calSelPrice();

    if (selPrice == totalPrice) {
        $('#add-type').attr('disabled', true); 
    }

    // 价格框键盘敲击

    $('body').on('keyup', 'input[rel=price]', function(e){
        var $this = $(this);
        var currPrice = parseFloat($this.val());

        var currTotalPrice = calSelPrice();
        if (currTotalPrice > totalPrice) {
            alert('数字不能大于应收款的总额');
            $this.val('0'); 
        }

        if (currTotalPrice == totalPrice) {
            $('#add-type').attr('disabled', true);
        } else {
            $('#add-type').removeAttr('disabled');
        }
    });

    // 1 选择业务欠款时候处理

    $('body').on('click', 'a.del-type', function(e){
        e.preventDefault();    
        $(this).parents('table').remove();
        $('#add-type').removeAttr('disabled');
    });


    // 2 添加新的业务收款
    $('#add-type').click(function(e){
        e.preventDefault();
        var formContent = $('#pay-type-tpl').find('table').clone().show();
        $('#pay-type-list').append(formContent);
        // 计算金额
        var total = 0;
        $('#pay-type-list input[rel=price]').each(function(index, item) {
            var p = parseInt($(item).val(), 10);
            if (isNaN(p) || p < 0) {
                p = 0;
            }
            total += p;
        });

        //if (total >= totalPrice) {
        $('#add-type').attr('disabled', true);
        //}

        formContent.find('input[rel=price]').val(totalPrice - total);
    });

    $('#form-submit').click(function(e){
        e.preventDefault();
        var total = 0;
        var binput = true;
        $('#pay-type-list input[rel=price]').each(function() {
            var p = parseInt($(this).val(), 10);
            if (isNaN(p) || p < 0) {
                alert('金额输入有误，请重新输入');
                $(this).focus();
                binput = false;
                return false;
            }
            total += p;
        });

        if (!binput || (total>totalPrice)) {
            return false;
        }
        if (total > totalPrice) {
            alert('输入总金额大于应支付金额，请核实');
            return false;
        }
        if (!confirm('您确认进行该操作吗？')) {
            return false;
        }
        $('form[name=form]').submit();
    });

});


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  