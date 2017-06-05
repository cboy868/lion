<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model modules\wechat\models\Wechat */
$this->title="公众号列表";
$this->params['breadcrumbs'][] = '公众号管理';
?>
<link rel="stylesheet" href="/css/wechat.css">
<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">
        <div class="left-menu">
            <div class="panel panel-menu">
                <div class="panel-heading">
                    基础功能
                </div>
                <ul class="list-group">
                    <li class="list-group-item ">
                        <a href="<?=Url::toRoute(['/wechat/admin/menu/index'])?>" class="text-over">
                            <i class="fa fa-list"></i>
                            自定义菜单
                        </a>
                    </li>

<!--
                    <li class="list-group-item ">
                        <a href="#" class="text-over">
                            <i class="fa fa-commenting-o"></i>
                            自动回复
                        </a>
                    </li>

                    <li class="list-group-item ">
                        <a href="#" class="text-over">
                            <i class="fa fa-qrcode"></i>
                            二维码/短网址
                        </a>
                    </li>
                    <li class="list-group-item ">
                        <a href="#" class="text-over">
                            <i class="fa fa-pencil"></i>
                            素材
                        </a>
                    </li>
                    <li class="list-group-item ">
                        <a href="#" class="text-over">
                            <i class="fa fa-clock-o"></i>
                            定时群发
                        </a>
                    </li>
-->
                </ul>
            </div>
            <!--
            <div class="panel panel-menu">
                <div class="panel-heading">
                    应用模块<span class="wi wi-appsetting pull-right setting"></span>
                </div>
                <ul class="list-group">
                    <li class="list-group-item ">
                        <a href="#" class="text-over" target="_blank">
                            <img src="#">
                            全国WI-FI
                        </a>
                    </li>

                    <li class="list-group-item list-group-more">
                        <a href="./index.php?c=profile&amp;a=module&amp;" target="_blank"><span class="label label-more">更多应用</span></a>
                    </li>
                </ul>
            </div>
            -->
            <div class="panel panel-menu">
                <div class="panel-heading">
                    粉丝
                </div>
                <ul class="list-group">
                    <li class="list-group-item ">
                        <a href="<?=Url::toRoute(['/wechat/admin/user/index'])?>" class="text-over">
                            <i class="fa fa-heart"></i>
                            粉丝管理
                        </a>
                    </li>
                    <li class="list-group-item ">
                        <a href="<?=Url::toRoute(['/wechat/admin/user/index'])?>" class="text-over">
                            <i class="fa fa-tags"></i>
                            标签管理
                        </a>
                    </li>
                </ul>
            </div>
            <div class="panel panel-menu">
                <div class="panel-heading">
                    配置<span class="wi wi-appsetting pull-right setting"></span>
                </div>
                <ul class="list-group">
                    <li class="list-group-item ">
                        <a href="<?=Url::toRoute(['/wechat/admin/account/index'])?>" class="text-over">
                            <i class="fa fa-list-ol"></i>
                            公众号列表											</a>
                    </li>
                    <li class="list-group-item ">
                        <a href="" class="text-over">
                            <i class="fa fa-cog"></i>
                            参数配置											</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="right-content">
            <div class="welcome-container ng-scope" id="js-home-welcome" ng-controller="WelcomeCtrl">
                <div class="panel zx-panel account-stat">
                    <div class="panel-heading">今日关键指标</div>
                    <div class="panel-body zx-padding-vertical">
                        <div class="col-sm-3 text-center">
                            <div class="title">今日新关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.today.new">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">今日取消关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.today.cancel">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">今日净增关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.today.jing_num">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">累计关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.today.cumulate">4</div>
                        </div>
                    </div>
                </div>
                <div class="panel zx-panel account-stat">
                    <div class="panel-heading">昨日关键指标</div>
                    <div class="panel-body zx-padding-vertical">
                        <div class="col-sm-3 text-center">
                            <div class="title">昨日新关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.yesterday.new">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">昨日取消关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.yesterday.cancel">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">昨日净增关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.yesterday.jing_num">0</div>
                        </div>
                        <div class="col-sm-3 text-center">
                            <div class="title">累计关注</div>
                            <div class="num ng-binding" ng-init="0" ng-bind="fans_kpi.yesterday.cumulate">4</div>
                        </div>
                    </div>
                </div>

                <div class="panel zx-panel notice">
                    <div class="panel-heading">
                        公告
                        <a href="./index.php?c=article&amp;a=notice-show" target="_blank" class="pull-right color-default">更多</a>
                    </div>
                    <ul class="list-group">
                        <script type="text/javascript" src="http://bbs.zx.cc/api.php?mod=js&amp;bid=10"></script>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
