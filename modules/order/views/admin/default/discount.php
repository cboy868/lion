<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\bootstrap\Modal;
use app\modules\order\models\Order;
use app\modules\order\models\Delay;

\app\assets\JqueryuiAsset::register($this);
$this->params['current_menu'] = 'order/default/index';

$this->title = $model->id . '号订单处理';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$discount = json_encode(Yii::$app->getModule('grave')->params['order'][0]);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                订单处理
            </h1>
        </div>
        <?=\app\core\widgets\Alert::widget();?>
        <div class="row">
            <div class="col-xs-12">
                <div class="orderlist">
                    <table class="table table-striped table-hover table-bordered table-condensed" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <th width="15%">订单号：</th>
                            <td><code><?=$model->id?></code></td>
                            <!-- <td rowspan="9" width="300">
                                <iframe scrolling="no" frameborder="0" style="width:300px;height:335px;" src=""></iframe>
                            </td> -->
                        </tr>
                        <?php if ($model->tid):?>
                            <tr>
                                <th>墓位号</th>
                                <td>
                                    <?php
                                        echo Html::a($model->tomb->tomb_no,
                                            ['/grave/admin/tomb/view', 'id'=>$model->tid],
                                            ['target'=>'_blank'])
                                    ?>
                                </td>
                            </tr>
                        <?php endif;?>
                        <tr>
                            <th>下单用户：</th>
                            <td colspan="3"><?=$model->user->username?></td>
                        </tr>
                            <tr><th>操作员：</th>
                            <td colspan="3">manage</td>
                        </tr>
                        <tr>
                            <th>订单原价：</th>
                            <td><?=$model->origin_price?> 元</td>
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
                            <td colspan="3"><?=Order::pro($model->progress)?></td>
                        </tr>
                        <tr>
                            <th>下单时间：</th>
                            <td><?=date('Y-m-d H:i', $model->created_at)?></td>
                        </tr>
                    </tbody>
                    </table>
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th width="15%">墓位原价</th>
                            <th><input type="text" disabled="disabled" value="<?=$rel->price?>" class="ori"></th>
                        </tr>
                        <tr>
                            <th>折扣</th>
                            <td><input type="text" class="discount">% <span class="error"></span></td>
                        </tr>
                        <tr>
                            <th>折后价</th>
                            <td><input type="text" class="change" dprice="<?=$rel->price?>"> <span class="error"></span></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><button class="btn btn-info btn-lg">提交申请</button></td>
                        </tr>

                    </table>
                </div>    
            </div>

            <div class="col-xs-12">
                <h4>墓位详情</h4>
                 <table class="table table-striped table-hover table-bordered table-condensed" style="text-align:center">
                  <tbody>
                    <tr>
                        <th align="left">墓位</th>
                        <th align="center">总价</th>
                        <th align="center">下单用户</th>
                      </tr>
                      <?php foreach ($model->trels as $rel): ?>
                          <?php if($rel->type != 9) continue;?>
                          <tr class="<?php if($rel->status==-1) echo 'delline'?>">
                            <td align="left"><?=$rel->title?></td>
                            <td align="left"><?=$rel->price?></td>
                            <td align="left"><?=$rel->user->username?></td>
                          </tr>
                      <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<style>
    .error{
        color:red;
    }
</style>
<?php $this->beginBlock('order') ?>  

$(function() {
    var dis = eval('('+'<?=$discount?>'+')');
    $('.discount').change(function (e) {
        var val = $(this).val();
        if (val > dis.discount) {
            $(this).closest('td').find('.error').text('超过最大可折扣值');
        } else {
            var ori = $('.ori').val();
            var price = ori - (ori * val/100);
            $('.change').val(price);
            $('.change').attr('dprice', price);
            $(this).closest('td').find('.error').text('');
        }
    });

    $('.change').change(function (e) {
        var val = $(this).val();
        var dprice = $(this).attr('dprice');
        if ((dprice-val) > dis.change) {
            $(this).closest('td').find('.error').text('超过最大可调整值');
            $(this).val(dprice);
        } else {
            $(this).closest('td').find('.error').text('');
        }
    });
});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  