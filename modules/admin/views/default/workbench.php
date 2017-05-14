<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-md-6">
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 业务操作</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="#" class="btn btn-default">
                                <img src="http://tc.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                                购买墓位
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 门户操作</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="#" class="btn btn-default">
                                <img src="http://tc.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                                焦点图
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 系统管理</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="#" class="btn btn-default">
                                <img src="http://tc.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                                菜单管理
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 数据统计</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="#" class="btn btn-default">
                                <img src="http://tc.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                                销售
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 数据统计</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 工作任务</h4>

                        <div class="widget-toolbar no-border">
                            <ul class="nav nav-tabs" id="myTab2">
                                <li class="active">
                                    <a data-toggle="tab" href="#home2">今日</a>
                                </li>

                                <li class="">
                                    <a data-toggle="tab" href="#profile2">明日</a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#info2">昨日</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <div class="tab-content padding-4">

                                <div id="home2" class="tab-pane active">
                                    <div class="scrollable ace-scroll scroll-active">
                                        <div class="scroll-content">
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排11号</td>
                                                    <td width="50">
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排12号</td>
                                                    <td width="50">
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排13号</td>
                                                    <td width="50">
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排11号</td>
                                                    <td width="50">
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div id="profile2" class="tab-pane">
                                    <div class="scrollable ace-scroll">
                                        <div class="scroll-content">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead class="thin-border-bottom">
                                                <tr>
                                                    <th>
                                                        任务
                                                    </th>

                                                    <th width="50">

                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排12号</td>
                                                    <td>
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div id="info2" class="tab-pane">
                                    <div class="scrollable ace-scroll" >
                                        <div class="scroll-content">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead class="thin-border-bottom">
                                                <tr>
                                                    <th>
                                                        任务
                                                    </th>

                                                    <th width="50">

                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td class="">清扫颐安二十一4排13号</td>
                                                    <td>
                                                        <a href="#"><i class="fa fa-check"></i> </a>
                                                        <a href="#"><i class="fa fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 今日更新</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <ol>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 今日成交</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <ol>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                                <li>
                                    这里是一个新的blog <span>2017-01-02 12:12</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>