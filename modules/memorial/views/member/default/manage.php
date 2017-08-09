<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


$this->params['breadcrumbs'][] = '纪念馆管理';

?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <style>
                .dead{
                    float:left;
                    width:170px;
                }
                .dead a,table a{
                    color:#333;
                }
            </style>

            <div class="col-xs-2">
                <div class="list-group no-radius no-border no-bg ">
                    <a href="#" class="list-group-item active">基本信息</a>
                    <a href="#" class="list-group-item">逝者资料</a>
                    <a href="#" class="list-group-item ">档案资料</a>
<!--                    <a href="#" class="list-group-item">模板设置</a>-->
                    <a href="#" class="list-group-item">追忆文章</a>
                    <a href="#" class="list-group-item">回忆相册</a>
                    <a href="#" class="list-group-item">祝福管理</a>
                </div>
            </div>

            <div class="col-xs-10 memorial-index">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>逝者</th>
                            <th>纪念馆信息</th>
                            <th style="width:80px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="300">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="/TT591539105" target="_blank">
                                            <h4>江清月</h4>
                                        </a>
                                    </li>
                                    <li>馆     号：591539105</li>
                                    <li>是否公开：<span class="text-danger">是</span></li>
                                    <li>审核状态：<span class="text-success">新添加</span></li>
                                    <li>建馆时间：2017-08-08 20:32:41</li>
                                    <li>
                                        访问地址：<a href="#" target="_blank">
                                            http://www.5201000.com/TT591539105
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            2016/01/01
                                            —
                                            2016/01/01
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>






                            </td>

                            <td>

                                <div class="btn-group text-right">
                                    <p>
                                        <a href="" class="btn btn-sm btn-info">
                                            <span class="fa fa-user"></span> 管理
                                        </a>
                                    </p>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td width="300">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="/TT591539105" target="_blank">
                                            <h4>江清月</h4>
                                        </a>
                                    </li>
                                    <li>馆     号：591539105</li>
                                    <li>是否公开：<span class="text-danger">是</span></li>
                                    <li>审核状态：<span class="text-success">新添加</span></li>
                                    <li>建馆时间：2017-08-08 20:32:41</li>
                                    <li>
                                        访问地址：<a href="#" target="_blank">
                                            http://www.5201000.com/TT591539105
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            2016/01/01
                                            —
                                            2016/01/01
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>
                                <div class="dead">
                                    <img width="90" height="114" src="http://www.5201000.com/Resource/Images/Default/ren-pic.jpg" alt="">
                                    <div>
                                        <div class="h4 m-t-xs m-b-xs">
                                            <a href="/TT591539105" target="_blank">
                                                江清月
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-quote-left"></i>
                                            日期不详
                                            —
                                            日期不详
                                        </small>
                                    </div>
                                </div>






                            </td>

                            <td>

                                <div class="btn-group text-right">
                                    <p>
                                        <a href="" class="btn btn-sm btn-info">
                                            <span class="fa fa-user"></span> 管理
                                        </a>
                                    </p>
                                </div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('tree') ?>
$(function(){

$("#menu-table").treetable({ expandable: true });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

