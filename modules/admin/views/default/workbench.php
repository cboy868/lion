<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .btn img{
        width:48px;
        height: 48px;
    }
    .widget-main .btn-default{
        border-radius: 20px;
        margin: 5px;
        width: 78px;
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
                                <img src="/static/images/icons/deal.png" class="fa-app">
                                业务办理
                            </a>
<!--                            <a href="#" class="btn btn-default">-->
<!--                                <img src="/static/images/icons/ashesroom.png" class="fa-app">-->
<!--                                骨灰堂-->
<!--                            </a>-->
                            <a href="<?=Url::toRoute('/client/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/realition.png" class="fa-app">
                                客户关系
                            </a>

                            <a href="<?=Url::toRoute('/task/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/task.png" class="fa-app">
                                任务
                            </a>
                            <a href="<?=Url::toRoute('/sms/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/sms.png" class="fa-app">
                                发短信
                            </a>

                            <a href="<?=Url::toRoute('/shop/admin/goods/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/shop.png" class="fa-app">
                                商品管理
                            </a>

                            <a href="<?=Url::toRoute('/grave/admin/bury/pre')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/prebury.png" class="fa-app">
                                预葬信息
                            </a>

                            <a href="<?=Url::toRoute('/analysis/admin/default/tomb')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/tongji.png" class="fa-app">
                                数据统计
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-list-alt"></i> 数据记录</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">

                            <a href="<?=Url::toRoute('/grave/admin/dead/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/dead.png" class="fa-app">
                                使用人
                            </a>

                            <a href="<?=Url::toRoute('/grave/admin/customer/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/customer.png" class="fa-app">
                                客户管理
                            </a>

                            <a href="<?=Url::toRoute('/grave/admin/bury/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/bury.png" class="fa-app">
                                安葬记录
                            </a>

                            <a href="<?=Url::toRoute('/grave/admin/ins/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/ins.png" class="fa-app">
                                碑文列表
                            </a>

                            <a href="<?=Url::toRoute('/grave/admin/portrait/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/portrait.png" class="fa-app">
                                瓷像列表
                            </a>
                            <a href="<?=Url::toRoute('/grave/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/grave.png" class="fa-app">
                                墓区列表
                            </a>
                            <a href="<?=Url::toRoute('/grave/admin/tomb/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/tomb.png" class="fa-app">
                                墓位列表
                            </a>
                            <a href="<?=Url::toRoute('/user/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/users.png" class="fa-app">
                                用户管理
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-home"></i> 门户操作</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="<?=Url::toRoute('/focus/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/focus.png" class="fa-app">
                                焦点图
                            </a>

                            <a href="<?=Url::toRoute('/cms/admin/links/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/friend.png" class="fa-app">
                                友情链接
                            </a>
                            <a href="<?=Url::toRoute('/news/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/news.png" class="fa-app">
                                新闻资讯
                            </a>
                            <a href="<?=Url::toRoute('/blog/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/blog.png" class="fa-app">
                                博客
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/subject/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/special.png" class="fa-app">
                                专题
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/favor/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/fav.png" class="fa-app">
                                收藏
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-gears"></i> 系统管理</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="<?=Url::toRoute('/sys/admin/menu/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/menu.png" class="fa-app">
                                菜单
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/auth-permission/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/permission.png" class="fa-app">
                                权限管理
                            </a>
                            <a href="<?=Url::toRoute('/mod/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/modules.png" class="fa-app">
                                模块管理
                            </a>
                            <a href="<?=Url::toRoute('/grave/admin/ins-cfg/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/tpl.png" class="fa-app">
                                碑文模板
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/set.png" class="fa-app">
                                基础设置
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/backup/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/backup.png" class="fa-app">
                                数据备份
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/image/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/setpic.png" class="fa-app">
                                图片设置
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/nav/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/nav.png" class="fa-app">
                                门户导航
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-bar-chart"></i> 数据统计</h4>
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
                        <h4 class="widget-title lighter"><i class="fa fa-tasks"></i> 工作任务</h4>

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
                        <h4 class="widget-title lighter"><i class="fa fa-newspaper-o"></i> 今日更新</h4>
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
                        <h4 class="widget-title lighter"><i class="fa fa-gavel"></i> 今日成交</h4>
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