<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '微信菜单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/static/wechat/css/common.css">
<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <div class="content-head panel-heading">
                <img src="/static/wechat/images/nopic-107.png" class="head-logo">
                <span class="font-lg"><?=$wechat->name?></span>
                <span class="label label-primary"><?=$wechat->levelLabel?></span>
                <span class="pull-right">
                    <a href="#"><i class="wi wi-appsetting"></i>公众号设置</a>
                </span>
<!--                <span class="pull-right">-->
<!--                    <a href="#" target="_blank"><i class="wi wi-iphone"></i>模拟测试</a>-->
<!--                </span>-->
            </div>
        </div><!-- /.page-header -->

<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">
        <div class="right-content">
            <div class="clearfix ng-scope" ng-controller="menuDisplay">
                <ul class="we7-page-tab">
                    <li class="active"><a href="./index.php?c=platform&amp;a=menu&amp;type=1">默认菜单</a></li>
                    <li><a href="./index.php?c=platform&amp;a=menu&amp;type=3">个性化菜单</a></li>
                </ul>
                <div class="we7-padding-bottom clearfix">
                    <form action="./index.php" method="get" class="form-horizontal ng-pristine ng-valid" role="form">
                        <div class="input-group pull-left col-sm-4">
                            <input type="text" name="keyword" id="" value="" class="form-control" placeholder="搜索关键字">
                            <span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                        </div>
                    </form>
                    <div class="pull-right">
                        <a href="<?=Url::toRoute(['create'])?>" class="btn btn-primary we7-padding-horizontal">+添加默认菜单</a>
                    </div>
                </div>
                <table class="table we7-table table-hover">
                    <colgroup><col width="200px">
                        <col>
                        <col width="180px">
                        <col width="220px">
                    </colgroup><tbody><tr>
                        <th class="text-left">菜单组名</th>
                        <th class="text-left">显示对象</th>
                        <th>
                            是否在微信生效
                            <div class="color-gray">(只能生效一个默认菜单)</div>			</th>
                        <th class="text-left">操作</th>
                    </tr>
                    <tr>
                        <td class="text-left">
                            默认菜单_5							</td>
                        <td class="text-left">
                            所有粉丝
                        </td>
                        <td>
                            <span class="color-green">菜单生效中</span>

                        </td>
                        <td class="text-left">
                            <a href="./index.php?c=platform&amp;a=menu&amp;do=post&amp;id=5&amp;type=1" class="color-default we7-margin-right">编辑</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            默认菜单_3							</td>
                        <td class="text-left">
                            所有粉丝
                        </td>
                        <td>
                            <a href="javascript:;" class="js-switch-3 color-default" data-id="3" data-status="0" ng-click="changeStatus(3, 0, 1)">生效并置顶</a>

                        </td>
                        <td class="text-left">
                            <a href="<?=Url::toRoute(['update'])?>" class="color-default we7-margin-right">编辑</a>
                            <a href="<?=Url::toRoute(['delete'])?>" class="color-default" onclick="if(!confirm('删除默认菜单会清空所有菜单记录，确定吗？')) return false;">删除</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            默认菜单_1							</td>
                        <td class="text-left">
                            所有粉丝
                        </td>
                        <td>
                            <a href="javascript:;" class="js-switch-1 color-default" data-id="1" data-status="0" ng-click="changeStatus(1, 0, 1)">生效并置顶</a>

                        </td>
                        <td class="text-left">
                            <a href="./index.php?c=platform&amp;a=menu&amp;do=post&amp;id=1&amp;type=1" class="color-default we7-margin-right">编辑</a>
                            <a href="./index.php?c=platform&amp;a=menu&amp;do=delete&amp;id=1&amp;status=history" class="color-default" onclick="if(!confirm('删除默认菜单会清空所有菜单记录，确定吗？')) return false;">删除</a>
                        </td>
                    </tr>
                    </tbody></table>
                <div class="pull-right">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>