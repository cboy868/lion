<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

\app\assets\ColorBoxAsset::register($this);

$this->title = '修改纪念馆基本信息';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <?= \app\core\widgets\Alert::widget()?>
    <div class="page-content-area">
        <div class="row">
            <style>
                .dead{
                    float:left;
                    width:170px;
                }
                .dead a,table a{
                    color:#333;
                }
            </style>

            <?=$this->render('left-menu', ['cur'=>'portrait', 'model'=>$tomb])?>

            <div class="col-xs-10 memorial-index">
                <?=\app\core\widgets\Alert::widget();?>
                <?php if ($tomb->portrait):?>
                    <?php $portraits = $tomb->portrait;?>

                    <?php foreach ($portraits as $portrait):?>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>墓位号</th>
                            <td><?=$tomb->tomb_no?></td>
                            <th>确认人</th>
                            <td>
                                <?php if ($portrait->photo_confirm):?>
                                    <?=$portrait->confirm->username?>
                                <?php else:?>
                                    瓷像未确认
                                <?php endif;?>

                            </td>
                            <th>确认时间</th>
                            <td>
                                <?=$portrait->confirm_at?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="pull-left">
                                    <h5>原照片</h5>
                                    <div class="gt_con">
                                        <p class="pull-left" style="margin-right:20px;">
                                            <a href="<?=$portrait->getOriginalImg()?>" class="artimg">
                                                <img class="image" title="原照片" width="180" src="<?=$portrait->getOriginalImg()?>">
                                            </a>
                                        </p>

                                    </div>
                                </div>

                                <div class="pull-left">
                                    <h5>修改后</h5>
                                    <div class="gt_con">
                                        <p class="pull-left">
                                            <a href="<?=$portrait->getProcessedImg()?>" class="artimg">
                                                <img class="image" title="修改后照片" width="180" src="<?=$portrait->getProcessedImg()?>" alt="...">
                                            </a>
                                        </p>
                                    </div>
                                </div>

                            </td>

                        </tr>
                        <tr>
                            <td colspan="5">
                                <?php
                                $diff = ceil((strtotime($portrait->use_at) - time() - 3*86400)/86400);
                                if ($diff<0) {
                                    $diff = 0;
                                }
                                ?>
                                请及时审阅瓷像照片，您还有 <b><?=$diff?></b> 天时间来核对,如满意，请点确认，有问题请联系服务人员
                            </td>
                            <td>

                                <p>
                                    <?php if ($portrait->status >= \app\modules\grave\models\Portrait::STATUS_CONFIRM):?>
                                <p>已确认</p>
                                <?php else:?>
                                    <a href="<?=Url::toRoute(['confirm-portrait','id'=>$portrait->id])?>"
                                       class="confirmPortrait btn btn-success btn-lg">确 认</a>
                                <?php endif?>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <?php endforeach;?>
                <?php else:?>
                    <h3 style="color:#666">暂无瓷像</h3>
                <?php endif;?>

                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>



<?php $this->beginBlock('customer') ?>
$(function () {
    $('.confirmPortrait').click(function (e) {
        if (!confirm('瓷像确认后，工作人员将开始制作，请您一定要仔细核对')) {
            return false;
        }
    });
    $(".image").click(function(e) {
        e.preventDefault();
        var title = $(this).attr('title');
        $(".artimg").colorbox({
            rel: 'artimg',
            maxWidth:'600px',
            maxHeight:'700px',
            next:'',
            previous:'',
            close:'',
            current:""
        });
    });


})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>



