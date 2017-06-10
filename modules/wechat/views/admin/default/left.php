<?php
use yii\helpers\Url;
?>
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
            <!--
            <li class="list-group-item ">
                <a href="<?=Url::toRoute(['/wechat/admin/user/index'])?>" class="text-over">
                    <i class="fa fa-tags"></i>
                    标签管理
                </a>
            </li>
            -->
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
            <!--
            <li class="list-group-item ">
                <a href="" class="text-over">
                    <i class="fa fa-cog"></i>
                    参数配置											</a>
            </li>
            -->
        </ul>
    </div>
</div>