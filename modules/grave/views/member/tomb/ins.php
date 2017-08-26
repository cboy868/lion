<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;


$this->title = '碑文信息';
$this->params['breadcrumbs'][] = ['label' => '墓位信息', 'url' => ['index']];
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

            <?=$this->render('left-menu', ['cur'=>'ins', 'model'=>$tomb])?>


            <div class="col-xs-10 memorial-index">
                <?=\app\core\widgets\Alert::widget();?>
                <?php if ($tomb->ins):?>
                    <?php $ins = $tomb->ins;?>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>墓位号</th>
                        <td><?=$tomb->tomb_no?></td>
                        <th>确认人</th>
                        <td>
                            <?php if ($ins->is_confirm):?>
                                <?=$ins->confirm->username?>
                            <?php else:?>
                                碑文未确认
                            <?php endif;?>

                        </td>
                        <th>确认时间</th>
                        <td>
                            <?=$ins->confirm_date?>
                        </td>
                    </tr>
                    <tr>
                        <th>碑文图片</th>
                        <td colspan="5">
                            <div class="gt_con">
                                <p class="pull-left" style="margin-right:20px;">
                                    <a href="<?=$ins->getFront()?>" class="artimg">
                                        <img class="image" title="前碑文" width="180" src="<?=$ins->getFront()?>">
                                    </a>
                                </p>

                                <p class="pull-left">
                                    <a href="<?=$ins->getBack()?>" class="artimg">
                                        <img class="image" title="后碑文" width="180" src="<?=$ins->getFront()?>" alt="...">
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td colspan="4">
                            <?php
                            $diff = ceil((strtotime($ins->pre_finish) - time() - 3*86400)/86400);
                            if ($diff<0) {
                                $diff = 0;
                            }
                            ?>
                            请及时核对碑文样式，您还有 <b><?=$diff?></b> 天时间来核对,如正确，请点确认，有问题请联系服务人员
                        </td>
                        <td>

                            <p>
                                <?php if ($ins->is_confirm):?>
                                    <p>已确认</p>
                                <?php else:?>
                                    <a href="<?=Url::toRoute(['confirm-ins','id'=>$ins->id])?>"  class="confirmIns btn btn-success btn-xs">确认</a>
                                <?php endif?>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php else:?>
                    <h3 style="color:#666">暂无碑文</h3>
                <?php endif;?>

                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>



<?php $this->beginBlock('customer') ?>

    $(function () {
        $('.confirmIns').click(function (e) {
            if (!confirm('碑文确认后，工作人员将开始制作，请您一定要仔细核对')) {
                return false;
            }
        });
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>



