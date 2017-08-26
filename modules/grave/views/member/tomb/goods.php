<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = '墓位商品购买记录';
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

            <?=$this->render('left-menu', ['cur'=>'goods', 'model'=>$tomb])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>

                <div class="row masonry">
                    <?php $rels = $dataProvider->getModels()?>
                    <?php foreach ($rels as $k => $rel):?>

                        <?php if (!$rel->goods) continue; ?>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                            <div class="item panel panel-default wrapper-sm">
                                <div class="pos-rlt" style="text-align: center">
                                    <div style="height: 200px;display: inline-block" >
                                        <img style="max-width: 100%;max-height: 100%;" class="album-img"
                                             alt="" src="<?=$rel->goods->getThumb('690x430')?>">
                                    </div>
                                </div>
                                <div class="padder-h text-center">
                                    <h4 class="h4 m-b-sm"><?=$rel->title?> </h4>
                                    <i class="fa fa-clock-o icon-muted"></i> 日期:<?=date('Y-m-d H:i',$rel->created_at)?>

                                    <i class="fa fa-clock-o icon-muted"></i> 数量:<?=$rel->num?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>



                <footer class="panel-footer">
                    <div class="row">
                        <?php
//                        echo LinkPager::widget([
//                            \'pagination\' => //$dataProvider->getPagination(),
//                            \'nextPageLabel\' => \'>\',
//                            \'prevPageLabel\' => \'<\',
//                            \'lastPageLabel\' => \'尾页\',
//                            \'firstPageLabel' => '首页',
//                            'options' => [
//                                'class' => 'pull-right pagination'
//                            ]
//                        ]);
                        ?>

                    </div>
                </footer>



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>



<?php $this->beginBlock('customer') ?>

$(function () {

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>



