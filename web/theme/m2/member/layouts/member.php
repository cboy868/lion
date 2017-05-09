<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="baidu-site-verification" content="sSXyxVj8bS">
    <link rel="stylesheet" href="/theme/m2/static/css/an.css" type="text/css">
    <link rel="stylesheet" href="/theme/m2/static/css/layout.css">
    <link rel="stylesheet" href="/theme/m2/static/css/blog.css">
    <link rel="stylesheet" href="/theme/m2/static/css/center.css">
    <script type="text/javascript" src="/theme/m2/static/libs/jquery1.7.2/jquery.min.js"></script>
</head>


<body>
<?php $this->beginBody() ?>
<div id="site-nav">
    <div id="site-navright">
        <div id="sys-msg">
            <!-- 有消息的时候显示消息提醒 -->
            <span class="cursor msgbar ">未读消息<b id="headerCartTotalCount">&nbsp;0</b></span>
            <div id="sys-msgcontent" class="comm-drop" style="display:none">
                <a href="http://gls.gls024.com/member/message/system">
                    <em class="right" style="background:#fee; color:#999;">0</em>系统消息</a>
                <a href="http://gls.gls024.com/member/message/friend">
                    <em class="right" style="background:#fee; color:#999;">0</em>好友请求</a>
                <a href="http://gls.gls024.com/comment/index">
                    <em class="right" style="background:#fee; color:#999;">0</em>评论</a>
                <a href="http://gls.gls024.com/comment/com_rec">
                    <em class="right" style="background:#fee; color:#999;">0</em>评论回复</a>
                <a href="http://gls.gls024.com/comment/user/id/1">
                    <em class="right" style="background:#fee; color:#999;">0</em>留言</a>
                <a href="http://gls.gls024.com/comment/note_rec">
                    <em class="right" style="background:#fee; color:#999;">0</em>留言回复</a>
            </div>

        </div>
        <ul>
            <li class="site-myservice">
                <span class="cursor" id="order_pay">待付款<b id="headerCartTotalCount">0</b></span>
                <div id="order-msgcontent" class="comm-drop" style="display:none;">
                    <a href="http://gls.gls024.com/member/order/unpaidlist"><em class="right" style="background:#fee; color:#999;">0</em>待付款</a>          </div>
            </li>
            <li class="site-orderservice"> <a href="http://gls.gls024.com/member#">定制
                    <b id="headerCartTotalCount" class="number">0</b>项服务</a>
                <div id="site-submenu" class="hidden"></div>
            </li>
            <li class="site-go"> <a href="http://gls.gls024.com/goods/carts?step=add">去结算</a> </li>     </ul>
    </div>
    <div id="site-navleft">
        <ul>
            <li class="site-user">
                <a href="/member/index" target="_blank">观陵山网络</a>，您好！

                <a href="http://gls.gls024.com/admin" target="_blank">管理中心</a>
                <a href="/member/index/logout" id="signOut">退出</a>
            </li>
            &nbsp;&nbsp;
            <li class="site-help"><a href="javascript:void(0);" class="online-ask qqconsultion">我要帮助</a></li>
            <li class="site-help"><a id="view_opinion1" href="http://gls.gls024.com/notice/addnotice" target="_blank">客户建议收集</a></li>
        </ul>
    </div>
</div>
<div id="index-header">
    <div id="header">
        <a class="logo" href="http://gls.gls024.com/">
            <img class="png" src="/theme/m2/static/images/common/logo_03.jpg" alt="">
        </a>
    </div>
</div>
<div id="nav">
    <div class="container">
        <div class="right">
            <a href="http://gls.gls024.com/member/index">观陵山网络</a>
            <a href="http://gls.gls024.com/member/index/logout" id="signOut">退出</a>
        </div>        <ul class="clearfix">
            <li class="first"><a href="http://gls.gls024.com/">首页</a></li>
            <li><a href="http://gls.gls024.com/news">资讯</a></li>
            <li><a href="http://gls.gls024.com/blogs">服务日志</a></li>
            <li><a href="http://gls.gls024.com/memorial">观陵山大家庭</a></li>
            <li><a href="http://gls.gls024.com/home/profile/">
                    我的主页
                </a></li>
            <li class="last"><a href="http://gls.gls024.com/member">我的后台</a></li>
        </ul>
    </div>
</div>
    <?=$content?>
<div id="footer" class="cornerb12">
    <p><?=g('fullname')?>客服电话:<?=g("cmobile")?></p>
    <p>传真:<?=g("chuanzhen")?> <?=g("beian")?></p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
