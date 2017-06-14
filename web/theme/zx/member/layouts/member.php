<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?=g("title")?></title>
    <?php $this->head() ?>
    <link charset="utf-8" rel="stylesheet" type="text/css" href="/theme/zx/static/member/css/resource.css">
    <link href="/theme/zx/static/member/js/jquery.ui.all.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php $this->beginBody() ?>

<div id="float">
    <div class="top c-fix">
        <div class="wrap" style="margin: 0px auto; width: 980px;">
            <a href="http://www.tooopen.com/" title="素材公社|素材中国|素材网" class="logo-s">素材公社首页</a>
            <ul class="top-left-s">
                <li><a href="http://www.tooopen.com/psd">PSD素材</a></li>
                <li><a href="http://www.tooopen.com/img">图片素材</a></li>
                <li><a href="http://www.tooopen.com/aicdr">矢量图</a></li>
                <li><a href="http://www.tooopen.com/3d">3D模型</a></li>
                <li><span class="sim-line m12"></span></li>
                <li><a href="http://www.tooopen.com/topic">专辑</a></li>
                <li><a href="http://www.tooopen.com/work">作品</a></li>
                <li><a href="http://www.tooopen.com/copy">资讯</a></li>
                <li style="padding-left:15px;">
                    <div class="search-s"><input id="skey" name="skey" type="text" onfocus="if(this.value==&#39;素材搜索&#39;){this.value=&#39;&#39;}" value="素材搜索" class="input-s"><a href="javascript:goSearch();" class="searchbut">搜索</a></div>
                    <script type="text/javascript">
                        $("#skey").live("keypress", function (event) {
                            var key = event.keyCode || event.which;
                            if (key == 13) {
                                goSearch();
                            }
                        });
                        var goSearch = function () {
                            var key = $("#skey").val();
                            if ($.trim(key).length <= 0) {
                                alert("请输入搜索关键字!");
                                return;
                            }
                            var url = "http://so.tooopen.com/search/" + encodeURI(key) + ".aspx";
                            document.location.href = url;
                        }
                    </script>
                </li>
            </ul>
            <ul class="top-right-s">
                <li id="sm7" style="">
                    <a href="http://www.tooopen.com/onlinepay" class="top-bi" rel="nofollow" style="color: rgb(255, 255, 255);">赞助充值</a>
                    <div class="sim-ti" id="m7" style="display:none;">赞助充值</div>
                </li>
                <li id="sm6" style="">
                    <a href="http://member.tooopen.com/zymanage/sc_addpic" class="top-up" style="color: rgb(255, 255, 255);">上传素材</a>
                    <div class="sim-ti" id="m6" style="display:none;">素材上传</div>
                </li>
                <!--li id="sm9" style="">
                    <a href="http://www.tooopen.com/info.aspx" class="top-info" rel="nofollow" style="color: rgb(255, 255, 255);">服务中心</a>
                    <div class="sim-ti" id="m9" style="display:none;">服务中心</div>
                </li-->
                <li><span class="sim-line"></span></li>
                <li id="sm10">    <div id="userlogin-ok">
                        <a href="http://member.tooopen.com/zymanage" class="nav-user"><span class="user-s">
                <img src="/theme/zx/static/member/image/cartoon14.jpg" alt="cboy868" width="18" height="18" onerror="javascript:this.src=&#39;http://resource.tooopen.com/image/no-img-u.jpg&#39;;this.onerror=null;">
        </span><span class="user-name">cboy868</span>
                        </a>
                        <div class="top-menuup" id="m5" style="display: none;">
                            <!--a href="http://www.tooopen.com/home/866180/goods.aspx"><span class="icon-userhome"></span>我的主页</a-->
                            <a href="http://member.tooopen.com/zymanage" rel="nofollow"><span class="icon-usermana"></span>会员中心</a>
                            <a href="http://member.tooopen.com/zymanage/sc_addpic" rel="nofollow"><span class="icon-userup"></span>上传素材</a>
                            <!--a href="http://member.tooopen.com/blbmanage/sc_scoremanage"><span class="icon-userbi"></span>公社币管理</a-->
                            <a href="http://member.tooopen.com/usermanage/sc_leave"><span class="icon-xiaoxi"></span>消息</a>
                            <a href="http://www.tooopen.com/logout?returnUrl=http%3a%2f%2fmember.tooopen.com%2fzymanage"><span class="icon-exit"></span>退出</a></div>
                    </div>
                </li>
                <script type="text/javascript">
                    //top - bi - sel
                    tooopen._dropDownBind($("#sm7").find(".top-bi"), $("#sm7").find("#m7"), $("#sm7"), "top-bi-sel");
                    tooopen._dropDownBind($("#sm6").find(".top-up"), $("#sm6").find("#m6"), $("#sm6"), "top-up-sel");
                    tooopen._dropDownBind($("#sm9").find(".top-info"), $("#sm9").find("#m9"), $("#sm9"), "top-info-sel");
                    tooopen._dropDownBind($("#sm11").find(".top-uf"), $("#sm11").find("#m11"), $("#sm11"), "top-info-sel");
                    tooopen._requestUserState();
                </script>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript" src="/theme/zx/static/member/js/tooopen-floatdiv.js"></script>
