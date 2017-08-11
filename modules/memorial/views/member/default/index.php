<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


$this->params['breadcrumbs'][] = '个人中心首页';
Yii::$app->params['cur_nav'] = 'memorial_index';
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>我创建的纪念馆

                <small>
                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/memorial/member/default/create'])?>">
                            <i class="fa fa-plus"></i>  创建纪念馆</a>
                    </div>
                </small>
            </h1>

        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <style>
                .dead{
                    float:left;
                    width:100px;
                }
                .dead a,table a{
                    color:#333;
                }
                .mem img{
                    float:left;
                }
                .mem ul{
                    float: left;
                    margin-left:10px;
                }
            </style>
            <div class="col-xs-12 memorial-index">
                <div class="table-responsive">
                    <?php $models = $dataProvider->getModels();?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>逝者</th>
                            <th>纪念馆信息</th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $model):?>
                        <tr>
                            <td width="450" class="mem">
                                <img src="<?=$model->getThumbImg('150x181')?>">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#" target="_blank">
                                            <h4><?=$model->title?></h4>
                                        </a>
                                    </li>
<!--                                    <li>馆     号：591539105</li>-->
                                    <li>是否公开：<span class="text-danger"><?=$model->privacyText?></span></li>
                                    <li>审核状态：<span class="text-success"><?=$model->statusText?></span></li>
                                    <li>建馆时间：<?=date('Y-m-d H:i', $model->created_at)?></li>
                                    <li>
                                        访问地址：<a href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->id])?>" target="_blank">
                                            <?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->id], true)?>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?php $deads = $model->notAliveDeads;?>
                                <?php if (is_array($deads)):?>
                                    <?php foreach ($deads as $dead):?>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                                <?=$dead->dead_name?>
                                        </div>
                                        <small class="text-muted">
                                            生 <?=$dead->birth?> <br>
                                            卒 <?=$dead->fete?>
                                        </small>
                                    </div>
                                </div>
                                        <?php endforeach;?>
                                <?php endif;?>

                            </td>

                            <td>

                                <div class="btn-group text-right">
                                    <p>
                                        <a href="<?=Url::toRoute(['/memorial/member/default/update', 'id'=>$model->id])?>" class="btn btn-sm btn-info">
                                            <span class="fa fa-user"></span> 管理
                                        </a>
                                    </p>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('tree') ?>
$(function(){


})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

