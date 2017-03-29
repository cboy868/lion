<?php 
use app\core\helpers\Url;
?>
<?php if ($orders): ?>
<div class="col-xs-12">
    <div class="item table-responsive" id="order" loc="loc13">
        <div class="table-header"><i class="icon-credit-card"></i> 
            <span class="title_info">墓位订单</span>
        </div>

        <?php foreach ($orders as $order): ?>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                    <tr class="warning">
                        <td colspan="6">订单编号：<a target="_blank" href="<?=Url::toRoute(['/order/admin/default/view', 'id'=>$order->id])?>"><?=$order->id?></a> 成交时间：<?=date('Y-m-d H:i', $order->created_at)?></td>
                    </tr>
                    <?php if (!empty($order->note)): ?>
                        <tr class="alert alert-danger">
                            <td colspan="6">备注: <?=$order->note?></td>
                        </tr>
                    <?php endif ?>
                    
                    <tr>
                        <th>服务项目</th>
                        <th>价格(元)</th>
                        <th>原价格(元)</th>
                        <th>数量</th>
                        <th>应付款(元)</th>
                        <th>状态</th>
                    </tr>
                    <?php if ($order->rels): ?>
                        <?php foreach ($order->rels as $k => $rel): ?>
                            <tr>
                                <td><?=$rel->title?>
                                    <?php if ($rel->is_refund): ?>
                                        (已退款)
                                    <?php endif ?>
                                </td>
                                 <td><?=$rel->price?></td>
                                 <td><?=$rel->original_price?></td>
                                 <td><?=$rel->num?></td>
                                 <?php if ($k == 0): ?>
                                     <td rowspan="<?=count($order->rels)?>" style="vertical-align:middle;text-align:center;">
                                    总款：<?=$order->price?> 已付款：<?=$order->totalPay?>
                                    </td>
                                    <td rowspan="<?=count($order->rels)?>" style="vertical-align:middle;text-align:center;"><?=$order->pro?></td>
                                 <?php endif ?>
                            </tr>             
                        <?php endforeach ?>
                    <?php endif ?>
                           
                    </tbody>
            </table>
        <?php endforeach ?>

    </div>
</div>
<?php endif ?>