<!--主导航end-->
<div class="sub-h">
    <div class="sub-h-userbox div980">
        <span class="sub-h-userhead">
            <img src="./index_files/cartoon14.jpg" alt="cboy868" onerror="javascript:this.src=&#39;http://resource.tooopen.com/image/no-img-u.jpg&#39;;this.onerror=null;">
        </span>
        <ul class="sub-h-userinfo">
            <li><strong class="t14 l">cboy868</strong>
                <span class="zhe01-l"></span>
                &nbsp;身份：普通会员
            </li>
            <li><a href="http://member.tooopen.com/usermanage/sc_private" class="but-s">修改信息</a><a href="http://member.tooopen.com/blbmanage/sc_scoremanage" class="but-s">查看帐户</a></li>
        </ul>
        <ul class="sub-h-usertonji">
            <li><span>0</span><br>
                公社币</li>
            <li><span>0</span><br>
                素材</li>
            <li><span>0</span><br>
                专辑</li>
            <li><span>0</span><br>
                收入</li>
        </ul>
    </div>
    <div class="sub-h-nav  div980">
        <a href="http://member.tooopen.com/zymanage/" class="down">会员中心</a>
        <!--a href="#")">猜您喜欢</a-->
        <a href="http://www.tooopen.com/home/866180/goods.aspx">我的素材</a>
        <a href="http://www.tooopen.com/home/866180/topic.aspx">我的专辑</a>
        <a href="http://www.tooopen.com/home/866180/link.aspx">我的订阅</a>
        <a href="http://www.tooopen.com/home/866180/collect.aspx">我的收藏</a>
    </div>
</div>
<!--主体内容-->
<?=$content?>
<div id="kefu" onmouseover="this.style.left = &quot;0px&quot;;" onmouseout="this.style.left = &quot;-94px&quot;" style="left: -94px;">
    <div class="info">
        <a href="tencent://message/?uin=1483420896&amp;Menu=yes">会员服务</a>
        <a href="tencent://message/?uin=1483420896&amp;Menu=yes">充值帮助</a>
        <a href="tencent://message/?uin=355570888&amp;Menu=yes">站务合作</a>
    </div>
    <span class="but">在线联系</span>
</div>
<!--bot 底部-->

<div id="botmain" class="botfix+"><div class="botnav">
        <a href="http://www.tooopen.com/sevice_main.aspx?id=307" rel="nofollow">新手上路</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/sevice_main.aspx?id=326" rel="nofollow" target="_blank">关于素材公社</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/sevice_main.aspx?id=358" rel="nofollow" target="_blank">联系我们</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/onlinepay" rel="nofollow" target="_blank">充值赞助</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://member.tooopen.com/usermanage/sc_modify" rel="nofollow">申请认证</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/sevice_main.aspx?id=322" rel="nofollow" target="_blank">法律声明</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com//sevice_main.aspx?id=325" rel="nofollow" target="_blank">服务协议</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/info.aspx" rel="nofollow" target="_blank">服务中心</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/sc_new.aspx" target="_blank">最新素材</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="http://www.tooopen.com/webmap.aspx" target="_blank"> 网站地图</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
        <a href="tencent://message/?uin=1483420896&amp;Menu=yes">客服QQ</a>
    </div>
    <div class="bot">
        <table align="center" cellpadding="0" cellspacing="0"><tbody><tr><td>
                    素材公社版权所有 2008-2015 &nbsp;&nbsp;湘ICP备11010972号&nbsp;&nbsp;
                </td><td>
                    <script type="text/javascript">
                        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fd3ac2f8840ead98242d6205eeff29cb4' type='text/javascript'%3E%3C/script%3E"));
                    </script><script src="/theme/zx/static/member/js/h.js" type="text/javascript"></script><a href="http://tongji.baidu.com/hm-web/welcome/ico?s=d3ac2f8840ead98242d6205eeff29cb4" target="_blank">网站统计</a>
                </td><td>
                    &nbsp;&nbsp; 第九部落公司旗下网站：
                </td><td class="bot-logo">
                    <a href="http://www.wantowan.com/" target="_blank" class="wantowan">去哪玩</a>
                    <a href="http://www.viwik.com/" target="_blank" class="viwik">logo设计</a>
                    <a href="http://www.tooopen.cn/" target="_blank" class="to-cn">设计之家</a>
                </td></tr></tbody></table>
    </div></div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>