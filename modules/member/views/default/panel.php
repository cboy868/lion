<?php 
use yii\helpers\Url;
?>
<div class="profile">
    <div class="line-big">
        <div class="xm3">
            <div class="panel border-back">
                <div class="panel-body text-center">
                    <img src="<?=$user->getAvatar('200x200', '/static/images/default.png')?>" width="120" class="radius-circle">
                    <br> <?=$user->username?>
                </div>

                <div class="panel-foot bg-back border-back">您好，这是您第<?=$addition->logins;?>次登录，上次登录<?=$log->login_date?>。</div>
            </div>
            <br>
            <div class="panel">
                <div class="panel-head"><strong>统计</strong></div>
                <ul class="list-group">
                    
                    <li>
                        <a href="<?=Url::toRoute(['cms/favor/index'])?>">
                        <span class="float-right badge bg-main"><?=$total['favor']?></span><span class="icon-shopping-cart"></span> 收藏
                        </a>
                    </li>
                    <!-- <li><span class="float-right badge bg-red">88</span><span class="icon-user"></span> 文章</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-file"></span> 图集</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-file-text"></span> 留言</li> -->
                </ul>
            </div>
            <br>
        </div>
        <!-- <div class="xm9">
            <div class="alert alert-yellow"><span class="close"></span><strong>注意：</strong>您有5条未读信息，<a href="#">点击查看</a>。</div>


            <div class="panel-head"><strong>文章</strong></div>
            <div class="panel-group">
                <div class="media media-x">
                    <a class="float-left" href="#">
                        <img src="/static/libs/member/images/face.jpg" class="radius" alt="..." height="64" width='64' class="img-border radius-circle img-responsive">
                    </a>
                    <div class="media-body">
                        <strong>标题</strong> 拼图，是国内一款开源的专业响应式网页前端框架，由HTML、CSS、Javascrip三者组合应用。提供的CSS、元件、动画、组件、模块等样式实现绝大多数的网页特效与响应功能，像玩积木、拼
                    </div>
                </div>
                <div class="media media-x">
                    <a class="float-left" href="#">
                        <img src="/static/libs/member/images/face.jpg" class="radius" alt="..." height="64" width='64' class="img-border radius-circle img-responsive">
                    </a>
                    <div class="media-body">
                        <strong>标题</strong> 拼图，是国内一款开源的专业响应式网页前端框架，由HTML、CSS、Javascrip三者组合应用。提供的CSS、元件、动画、组件、模块等样式实现绝大多数的网页特效与响应功能，像玩积木、拼
                    </div>
                </div>
                <div class="media media-x">
                    <a class="float-left" href="#">
                        <img src="/static/libs/member/images/face.jpg" class="radius" alt="..." height="64" width='64' class="img-border radius-circle img-responsive">
                    </a>
                    <div class="media-body">
                        <strong>标题</strong> 拼图，是国内一款开源的专业响应式网页前端框架，由HTML、CSS、Javascrip三者组合应用。提供的CSS、元件、动画、组件、模块等样式实现绝大多数的网页特效与响应功能，像玩积木、拼
                    </div>
                </div>
                <div class="media media-x">
                    <a class="float-left" href="#">
                        <img src="/static/libs/member/images/face.jpg" class="radius" alt="..." height="64" width='64' class="img-border radius-circle img-responsive">
                    </a>
                    <div class="media-body">
                        <strong>标题</strong> 拼图，是国内一款开源的专业响应式网页前端框架，由HTML、CSS、Javascrip三者组合应用。提供的CSS、元件、动画、组件、模块等样式实现绝大多数的网页特效与响应功能，像玩积木、拼
                    </div>
                </div>
            </div>
                
        </div>


        <div class="xm12">
            <div class="panel-head"><strong>图集</strong></div>
            <div class="line-middle" style="margin-top:10px;">

                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
                
                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
                <div class="xm2 xb1">
                    <div class="media clearfix">
                        <a href="#">
                            <img src="/static/libs/member/images/face.jpg" class="radius img-responsive" alt="...">
                        </a>
                        <div class="media-body">
                            <strong>媒体标题</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

            
        </div>
    </div>
</div>