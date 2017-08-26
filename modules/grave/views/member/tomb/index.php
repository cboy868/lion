<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


Yii::$app->params['cur_nav'] = 'tomb_index';
$this->title = '购买的墓位';
$this->params['breadcrumbs'][] = ['label' => '个人中心首页', 'url' => ['/member']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>我购买原墓位

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
                            <th>墓位信息</th>
                            <th>逝者信息</th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $model):?>
                            <tr>
                                <td width="450" class="mem">
                                    <img src="<?=$model->getCover('150x181', '/static/images/default.png')?>">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#" target="_blank">
                                                <h4><?=$model->tomb_no?></h4>
                                            </a>
                                        </li>
                                        <li>墓位状态：<span class="text-success"><?=$model->statusText?></span></li>
                                        <li>购买时间：<?=$model->sale_time?></li>
                                    </ul>
                                </td>
                                <td>
                                    <?php $deads = $model->deads;?>
                                    <?php if (is_array($deads)):?>
                                        <?php foreach ($deads as $dead):?>
                                            <div class="dead">
                                                <img width="90" height="114" src="<?=$dead->getAvatarImg('170x210')?>" alt="">
                                                <div>
                                                    <div class="h4 m-t-xs m-b-xs">
                                                        <?=$dead->dead_name?>
                                                    </div>
                                                    <small class="text-muted">
                                                        生 <?=$dead->birth?> <br>
                                                        <?php if ($dead->fete):?>
                                                        卒 <?=$dead->fete?>
                                                        <?php endif;?>
                                                    </small>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </td>

                                <td>

                                    <div class="btn-group text-right">
                                        <p>
                                            <a href="<?=Url::toRoute(['/grave/member/tomb/tomb', 'id'=>$model->id])?>" class="btn btn-sm btn-info">
                                                <span class="fa fa-user"></span> 管理
                                            </a>
                                        </p>
                                        <?php if (isset($model->ins) && !$model->ins->is_confirm):?>
                                        <p>
                                            <a href="<?=Url::toRoute(['/grave/member/tomb/ins', 'id'=>$model->id])?>" class="btn btn-sm btn-danger">
                                                <span class="fa fa-check"></span> 碑文待确认
                                            </a>
                                        </p>
                                        <?php endif;?>

                                        <?php
                                            $flg = false;
                                            if (isset($model->portrait)){
                                                foreach ($model->portrait as $v){
                                                    if (!$v->confirm_by){
                                                        $flg = true;
                                                        break;
                                                    }
                                                }
                                            }

                                            if ($flg):
                                        ?>

                                        <p>
                                            <a href="<?=Url::toRoute(['/grave/member/tomb/portrait', 'id'=>$model->id])?>" class="btn btn-sm btn-danger">
                                                <span class="fa fa-check"></span> 瓷像待确认
                                            </a>
                                        </p>
                                        <?php endif;?>
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
