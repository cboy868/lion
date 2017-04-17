<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model modules\wechat\models\Wechat */
$this->title="公众号列表";
$this->params['breadcrumbs'][] = '公众号管理';
?>
<style type="text/css">
    div.page-header span.active{
            border-bottom: 2px solid #2679b5;
            padding-bottom: 15px;
    }

    div.page-header span a:hover{
        padding-bottom: 15px;
        border-bottom: 2px solid #2679b5;
        text-decoration: none;
    }
    div.page-header span a{
        color:#2679b5
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <span class="active">
                <?= Html::encode($this->title) ?>
                </span>
                <span>
                    <a href="<?=Url::toRoute(['recycle'])?>">公众号回收站</a>
                </span>
                <small>
                    <a href="#" class="btn btn-info">添加公众号</a>
                </small>
                
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        
                <div class="wechat-search">

                    <form id="w0" class="form-inline" action="/admin/user/default/index" method="get">

                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search for...">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button">搜索</button>
                          </span>
                        </div><!-- /input-group -->
                    </form>
                </div>
                </div>
            </div>

            <div class="col-xs-12">
                    <div id="w1" class="grid-view">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th><a href="/admin/user/default/index.html?sort=id" data-sort="id">账号</a></th>
                                <th class="action-column">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding:5px;">
                                    <img src="/upload/static/images/40x40@default.png" style="display: block;margin: 10px" class="pull-left">
                                    <div class="pull-left">
                                        <p>we7team</p>
                                        <p>类型：普通订阅号 <span style="color:red">未接入</span></p>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/user/default/view.html?id=1">进入公众号</a> 
                                    <a href="/admin/user/default/update.html?id=1">管理设置</a> 
                                    <a href="/admin/user/default/delete.html?id=1">停用</a>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:5px;">
                                    <img src="/upload/static/images/40x40@default.png" style="display: block;margin: 10px" class="pull-left">
                                    <div class="pull-left">
                                        <p>we7team</p>
                                        <p>类型：普通订阅号 <span style="color:red">未接入</span></p>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/user/default/view.html?id=1">进入公众号</a> 
                                    <a href="/admin/user/default/update.html?id=1">管理设置</a> 
                                    <a href="/admin/user/default/delete.html?id=1">停用</a>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:5px;">
                                    <img src="/upload/static/images/40x40@default.png" style="display: block;margin: 10px" class="pull-left">
                                    <div class="pull-left">
                                        <p>we7team</p>
                                        <p>类型：普通订阅号 <span style="color:red">未接入</span></p>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/user/default/view.html?id=1">进入公众号</a> 
                                    <a href="/admin/user/default/update.html?id=1">管理设置</a> 
                                    <a href="/admin/user/default/delete.html?id=1">停用</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>                
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
