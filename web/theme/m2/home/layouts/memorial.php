<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$action = Yii::$app->controller->action->id;
$navs = \app\modules\cms\models\Nav::navs();

$controller = Yii::$app->controller;
$controller_id = $controller->id;
$module_id = $controller->module->id;
$action_id = $controller->action->id;

$c_nav = '/'.$module_id .'/'. $controller_id .'/'. $action_id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> 马桂芹的纪念馆 - 观陵山陵园</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="/theme/m2/static/gls/css/an.css" type="text/css">
    <link rel="stylesheet" href="/theme/m2/static/gls/css/login.css" type="text/css">
<!--    <link rel="stylesheet" href="./中国风 - 观陵山陵园_files/user_select.css" type="text/css">-->
<!--    <link rel="stylesheet" href="./中国风 - 观陵山陵园_files/tomb.css" type="text/css">-->
<!--    <link rel="stylesheet" href="./中国风 - 观陵山陵园_files/car.css" type="text/css">-->
<!--    <link rel="stylesheet" href="./中国风 - 观陵山陵园_files/jquery-ui.css" type="text/css">-->
    <script type="text/javascript" src="/theme/m2/static/libs/jquery1.7.2/jquery.min.js"></script>
<!--    <link rel="stylesheet" href="./中国风 - 观陵山陵园_files/colorbox.css" type="text/css">-->
<!--    <script type="text/javascript" src="./中国风 - 观陵山陵园_files/artDialog.js.下载"></script>-->
<!--    <script type="text/javascript" src="./中国风 - 观陵山陵园_files/common.js.下载"></script>-->
    <script type="text/javascript" charset="utf-8">
//        (function($){
//            // 改变默认配置
//            var d = $.dialog.defaults;
//            // 预缓存皮肤，数组第一个为默认皮肤
//            d.skin = ['aero'];
//            // 是否开启特效
//            //d.effect = true;
//            // 锁屏
//            d.lock = true;
//            // 指定超过此面积的对话框拖动的时候用替身
//            //d.showTemp = 100000;
//        })(art);
    </script>
<!--    <link id="xheCSS_default" rel="stylesheet" type="text/css" href="./中国风 - 观陵山陵园_files/ui.css">-->
<!--    <link charset="UTF-8" rel="stylesheet" type="text/css" href="./中国风 - 观陵山陵园_files/art.dialog.css">-->
<!--    <link charset="UTF-8" rel="stylesheet" type="text/css" href="./中国风 - 观陵山陵园_files/aero.css">-->
</head>

<body>
<?php $this->beginBody() ?>

<div id="site-nav">
    <div id="site-navright">
        <div id="sys-msg">
            <!-- 有消息的时候显示消息提醒 -->
            <span class="cursor msgbar ">未读消息<b id="headerCartTotalCount">&nbsp;0</b></span>
            <div id="sys-msgcontent" class="comm-drop" style="display:none">
                <a href="http://gls.gls024.com/member/message/system"><em class="right" style="background:#fee; color:#999;">0</em>系统消息</a>              <a href="http://gls.gls024.com/member/message/friend"><em class="right" style="background:#fee; color:#999;">0</em>好友请求</a>              <a href="http://gls.gls024.com/comment/index"><em class="right" style="background:#fee; color:#999;">0</em>评论</a>              <a href="http://gls.gls024.com/comment/com_rec"><em class="right" style="background:#fee; color:#999;">0</em>评论回复</a>            <a href="http://gls.gls024.com/comment/user/id/1"><em class="right" style="background:#fee; color:#999;">0</em>留言</a>              <a href="http://gls.gls024.com/comment/note_rec"><em class="right" style="background:#fee; color:#999;">0</em>留言回复</a>      </div>
        </div>
        <ul>
            <li class="site-myservice">
                <span class="cursor" id="order_pay">待付款<b id="headerCartTotalCount">0</b></span>
                <div id="order-msgcontent" class="comm-drop" style="display:none;">
                    <a href="http://gls.gls024.com/member/order/unpaidlist"><em class="right" style="background:#fee; color:#999;">0</em>待付款</a>          </div>
            </li>
            <li class="site-orderservice">
                <a href="./中国风 - 观陵山陵园_files/2931">定制<b id="headerCartTotalCount" class="number">0</b>项服务</a>
                <div id="site-submenu" class="hidden"></div>
            </li>
            <li class="site-go"> <a href="http://gls.gls024.com/goods/carts?step=add">去结算</a> </li>     </ul>
    </div>
    <div id="site-navleft">
        <ul>
            <li class="site-user">
                <!--<a href="/member/index" target="_blank">观陵山网络</a>，您好！
                -->                <a href="http://gls.gls024.com/admin" target="_blank">管理中心</a>            <!--<a href="/member/index/logout" id="signOut">退出</a>
        --></li>
            &nbsp;&nbsp;
            <li class="site-help"><a href="javascript:void(0);" class="online-ask qqconsultion">我要帮助</a></li>
            <li class="site-help"><a id="view_opinion1" href="http://gls.gls024.com/notice/addnotice" target="_blank">客户建议收集</a></li>
        </ul>
    </div>
</div>
<?=$content?>
<div id="footer" class="cornerb12">
    <div class="container">
        <p><?=g("fullname")?>?>客服电话:<?=g("cmobile")?></p>
        <p>传真:<?=g("chuanzhen")?>  <?=g("beian")?></p>
    </div>
</div>
<div id="style-alter" style="left: -112px;">
    <span class="cursor clickbar">常用操作</span>
    <div id="style-box">
        <div id="common-operate">
            <h6>常用操作</h6>
            <a href="http://gls.gls024.com/member/memorial/edit?id=2931">编辑纪念馆</a>
        </div>
        <div id="style-list">

            <h6>切换风格</h6>
            <a href="http://gls.gls024.com/home/memorial/change?id=2931&amp;tpl=ink">中国风</a>
            <a href="http://gls.gls024.com/home/memorial/change?id=2931&amp;tpl=grass">草原</a>
            <a href="http://gls.gls024.com/home/memorial/change?id=2931&amp;tpl=cartoon">卡通</a>
            <a href="http://gls.gls024.com/home/memorial/change?id=2931&amp;tpl=fashion_green">时尚绿</a>
            <a href="http://gls.gls024.com/home/memorial/change?id=2931&amp;tpl=fashion_pink">时尚粉</a>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(function(){
        $(".clickbar").toggle(function(){
            $("#style-alter").animate({ left:0 }, 800);
        },function(){
            $("#style-alter").animate({ left:"-112px" }, 800);
        });
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
