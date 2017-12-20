<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '服务确认单';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');

$this->params['current_menu'] = 'order/default/index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$this->title?>
                <small>
                    <a href="javascript:printConirm();" class="btn btn-info btn-lg">打印确认单</a>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="print-info">
                <h2 style="text-align: center">服务确认单</h2>
                <table class="table table-bordered print-info">
                    <tr>
                        <th>办理人</th>
                        <td colspan="2"><?=$info['customer_name']?></td>
                        <th>位置</th>
                        <td colspan="2"><?=$info['tomb_no']?></td>
                    </tr>
                    <tr>
                        <th>墓穴费</th>
                        <td><?=$info['tomb_price']?></td>
                        <th>安葬费</th>
                        <td><?=$info['bury_price']?></td>
                        <th>碑文费</th>
                        <td><?=$info['ins_price']?></td>
                    </tr>
                    <tr>
                        <th>小商品费</th>
                        <td><?=$info['goods_price']?></td>
                        <th>应付款</th>
                        <td><?=$info['should_pay']?></td>
                        <th>已付款</th>
                        <td><?=$info['aready_total']?></td>
                    </tr>
                    <tr>
                        <th>本次付款(大写)</th>
                        <td colspan="2"><?=$info['aready_total_payment']?></td>
                        <th>小写</th>
                        <td colspan="2"><?=$info['this_total']?></td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <h4>使用人</h4>
                            <p>
                                <?php foreach ($info['deads'] as $dead):?>
                                <?=$dead->dead_name;?>(<?=$dead->birth?> ~ <?php if($dead->fete) echo $dead->fete;?>);
                                <?php endforeach;?>
                            </p>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="6">
                            <h4>碑文</h4>
                            <?php if($info['ins']):?>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="#" class="thumbnail">
                                            <img src="<?=$info['ins']['front_img']?>" alt="碑前文">
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="#" class="thumbnail">
                                            <img src="<?=$info['ins']['back_img']?>" alt="碑后文">
                                        </a>
                                    </div>
                                </div>
                            <?php else:?>
                                无
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <h4>商品信息</h4>
                            <?php foreach ($info['rels'] as $v): ?>
                            <span><?=$v['title']?>: <?=$v['num']?>件;</span>
                            <?php endforeach;?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th>办理人签字</th>
                        <td></td>
                    </tr>

                    <tr>
                        <th>导购</th>
                        <td><?=$info['guide_name']?></td>
                        <th>操作员</th>
                        <td><?=$info['op_name']?></td>
                        <th>日期</th>
                        <td><?=$info['pay_time']?></td>
                    </tr>
                </table>
                <div style="text-align: center">
                    <a href="#" class="printConirm btn btn-info btn-lg"> 打 印 </a>
                </div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>

$(function() {
    $('div').addClass('Noprint');
    $('span').addClass('Noprint');
    $('h3').addClass('Noprint');
    $('.pageContent').removeClass('Noprint');
    $('table').removeClass('Noprint');
});
function pagesetup_null()
{
    var hkey_key;
    var hkey_root="HKEY_CURRENT_USER";
    var hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\";
    try {
        var RegWsh = new ActiveXObject("WScript.Shell");
        hkey_key="header";
        RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
        hkey_key="footer";
        RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
    } catch (e)
    {
    }
}
function printConirm()
{
    pagesetup_null();
    $(".print-info").wrap("<div class='print_wrap'></div>");
    $('body').html($('.print_wrap').html());
    window.print();
    location.reload();
}
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

