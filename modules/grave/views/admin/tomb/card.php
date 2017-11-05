<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 tomb-update">
                <form method="post" action="<?=\yii\helpers\Url::toRoute(['card', 'tomb_id'=>$tomb_id])?>">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <table class="tomb-card-info table table-condensed table-striped checkbox_parent">
                        <tbody>
                        <tr>
                            <input type="hidden" name="card_no[tit]" value="<?=$info['card_no']?>">
                            <th style="width:10m;">墓证号：</th>
                            <td><?=$info['card_no']?></td>
                            <td> <input class="print-item" type="checkbox" name="card_no[flg]" value="1"> </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="tomb_no[tit]" value="<?=$info['tomb_no']?>">
                            <td class="td-h">安葬位置：</td>
                            <td><?=$info['tomb_no']?></td>
                            <td class="td-i">
                                <input class="print-item" type="checkbox" name="tomb_no[flg]" value="1">
                            </td>
                        </tr>
                        <?php foreach ($info['deads'] as $k=> $dead):?>
                        <tr>
                            <td class="td-h">逝者姓名：</td>
                            <td><input type="text" name="dead[<?=$k?>][tit]" value="<?=$dead?>"></td>
                            <td class="td-i"><input class="print-item" type="checkbox" name="dead[<?=$k?>][flg]" value="1"></td>
                        </tr>
                        <?php endforeach;?>

                        <tr>
                            <td class="td-h">安葬日期：</td>
                            <td><input type="text" name="bury_date[tit]" value="<?=$info['bury_date']?>"></td>
                            <td class="td-i"><input class="print-item" type="checkbox" name="bury_date[flg]" value="1"></td>
                        </tr>

                        <tr>
                            <td class="td-h">购墓人：</td>
                            <td><input type="text" name="customer_name[tit]" value="<?=$info['customer_name']?>"></td>
                            <td class="td-i"><input class="print-item" type="checkbox" name="customer_name[flg]" value="1"></td>
                        </tr>

                        <tr>
                            <td class="td-h">发证日期：</td>
                            <td><input type="text" name="card_date[tit]" value="<?=$info['card_date']?>"></td>
                            <td class="td-i">
                                <input class="print-item" type="checkbox" name="card_date[flg]" value="1">
                            </td>
                        </tr>
                        <?php foreach ($info['card_dates'] as $k=>$dt):?>
                        <tr>
                            <td class="td-h">墓证时间：</td>
                            <td><input type="text" name="card_dates[<?=$k?>][tit]" value="<?=$dt?>"></td>
                            <td class="td-i">
                                <input class="print-item" type="checkbox" name="card_dates[<?=$k?>][flg]" value="1">
                            </td>
                        </tr>
                        <?php endforeach;?>

                        <tr>
                            <td class="td-h">墓价：</td>
                            <td><input type="text" name="price[tit]" value="<?=$info['price']?>"></td>
                            <td class="td-i"><input class="print-item" type="checkbox" name="price[flg]" value="1"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="td-i">
                                <i class="icon icon-hand-up"></i>
                                <a data-status="0" style="cursor:pointer" class="all-checked">全选</a>
                            </td>
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
<?php $this->beginBlock('moda') ?>
$(function () {
    $('.all-checked').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var printItems = $('input.print-item');
        if ($this.data('status') == 0) {
            printItems.each(function(i, item){
                if(!$(item).hasClass('check_card')){
                    $(item).prop('checked', true);
                }
            });
            $this.data('status', 1);
        } else {
            printItems.each(function(i, item){
                if(!$(item).hasClass('check_card')){
                    $(item).prop('checked', false);
                }
            });
            $this.data('status', 0);
        }
    });

});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['moda'], \yii\web\View::POS_END); ?>