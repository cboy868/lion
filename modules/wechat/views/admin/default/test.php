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
                        增强功能<span class="wi wi-appsetting pull-right setting"></span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item ">
                            <a href="./index.php?c=platform&amp;a=reply&amp;" class="text-over">
                                <i class="wi wi-reply"></i>
                                自动回复											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=platform&amp;a=menu&amp;" class="text-over">
                                <i class="wi wi-custommenu"></i>
                                自定义菜单											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=platform&amp;a=qr&amp;" class="text-over">
                                <i class="wi wi-qrcode"></i>
                                二维码/转化链接											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=platform&amp;a=mass&amp;" class="text-over">
                                <i class="wi wi-crontab"></i>
                                定时群发											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=platform&amp;a=material&amp;" class="text-over">
                                <i class="wi wi-redact"></i>
                                素材/编辑器											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=site&amp;a=multi&amp;do=display&amp;" class="text-over">
                                <i class="wi wi-home"></i>
                                微官网											</a>
                        </li>
                    </ul>
                </div>
                <div class="panel panel-menu">
                    <div class="panel-heading">
                        应用模块<span class="wi wi-appsetting pull-right setting"></span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item ">
                            <a href="./index.php?c=home&amp;a=welcome&amp;do=ext&amp;m=wqtgd_wifi" class="text-over" target="_blank">
                                <img src="http://tc.ibagou.com/addons/wqtgd_wifi/icon.jpg">
                                全国WI-FI											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=home&amp;a=welcome&amp;do=ext&amp;m=wzk_tmpl" class="text-over" target="_blank">
                                <img src="http://tc.ibagou.com/addons/wzk_tmpl/icon.jpg">
                                模板消息－不限次数发送											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=home&amp;a=welcome&amp;do=ext&amp;m=we7_wmall" class="text-over" target="_blank">
                                <img src="http://tc.ibagou.com/addons/we7_wmall/icon.jpg">
                                微派送|外卖|便利店|超市系统											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=home&amp;a=welcome&amp;do=ext&amp;m=we7_coupon" class="text-over" target="_blank">
                                <img src="http://tc.ibagou.com/addons/we7_coupon/icon.jpg">
                                系统卡券											</a>
                        </li>
                        <li class="list-group-item list-group-more">
                            <a href="./index.php?c=profile&amp;a=module&amp;" target="_blank"><span class="label label-more">更多应用</span></a>
                        </li>
                    </ul>
                </div>
                <div class="panel panel-menu">
                    <div class="panel-heading">
                        粉丝<span class="wi wi-appsetting pull-right setting"></span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item ">
                            <a href="./index.php?c=mc&amp;a=fans&amp;" class="text-over">
                                <i class="wi wi-fansmanage"></i>
                                粉丝管理											</a>
                        </li>
                        <li class="list-group-item ">
                            <a href="./index.php?c=mc&amp;a=member&amp;" class="text-over">
                                <i class="wi wi-fans"></i>
                                会员管理											</a>
                        </li>
                    </ul>
                </div>
                <div class="panel panel-menu">
                    <div class="panel-heading">
                        配置<span class="wi wi-appsetting pull-right setting"></span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item ">
                            <a href="./index.php?c=profile&amp;a=passport&amp;" class="text-over">
                                <i class="wi wi-parameter-stting"></i>
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

                    <div class="panel zx-panel apply-list">
                        <div class="panel-heading">
                            最新发布应用
                            <a href="http://s.we7.cc" target="_blank" class="pull-right color-default">查看更多应用</a>
                        </div>
                        <div class="panel-body text-center" ng-class="{'zx-margin-vertical': !last_modules}">
                            <!-- ngIf: !last_modules && loaderror == 0 -->
                            <!-- ngIf: !last_modules && loaderror == 1 -->
                            <!-- ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4429.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4429.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/ARb48i1933EQs3ER592940dbbc562.jpg" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/ARb48i1933EQs3ER592940dbbc562.jpg">
                                <span class="text-over ng-binding" ng-bind="module.title">Bingo大屏幕</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4428.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4428.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/14958756115929401bc5972_lXZu2sWF5ZxA.jpg" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/14958756115929401bc5972_lXZu2sWF5ZxA.jpg">
                                <span class="text-over ng-binding" ng-bind="module.title">微信运动小助手</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4426.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4426.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/1495869095592926a7884b5_yEB9r9IkK000.png" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/1495869095592926a7884b5_yEB9r9IkK000.png">
                                <span class="text-over ng-binding" ng-bind="module.title">黄河·小程序卡券</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4424.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4424.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/l330QqOOw8NJ3hHw5929088905a8e.jpg" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/l330QqOOw8NJ3hHw5929088905a8e.jpg">
                                <span class="text-over ng-binding" ng-bind="module.title">提货卡微信核销</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4421.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4421.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/jnUI4I7iPIiHiU555928ecfecefcc.jpg" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/27/jnUI4I7iPIiHiU555928ecfecefcc.jpg">
                                <span class="text-over ng-binding" ng-bind="module.title">云分销</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4417.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4417.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/26/149580926859283cf494efb_wB1nBF11bdb3.png" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/26/149580926859283cf494efb_wB1nBF11bdb3.png">
                                <span class="text-over ng-binding" ng-bind="module.title">雪怪跑酷[驽马小游戏]</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><a ng-href="http://s.we7.cc/module-4415.html" target="_blank" ng-if="last_modules &amp;&amp; module.logo &amp;&amp; $index+1 < 8" class="apply-item ng-scope" ng-repeat="module in last_modules" href="http://s.we7.cc/module-4415.html">
                                <img ng-src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/26/14957898385927f10e6b879_U88WRrR8b99r.jpg" src="http://we7cloud-10016060.file.myqcloud.com/images/2017/05/26/14957898385927f10e6b879_U88WRrR8b99r.jpg">
                                <span class="text-over ng-binding" ng-bind="module.title">小程序商城</span>
                            </a><!-- end ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules --><!-- ngIf: last_modules && module.logo && $index+1 < 8 --><!-- end ngRepeat: module in last_modules -->
                        </div>
                    </div>
                </div>
                <script>
                    angular.module('homeApp').value('config', {
                        notices: null,
                    });
                    angular.bootstrap($('#js-home-welcome'), ['homeApp']);
                </script>
            </div>
        </div>
    </div>
