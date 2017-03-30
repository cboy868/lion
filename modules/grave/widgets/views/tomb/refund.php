<?php 
use app\core\helpers\Url;
?>
<?php if ($refunds): ?>
<div class="col-xs-12">
    <div class="item table-responsive" id="order" loc="loc13">
        <div class="table-header"><i class="icon-credit-card"></i> 
            <span class="title_info">退款记录</span>
        </div>

        <?php foreach ($refunds as $refund): ?>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                    <tr class="warning">
                        <td colspan="6">对应订单编号：<a target="_blank" href="<?=Url::toRoute(['/order/admin/default/view', 'id'=>$refund->order_id])?>"><?=$refund->order_id?></a> 退款时间：<?=date('Y-m-d H:i', $refund->created_at)?></td>
                    </tr>
                    <?php if (!empty($refund->note)): ?>
                        <tr class="alert alert-danger">
                            <td colspan="6">备注: <?=$refund->note?></td>
                        </tr>
                    <?php endif ?>
                    
                    <tr>
                        <th>项目</th>
                        <th>数量</th>
                        <th>退款额(元)</th>
                        <th>状态</th>
                    </tr>
                    <?php $intro = json_decode($refund->intro, true) ?>

                    <?php if ($intro): ?>
                        <?php foreach ($intro as $k => $rel): ?>
                            <tr>
                                
                                 <td><?=$rel['name']?></td>
                                 <td><?=$rel['num']?></td>
                                 <td><?=$rel['price']?></td>
                                 <?php if ($k == 0): ?>
                                     <td rowspan="<?=count($intro)?>" style="vertical-align:middle;text-align:center;">
                                    总退款额：<?=$refund->fee?>
                                    </td>
                                    <td rowspan="<?=count($intro)?>" style="vertical-align:middle;text-align:center;"><?=$refund->pro?></td>
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