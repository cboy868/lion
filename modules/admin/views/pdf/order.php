<?php
use yii\helpers\Url;

$pay_id = Yii::$app->request->get('pay_id');
$order_id = Yii::$app->request->get('order_id');
\app\assets\ExtAsset::register($this);
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 tomb-update">
                <form method="post" action="<?=Url::toRoute(['/admin/pdf/order', 'order_id'=>$order_id,'pay_id'=>$pay_id])?>">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <table class="tomb-card-info table table-condensed table-striped checkbox_parent">
                        <tbody>
                        <tr>
                            <input type="hidden" name="tomb_no" value="<?=$info['tomb_no']?>">
                            <td class="td-h">安葬位置：</td>
                            <td><?=$info['tomb_no']?></td>
                        </tr>

                        <tr>
                            <td class="td-h">办理人：</td>
                            <td><input type="text" name="customer_name" value="<?=$info['customer_name']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">墓款：</td>
                            <td><input type="text" name="tomb_price" value="<?=$info['tomb_price']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">安葬款：</td>
                            <td><input type="text" name="bury_price" value="<?=$info['bury_price']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">碑文费用：</td>
                            <td><input type="text" name="ins_price" value="<?=$info['ins_price']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">小商品费用：</td>
                            <td><input type="text" name="goods_price" value="<?=$info['goods_price']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">应付款：</td>
                            <td><input type="text" name="should_pay" value="<?=$info['should_pay']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">已付款：</td>
                            <td><input type="text" name="aready_total" value="<?=$info['aready_total']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">本次付款：</td>
                            <td><input type="text" name="this_total" value="<?=$info['this_total']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">本次付款(大写)：</td>
                            <td><input type="text" name="this_total_payment" value="<?=$info['this_total_payment']?>"></td>
                        </tr>

                        <tr>
                            <td class="td-h">商品明细：</td>
                            <td>
                                <textarea name="detail" id="" cols="30" rows="10"><?=$info['detail']?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-h">导购员：</td>
                            <td><input type="text" name="guide_name" value="<?=$info['guide_name']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">操作员：</td>
                            <td><input type="text" name="op_name" value="<?=$info['op_name']?>"></td>
                        </tr>
                        <tr>
                            <td class="td-h">收款日期：</td>
                            <td><input type="text" name="pay_time" value="<?=$info['pay_time']?>" dt="true"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <button class="btn btn-info">确定</button>
                                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true" >取消</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
