<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\bootstrap\Modal;
use app\modules\order\models\Order;
use app\modules\order\models\Delay;

Yii::$app->params['cur_nav'] = 'order_index';

$this->title = $model->id . '号订单明细';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
    <?php if (!$model->isFinish): ?>
        <div class="page-header">
            <h1>
                <small>

                </small>
            </h1>
        </div>
    <?php endif ?>
        
        <!-- /.page-header -->
        <?php 
            Modal::begin([
                'header' => '修改价格',
                'id' => 'modalEdit',
                'size' => 'SIZE_SMALL',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]

            ]) ;

            echo '<div id="editContent"></div>';
            Modal::end();
        ?>
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
                                            ['/grave/member/tomb/tomb', 'id'=>$model->tid],
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
                    </tbody></table>
                </div>    
            </div>

            <div class="col-xs-12">
                <h4>订单详情</h4>
                 <table class="table table-striped table-hover table-bordered table-condensed" style="text-align:center">
                  <tbody>
                    <tr>
                        <!-- 
                        <th width="50" align="center">#</td>
                        -->
                        <th align="center">名称</th>
                        <!--<th align="center">单价</th>-->
                        <!-- <th align="center">原价</th> -->
                        <th align="center">总价</th>
                        <th align="center" width="200">备注</th>
                        <th align="center">数量</th>
                        <th align="center">下单用户</th>
                        <th align="center">操作员</th>
                        <th align="center">使用时间</th>
                        <th align="center">状态</th> 
                        <th align="center"></th> 
                      </tr>
                      <?php foreach ($model->rels as $rel): ?>
                          <tr>
                            <td align="center"><?=$rel->title?></td>
                            <!--<td align="center">500000.00</td>-->
                            <!-- <td align="center">500000.00</td> -->
                            <td align="center"><?=$rel->price?></td>
                            <td align="center"><?=$rel->note?></td>
                            <td align="center"><?=$rel->num?></td>
                            <td align="center"><?=$rel->user->username?></td>
                            <td align="center"></td>
                            <td align="center"><?=$rel->use_time?></td>
                            <td align="center"><?=$rel->statusText?></td>  
                            <td></td>  
                          </tr> 
                      <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <?php if ($model->delays): ?>
                    <div class="col-xs-12">
                      <h4>延期记录</h4>
                      <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                          <tr>
                            <th>操作员</th>
                            <th>申请人</th>
                            <th>申请金额</th>
                            <th>预付时间</th>
                            <th>状态</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->delays as $delay): ?>
                             <tr>
                              <td><?=$delay->op->username?></td>
                              <td><?=$delay->user->username?></td>
                              <td><?=$delay->price?></td>
                              <td><?=date("Y-m-d H:i", $delay->created_at)?></td>
                              <td><?=Delay::getVerfy($delay->is_verified)?></td>
                            </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                    </div>
            <?php endif ?>
            


            <div class="col-xs-12">
              <h4>收款记录</h4>
              <table class="table table-striped table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>支付金额</th>
                    <th>支付方式</th>
                    <th>操作员</th>
                    <th>支付时间</th>
                  </tr>
                </thead>
                <tbody>

                    <?php foreach ($model->pays as $pay):
                        if (!$pay->pay_result) continue;
                        ?>
                     <tr>
                      <td><?=$pay->total_pay?></td>
                     <td><?=$pay->method?></td>
                      <td><?=$pay->user->username?></td>
                      <td><?=date("Y-m-d H:i", $pay->updated_at)?></td>
                    <td><a title="收款打印" ylw-simple-remote="true" href="#"><i class="icon icon-print"></i> 打印本次收款单</a>
                        <input class="pay_item" type="checkbox" name="pay_item" value="59610">
                    </td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('order') ?>  

$(function() {

    

});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  