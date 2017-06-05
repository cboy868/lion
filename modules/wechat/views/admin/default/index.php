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
        <?= $this->render('../default/left');?>
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
