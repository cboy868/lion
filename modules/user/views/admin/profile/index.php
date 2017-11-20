<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;
$this->params['profile_nav'] = 'user';
?>
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
    <div class="col-sm-12">
        <!-- user profile start -->
                <!-- person panel nav -->
                <ul class="nav nav-tabs padding-18">
                    <?=$this->render('@app/modules/user/views/admin/profile/nav');?>
                </ul>

                <!-- content -->
                <div class="tab-content padding-12">
                    <div class="tab-pane active">

                        <!-- 提示信息 start -->
                        <!-- 提示信息 end

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a href="#" class="btn btn-success btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    写笔记
                                </a>
                                <a href="#" class="btn btn-info btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    写案例</a>
                                <a href="#" class="btn btn-warning btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    个人总结</a>
                                <a href="#" class="btn btn-success btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    提交审批
                                </a>
                                <a href="/admin/oagoods/addguide" class="btn btn-success btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    申领物品</a>
                                <a href="#" class="btn btn-default btn-xs radius4">
                                    <i class="fa fa-edit"></i>
                                    写请假条</a>
                                <hr>
                            </div>
                        </div>
-->
                        <div class="row">
                            <!-- 个人信息 -->
                            <div class="col-xs-12 col-md-12 widget-container-span ui-sortable">
                                <div class="widget-box">
                                    <h3 class="header smaller lighter blue2">
                                        <i class="fa fa-user"></i>
                                        个人信息
                                    </h3>

                                    <table class="table noborder">
                                        <tr>
                                            <th>账号</th>
                                            <td><?=$model->username?></td>
                                            <td rowspan="6">
                                                <img class="img-responsive thumbnail" src="<?=$model->getAvatar('121x121')?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>真实姓名</th>
                                            <td><?=$addition->real_name?></td>
                                        </tr>
                                        <tr>
                                            <th>手机号</th>
                                            <td><?=$model->mobile?></td>
                                        </tr>
                                        <tr>
                                            <th>邮箱</th>
                                            <td><?=$model->email?></td>
                                        </tr>
                                        <tr>
                                            <th>上次登录时间</th>
                                            <td><code><?=$log->login_date?></code></td>
                                        </tr>
                                        <tr>
                                            <th>上次登录ip</th>
                                            <td><code><?=$log->login_ip?></code></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                <a class="btn btn-info btn-xs radius4" target="_blank"
                                                   href="<?=Url::toRoute(['/user/admin/profile/update'])?>">修改资料</a>
                                            </th>
                                        </tr>
                                    </table>
                                </div>

                            </div><!-- /span --><!-- 第一个 -->

                        </div>
                    </div>
                </div>
                <!-- content end -->
    </div>
        </div>
    </div>
</div>
