<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '我的审批';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');
Yii::$app->params['cur_nav'] = 'approval_pi';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php echo $this->render('_searchStep', ['model' => $searchModel]); ?>
                </div>
            </div>

            <?php
            Modal::begin([
                'header' => '打回备注',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
            ?>

            <?php
            Modal::begin([
                'header' => '通过备注',
                'id' => 'modalEdit',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
            ?>

            <div class="col-xs-12 approval-index">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="no-border">
                            <?php $current=Yii::$app->request->get('pro');?>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!$current)echo'active'?>">
                                    <a href="<?=Url::toRoute(['pi'])?>" aria-expanded="true">全部</a>
                                </li>
                                <li class="<?php if($current == 1)echo'active'?>">
                                    <a href="<?=Url::toRoute(['pi','pro'=>1])?>" aria-expanded="true">待审批</a>
                                </li>
                                <li class="<?php if($current == -1)echo'active'?>">
                                    <a href="<?=Url::toRoute(['pi','pro'=>-1])?>" aria-expanded="true">打回历史</a>
                                </li>
                                <li class="<?php if($current == 2)echo'active'?>">
                                    <a href="<?=Url::toRoute(['pi','pro'=>2])?>" aria-expanded="true">通过历史</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="blog-post">
                    <?php $models = $dataProvider->getModels()?>
                    <?php foreach ($models as $model):?>
                        <?php $approval = $model->approval;?>
                        <div class="post-item">
                            <?php if ($model->progress == 1): ?>
                            <div style="float:right;line-height:30px; margin-right:10px">
                                <b style="color:green">
                                    <a href="<?=Url::toRoute(['deal', 'id'=>$model->id, 'pro'=>2])?>"
                                       class="modalEditButton"
                                       data-loading-text="页面加载中, 请稍后..."
                                       onclick="return false"
                                    >审批通过</a>
                                </b>
                                <b style="color:red">
                                    <a href="<?=Url::toRoute(['deal', 'id'=>$model->id, 'pro'=>-1])?>"
                                       class="modalAddButton"
                                       data-loading-text="页面加载中, 请稍后..."
                                       onclick="return false"
                                    >打回</a>
                                </b>
                            </div>
                            <?php endif;?>
                            <div class="caption wrapper-lg">
                                <h2 class="post-title">
                                    <a href="<?=Url::toRoute(['view', 'id'=>$approval->id])?>" target="_blank">
                                        <?=$approval->title?>
                                    </a>
                                    <small>
                                        <?=$model->step_name?>

                                    </small>
                                </h2>
                                <div class="post-sum">
                                    <?=Html::cutstr_html($approval->intro,100)?>
                                </div>


                                <div class="line line-lg"></div>
                                <div class="text-muted">

                                    <?php if ($approval->total>0):?>
                                        <i class="fa fa-money"></i>
                                        <?=$approval->total?>
                                    <?php endif;?>

                                    <i class="fa fa-user icon-muted"></i>
                                    审批人 <a class="m-r-sm" href="javascript:void(0"><?=$approval->user->username?></a>
                                    <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm">
                                        <?=date('Y-m-d H:i', $approval->created_at)?></span>

                                    <i class="fa fa-eye icon-muted"></i>
                                    <?= Html::a('查看', ['view', 'id'=>$approval->id],['target'=>'_blank'] );?>

                                    <?php if ($model->progress!=1): ?>
                                        状态: <span style="color:green;"><?=$model->pro?></span>  备注:<?=$model->note?>
                                    <?php endif;?>

                                </div>
                            </div>

                        </div>

                    <?php endforeach;?>
                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
