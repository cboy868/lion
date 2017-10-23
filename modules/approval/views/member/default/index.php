<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '我的审批';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');
Yii::$app->params['cur_nav'] = 'approval_index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新建审批', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 approval-index">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="no-border">
                            <?php $pros = \app\modules\approval\models\Approval::pros()?>
                            <?php $current=Yii::$app->request->get('pro');?>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!$current)echo'active'?>">
                                    <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                                </li>
                                <?php foreach ($pros as $k=>$pro): ?>
                                    <li class="<?php if($current == $k)echo'active'?>">
                                        <a href="<?=Url::toRoute(['index','pro'=>$k])?>" aria-expanded="true"><?=$pro?></a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="blog-post">
                    <?php $models = $dataProvider->getModels()?>
                    <?php foreach ($models as $model):?>
                        <div class="post-item">
                            <div style="float:right;line-height:30px; margin-right:10px">
                                <b style="color:green"><?=$model->pro?></b>
                            </div>
                            <div class="caption wrapper-lg">
                                <h2 class="post-title">
                                    <a href="<?=Url::toRoute(['view', 'id'=>$model->id])?>" target="_blank">
                                        <?=$model->title?>
                                    </a>
                                </h2>
                                <div class="post-sum">
                                    <?=Html::cutstr_html($model->intro,100)?>
                                </div>
                                <div class="line line-lg"></div>
                                <div class="text-muted">

                                    <?php if ($model->total>0):?>
                                    <i class="fa fa-money"></i>
                                        <?=$model->total?>
                                    <?php endif;?>

                                    <i class="fa fa-user icon-muted"></i>
                                    by <a class="m-r-sm" href="javascript:void(0"><?=$model->user->username?></a>
                                    <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm">
                                        <?=date('Y-m-d H:i', $model->created_at)?></span>


                                    <i class="fa fa-eye icon-muted"></i>
                                    <?= Html::a('查看', ['view', 'id'=>$model->id],['target'=>'_blank'] );?>
                                    <?php if ($model->progress == \app\modules\approval\models\Approval::PRO_BACK):?>
                                        <!--审批状态中的和审批完成的都不可删除-->
                                        <i class="fa fa-pencil icon-muted"></i>
                                        <?= Html::a('修改', ['update', 'id'=>$model->id]);?>

                                        <i class="fa fa-trash-o icon-muted"></i>
                                        <?= Html::a('删除',['delete', 'id'=>$model->id], [
                                            'data-confirm' => '您确定要删除此文章吗？',
                                            'data-method' => 'post'
                                        ])?>
                                    <?php endif;?>


                                </div>
                            </div>

                        </div>

                    <?php endforeach;?>
                </div>

                <footer class="panel-footer">
                    <div class="row">

                        <?php
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                            'nextPageLabel' => '>',
                            'prevPageLabel' => '<',
                            'lastPageLabel' => '尾页',
                            'firstPageLabel' => '首页',
                            'options' => [
                                'class' => 'pull-right pagination'
                            ]
                        ]);
                        ?>

                    </div>
                </footer>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>