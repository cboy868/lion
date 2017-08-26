<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


$this->params['breadcrumbs'][] = '个人中心首页';
Yii::$app->params['cur_nav'] = 'member_index';
?>
<style type="text/css">
    .nc{margin-right: 10px;}
    .badge {
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #777;
        border-radius: 10px;
    }
    .panel-msg{
        background: #35A996;
    }
    .panel-msg a{
        color: white;
        font-size: 20px;
    }

    .panel-heading{
        padding:8px 15px;
    }
    ul.memorial-body{
        list-style: none;
        margin:0;
        padding:0;
    }
    .memorial-body a{
        color:#666;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>欢迎回来，<?=Yii::$app->user->identity->username;?></h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-info panel-msg">
                    <div class="panel-body">
                        <div style="float:left;color:white">
                            <i class="fa fa-bell-o fa-3x"></i>
                        </div>
                        <a style="float: left" href="#">
                            <p><i class="badge">12</i></p>
                            <p>条未读消息</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-success">
                    <div class="panel-heading">我创建的纪念馆</div>
                    <div class="panel-body">
                        <ul class="memorial-body">

                            <?php foreach ($memorial as $v):?>
                            <li>
                                <a href="<?=Url::toRoute(['/memorial/member/default/update', 'id'=>$v->id])?>" target="_blank"><?=$v->title?>
                                    <div class="pull-right">
                                        <i><?= date('Y-m-d', $v->created_at)?></i>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">购买的墓位</div>
                    <div class="panel-body">
                        <ul class="memorial-body">
                            <?php foreach ($tomb as $v):?>
                            <li>
                                <a href="<?=Url::toRoute(['/grave/member/tomb/tomb', 'id'=>$v->id])?>" target="_blank"><?=$v->tomb_no?>
                                    <div class="pull-right">
                                        <i><?=$v->sale_time?></i>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.page-content-area -->
</div>


