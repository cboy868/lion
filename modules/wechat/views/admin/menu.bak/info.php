<?php
$this->title = '微信菜单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/static/wechat/css/common.css">
<div class="panel panel-content">
    <div class="content-head panel-heading">
        <img src="/static/wechat/images/nopic-107.png" class="head-logo">
        <span class="font-lg">万家同城</span>
        <span class="label label-primary">服务号</span> <span class="label label-primary">已认证</span>																<span class="pull-right"><a href="http://tc.ibagou.com/web/index.php?c=account&amp;a=display&amp;" class="color-default we7-margin-left"><i class="wi wi-cut color-default"></i>切换公众号</a></span>
        <span class="pull-right"><a href="http://tc.ibagou.com/web/index.php?c=account&amp;a=post&amp;uniacid=2&amp;acid=2"><i class="wi wi-appsetting"></i>公众号设置</a></span>
        <span class="pull-right"><a href="http://tc.ibagou.com/web/index.php?c=utility&amp;a=emulator&amp;" target="_blank"><i class="wi wi-iphone"></i>模拟测试</a></span>
    </div>
    <div class="panel-body clearfix main-panel-body">

        <div class="right-content">

            <div class="conditionMenu ng-scope" ng-controller="conditionMenuDesigner" id="conditionMenuDesigner">
                <div class="new">
                    <ol class="breadcrumb we7-breadcrumb">
                        <a href="http://tc.ibagou.com/web/index.php?c=platform&amp;a=menu&amp;type=1"><i class="wi wi-back-circle"></i></a>
                        <li>
                            <a href="http://tc.ibagou.com/web/index.php?c=platform&amp;a=menu&amp;type=1">自定义菜单</a>
                        </li>
                        <li>
                            新建菜单
                        </li>
                    </ol>
                    <div class="we7-form">
                        <div class="form-group">
                            <label for="" class="control-label col-sm-2">菜单组名称</label>
                            <div class="form-controls col-sm-8">
                                <input type="text" style="width: 600px" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="context.group.title" ng-disabled="context.group.disabled">
                                <span class="help-block">给菜单组起个名字吧！以便查找</span>
                            </div>
                        </div>
                        <div class="menu-setting-area">
                            <div class="menu-preview-area">
                                <div class="mobile-menu-preview">
                                    <div class="mobile-hd ng-binding">默认菜单</div>
                                    <div class="mobile-bd">
                                        <div class="js-quickmenu nav-menu-wx clearfix has-nav-2" ng-class="{0 : 'has-nav-0', 1 : 'has-nav-1', 2: 'has-nav-2', 3: 'has-nav-3', 4 : 'has-nav-3'}[context.group.button.length + 1]">
                                            <ul class="designer-x  pre-menu-list ui-sortable">
                                                <!-- ngRepeat: but in context.group.button --><li class="js-sortable pre-menu-item ng-scope active" ng-repeat="but in context.group.button" ng-class="{0 : '', 1 : 'active'}[context.activeItem == but ? 1 : 0 ]">
                                                    <input type="hidden" data-role="parent" data-hash="object:3">
                                                    <a href="javascript:void(0);" title="拖动排序" class="pre-menu-link ng-binding" ng-click="context.editBut('', but, 0);">
                                                        <i class="icon-menu-dot ng-hide" ng-show="but.sub_button.length > 0"></i>
                                                        菜单名称
                                                    </a>
                                                    <div class="sub-pre-menu-box">
                                                        <ul class="sub-pre-menu-list designer-y ui-sortable">
                                                            <!-- ngRepeat: subBut in but.sub_button --><!-- ngIf: but.sub_button.length < 5 --><li ng-if="but.sub_button.length < 5" ng-click="context.addSubBut(but);" class="ng-scope"><i class="fa fa-plus"></i>

                                                            </li><!-- end ngIf: but.sub_button.length < 5 --></ul>
                                                    </div>
                                                </li><!-- end ngRepeat: but in context.group.button -->
                                                <!-- ngIf: context.group.button.length < 3 --><li class="pre-menu-item grid-item js-not-sortable ng-scope" ng-if="context.group.button.length < 3" ng-hide="context.group.disabled">
                                                    <a href="javascript:void(0);" ng-click="context.addBut();" class="pre-menu-link">
                                                        <i class="icon14-menu-add"></i>
                                                        <span class="">添加菜单</span></a>

                                                </li><!-- end ngIf: context.group.button.length < 3 -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-form-area">
                                <div class="menu-initial-tips tips-global" style="display: none;">点击左侧菜单进行编辑操作</div>
                                <div class="portable-editor to-left" style="display: block;">
                                    <div class="editor-inner">
                                        <div class="menu-form-hd">
                                            <span class="pull-left font-defalut">当前菜单</span>
                                            <div class="text-right">
                                                <a href="javascript:void(0);" class="color-default" ng-click="context.removeBut(context.activeItem, context.activeType)">删除菜单</a>
                                            </div>
                                        </div>
                                        <div style="display: none;" class="we7-padding-top color-gray">已添加子菜单，仅可设置菜单名称。</div>
                                        <div class="we7-form we7-padding-top">
                                            <div class="form-group">
                                                <label for="" class="control-label col-sm-2">菜单名称</label>
                                                <div class="form-controls col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="" style="width: 300px" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty" placeholder="" id="title" ng-model="context.activeItem.name" ng-disabled="context.group.disabled">
                                                        <!-- ngIf: !context.group.disabled --><span ng-if="!context.group.disabled" class="input-group-addon bg-default color-default ng-scope" ng-click="context.selectEmoji();"><a href="http://tc.ibagou.com/web/index.php?c=platform&amp;a=menu&amp;do=post&amp;type=1">添加表情</a></span><!-- end ngIf: !context.group.disabled -->
                                                    </div>
                                                    <span class="help-block">字数不超过4个汉字或8个字母</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-sm-2">菜单内容</label>
                                                <div class="form-controls col-sm-10">
                                                    <input id="radio-1" type="radio" name="ipt" ng-checked="context.activeItem.type == 'media_id' || context.activeItem.type == 'click'" ng-model="context.activeItem.type" value="click" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty" checked="checked">
                                                    <label for="radio-1">发送消息 </label>
                                                    <input id="radio-2" type="radio" name="ipt" ng-model="context.activeItem.type" value="view" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-2">跳转网页 </label>
                                                    <input id="radio-3" type="radio" name="ipt" ng-model="context.activeItem.type" value="scancode_push" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-3">扫码 </label>
                                                    <input id="radio-4" type="radio" name="ipt" ng-model="context.activeItem.type" value="scancode_waitmsg" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-4">扫码（等待信息） </label>
                                                    <input id="radio-5" type="radio" name="ipt" ng-model="context.activeItem.type" value="location_select" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-5">地理位置 </label>
                                                    <input id="radio-6" type="radio" name="ipt" ng-model="context.activeItem.type" value="pic_sysphoto" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-6">拍照发图 </label>
                                                    <input id="radio-7" type="radio" name="ipt" ng-model="context.activeItem.type" value="pic_photo_or_album" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-7">拍照相册</label>
                                                    <input id="radio-8" type="radio" name="ipt" ng-model="context.activeItem.type" value="pic_weixin" ng-disabled="context.group.disabled" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                                    <label for="radio-8">相册发图 </label>
                                                </div>
                                            </div>
                                            <div class="menu-content ng-hide" ng-show="context.activeItem.type == 'view';">
                                                <div class="form-group">
                                                    <p class="color-gray">订阅者点击该子菜单会跳转到以下链接</p>
                                                    <label for="" class="control-label col-sm-2">页面地址</label>
                                                    <div class="form-controls col-sm-8">
                                                        <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" id="ipt-url" ng-model="context.activeItem.url" ng-disabled="context.group.disabled">
                                                        <!-- ngIf: !context.group.disabled --><span ng-if="!context.group.disabled" class="form-control-addon color-default ng-scope" id="search" ng-click="context.select_link()">选择地址</span><!-- end ngIf: !context.group.disabled -->
                                                        <span class="help-block">指定点击此菜单时要跳转的链接（注：链接需加http://）</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel we7-panel ng-hide" ng-show="context.activeItem.type != 'view' &amp;&amp; context.activeItem.type != 'click'" style="width:540px;">
                                                <div class="panel-heading">
                                                    回复内容
                                                </div>
                                                <!--<label for="" class="control-label">选择</label>-->
                                                <div class="panel-body we7-padding">
                                                    <p class="color-gray ng-hide" ng-show="context.activeItem.type == 'location_select'">菜单内容为地理位置，那么点击这个菜单是，系统发送当前地理位置</p>
                                                    <p class="color-gray ng-hide" ng-show="context.activeItem.type == 'pic_sysphoto' || context.activeItem.type == 'pic_photo_or_album'">菜单内容为系统拍照发图/拍照或者相册发图，那么点击这个菜单是，系统拍照</p>
                                                    <p class="color-gray ng-hide" ng-show="context.activeItem.type == 'pic_weixin'">菜单内容为微信相册发图，那么点击这个菜单是，选择图片发送</p>
                                                    <p class="color-gray ng-hide" ng-show="context.activeItem.type == 'scancode_push' || context.activeItem.type == 'scancode_waitmsg'">菜单内容为扫码，那么点击这个菜单是，手机扫描二维码</p>
                                                    <ul class="keywords-list">
                                                        <!-- ngIf: context.activeItem.material[0].etype == 'click' -->
                                                        <!-- ngIf: context.activeItem.material[0].etype == 'module' -->
                                                    </ul>
                                                    <div class="we7-select-msg we7-padding-vertical-max">
                                                        <ul class="tab-navs">
                                                            <li>继续添加：</li>
                                                            <li class="tab-nav tab-video" ng-click="context.select_mediaid('module');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender "></i><span class="msg-tab-title">模块</span></a>
                                                            </li>
                                                            <li class="tab-nav tab-cardmsg" ng-click="context.select_mediaid('keyword', '1');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender "></i><span class="msg-tab-title">触发关键字</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel we7-panel" style="width: 540px;" ng-show="context.activeItem.type == 'click'">
                                                <div class="panel-heading">
                                                    回复内容
                                                </div>
                                                <div class="panel-body we7-padding">
                                                    <ul class="keywords-list">
                                                        <!-- ngIf: context.activeItem.material[0].type == 'keyword' || (context.activeItem.type == 'click' && context.activeItem.key) -->
                                                        <!-- ngIf: context.activeItem.material[0].type == 'news' -->
                                                        <!-- ngIf: context.activeItem.material[0].type == 'image' -->
                                                        <!-- ngIf: context.activeItem.material[0].type == 'voice' -->
                                                        <!-- ngIf: context.activeItem.material[0].type == 'video' -->
                                                    </ul>
                                                    <div class="we7-select-msg we7-padding-vertical-max">
                                                        <ul class="tab-navs">
                                                            <li>继续添加：</li>
                                                            <li class="tab-nav tab-appmsg" ng-click="context.select_mediaid('news');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender"></i><span class="msg-tab-title">图文</span></a>
                                                            </li>
                                                            <li class="tab-nav tab-img" ng-click="context.select_mediaid('image');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender"></i><span class="msg-tab-title">图片</span></a>
                                                            </li>

                                                            <li class="tab-nav tab-audio" ng-click="context.select_mediaid('voice');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender"></i><span class="msg-tab-title">语音</span></a>
                                                            </li>

                                                            <li class="tab-nav tab-video" ng-click="context.select_mediaid('video');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender "></i><span class="msg-tab-title">视频</span></a>
                                                            </li>
                                                            <li class="tab-nav tab-cardmsg" ng-click="context.select_mediaid('keyword', '1');">
                                                                <a href="javascript:void(0);">&nbsp;<i class="icon-msg-sender "></i><span class="msg-tab-title">触发关键字</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="editor-arrow-wrp">
							<i class="editor-arrow editor-arrow-out"></i>
							<i class="editor-arrow editor-arrow-in"></i>
						</span>
                                </div>
                            </div>
                        </div>
                        <div class="menu-submit">
                            <!-- ngIf: 1 --><input type="submit" name="" id="" value="发&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;布" class="btn btn-primary ng-scope" style="padding: 6px 50px;" ng-if="1" ng-click="context.submit();"><!-- end ngIf: 1 -->
                            <input type="button" name="" id="" value="预&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;览" class="btn btn-primary" style="padding: 6px 50px;" data-toggle="modal" data-target="#mobileDiv">
                        </div>
                        <div class="modal fade" id="mobileDiv" role="dialog" aria-hidden="true">
                            <div class="mobile-preview">
                                <div class="mobile-preview-hd">
                                    <strong class="nickname ng-binding">默认菜单</strong>
                                </div>
                                <div class="mobile-preview-bd">
                                    <ul id="viewShow" class="show-list"></ul>
                                </div>
                                <div class="mobile-preview-ft">
                                    <ul class="pre-menu-list grid-line" id="viewList">
                                        <!-- ngRepeat: but in context.group.button --><li class="pre-menu-item grid-item ng-scope" ng-repeat="but in context.group.button" id="menu-0">
                                            <a href="javascript:void(0);" class="pre-menu-link ng-binding" title="菜单名称">
                                                <i class="icon-menu-dot"></i>
                                                菜单名称
                                            </a>
                                            <div class="sub-pre-menu-box" style="display: block;">
                                                <ul class="sub-pre-menu-list">
                                                    <!-- ngRepeat: subBut in but.sub_button -->
                                                </ul>
                                                <i class="arrow arrow-out"></i>
                                                <i class="arrow arrow-in"></i>
                                            </div>
                                        </li><!-- end ngRepeat: but in context.group.button -->
                                    </ul>
                                </div>
                                <a href="javascript:void(0);" class="mobile-preview-closed btn btn-default" id="viewClose" data-dismiss="modal">退出预览</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>