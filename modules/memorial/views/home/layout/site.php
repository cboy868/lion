<?php
use yii\helpers\Html;
use yii\helpers\Url;
\app\modules\memorial\assets\SiteAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="wb:webmaster" content="2fdbdc90adf3258f">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="keywords" content="">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head()?>
</head>


<body>
<?php $this->beginBody() ?>
<div class="navbar navbar-default ">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-md hidden-lg" href="/">
                    <img src="/Resource/Images/v2_top_logo.gif" alt="孝爱网" />
                </a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">孝爱主页</a></li>

                    <li><a class="red" href="/MemberCenter/Recharge/Index">在线充值</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="display:block">
                    <li><a href="javascript:LoginPanel()"><i class="navIcon user"></i>登录</a></li>
                    <li><a href="/account/Register"><i class="navIcon register"></i>注册</a></li>
                    <li><a href="/ServCenter/CommonProblem"><i class="navIcon help"></i>帮助</a></li>
                    <li class="dropdown">
                        <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="navIcon snav"></i>网站导航 <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/">纪念馆首页</a></li>
                            <li><a href="/Memorials">纪念馆</a></li>
                            <li><a href="/Today">生日/忌日</a></li>
                            <li><a href="/Obituary">在线讣告</a></li>
                            <li><a href="/Article">深情感文</a></li>
                            <li><a href="/Mailbox">时空信箱</a></li>
                            <li><a href="/Times">时光留影</a></li>
                            <li><a href="/ServCenter">服务专区</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="list-inline jlg-user" style="display:none">
                    <li><a href="#"><p title="进入我的博客中心"></p></a></li>
                    <li><a href="/MemberCenter"><p><strong>进入个人中心</strong></p></a></li>
                    <li><a href="/ServCenter/CommonProblem"><p><strong>帮助</strong></p></a></li>

                    <li><a href="/MemberCenter/Message"><div class="badge">0</div><span title="我的消息" class="userIcon msg">我的消息</span></a></li>
                    <li><a href="/Account/LoginOut"><p>退出</p></a></li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="pull-left">
            <a href="/"><img src="/resource/images/logo.gif" /></a>
        </div>
        <div class="pull-left wrapper-sm m-r-md">
            <div class="fs18">主站</div>
            [<a href="/SiteMap">切换城市</a>]
        </div>
        <div class="pull-left">
            <div class="search-box ">
                <form method="get" action="/Search">
                    <input placeholder="逝者姓名/纪念馆编号" name="keyword" />

                    <button>&nbsp;<i class="glyphicon glyphicon-search"></i> 搜索&nbsp;</button>
                </form>
            </div>
        </div>
        <div class="pull-right">
            <div class="pull-left wrapper-xs"><img src="/resource/images/tel.png"></div>
            <div class="pull-left lh20">
                <p><small>全国24小时服务热线</small></p>
                <p class="fs16 green">400-860-4520</p>
                <p class="fs16 green">0756-5505883</p>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-waheaven">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".waheaven-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse waheaven-collapse collapse" role="navigation">
                <ul id="toolbarIndex" class="nav navbar-nav">
                    <li class="active"><a key="" href="/">孝爱首页</a></li>
                    <li class="dropdown">
                        <a key="Memorials" aria-expanded="false" aria-haspopup="true" role="button" data-hover="dropdown" href="/Memorials">纪念馆 <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <div class="container child-list">
                                <a key="Memorials" href="/Memorials?Type=1">私人馆</a>
                                <a key="Memorials" href="/Memorials?Type=2">名人馆</a>
                                <a key="Memorials" href="/Memorials?Type=5">英烈馆</a>
                                <a key="Memorials" href="/Memorials?Type=6">恩师馆</a>
                                <a key="Memorials" style="display:none" href="/Search">恩师馆</a>
                                <!--<a href="#">家族馆</a>
                                <a href="#">事件馆</a>-->
                            </div>
                        </div>
                    </li>
                    <li><a key="FamilyTree" href="/FamilyTree">家谱</a></li>

                    <li><a key="VIP" href="/VIP">VIP特权</a></li>
                    <li><a key="Today" href="/Today">生辰/忌日</a></li>
                    <li><a key="Obituary" href="/Obituary">在线讣告</a></li>
                    <li><a key="Article" href="/Article">深情感文</a></li>
                    <li><a key="Mailbox" href="/Mailbox">时空信箱</a></li>
                    <li><a key="Times" href="/Times">时光流影</a></li>
                    <li><a key="" href="http://video.5201000.com">在线告别式</a></li>
                    <li><a key="ServCenter" href="/ServCenter">服务专区</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="blank"></div>




<?=$content?>

<div class="certificate">
    <div class="container">
        <div class="pull-right m-t">
            <div class="pull-left wrapper-xs"><img src="../resource/images/ftel.png"></div>
            <div class="pull-left lh20">
                <p><small>全国24小时服务热线</small></p>
                <p class="fs16">400-860-4520</p>
                <p class="fs16">0756-5505883</p>
            </div>
        </div>
        <h4 class="m-b">合作机构</h4>
        <a target="_blank" href="http://www.cyberpolice.cn/wfjb/" class="certificateIcon logo1"></a>
        <a target="_blank" href="http://www.miibeian.gov.cn/" class="certificateIcon logo2"></a>
        <a target="_blank" href="http://www.12377.cn/" class="certificateIcon logo3"></a>
        <a target="_blank" href="http://www.wenming.cn/" class="certificateIcon logo4"></a>
        <a target="_blank" href="#" class="certificateIcon logo5"></a>
        <a target="_blank" href="http://www.zgbzxh.org/" class="certificateIcon logo6"></a>
    </div>
</div>
<div class="mainfooter waheaven-footer">
    <div class="container">
        <div class="">
            <div class="col-md-10">
                <div class="row">
                    <ul class="list-inline">
                        <li><a href="/Abouts">关于我们</a></li>
                        <li><a href="/Abouts/Media">媒体报道</a></li>
                        <li><a href="/Abouts/News">公司动态</a></li>
                        <li><a href="/Abouts/Job">诚聘人才</a></li>
                        <li><a href="/Abouts/Exceptions">免责条款</a></li>
                        <li><a href="/Abouts/Popularize">推广合作</a></li>
                        <li><a href="/Abouts/Ad">广告服务</a></li>
                        <li><a href="/Abouts/Pay">支付方式</a></li>
                        <li><a href="/Abouts/Contact">联系我们</a></li>
                    </ul>
                    <p>
                        <a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备15040846号-4</a> 一群：35217730 <a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=f70ef12fef1242f9b10a4d4341b97fc64e885e256abcf80e926276b7b1e77059"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="孝爱天堂1群" title="孝爱天堂1群" align="absmiddle"></a>

                        二群： 397084189 <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=b5fdc3d680c33e862bc42986734e33979612738661daa1d99e468e2ec6d12a29"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="孝爱天堂2群" title="孝爱天堂2群"></a> <strong>
                            <a href="http://wpa.qq.com/msgrd?V=1&Uin=2268973521&Site=天堂网欢迎您&Menu=yes" target="_blank" alt="在线服务"><img src=' http://wpa.qq.com/pa?p=1:2268973521:4' border='0' alt='QQ在线服务' />孝爱天使（客服）</a>&nbsp;&nbsp;
                            <a href="http://wpa.qq.com/msgrd?V=1&Uin=2691250801&Site=天堂网欢迎您&Menu=yes" target="_blank" alt="在线服务"><img src=' http://wpa.qq.com/pa?p=1:2691250801:4' border='0' alt='QQ在线服务' />天堂网</a>&nbsp;&nbsp;
                            <a href="http://wpa.qq.com/msgrd?V=1&Uin=540254000&Site=天堂网欢迎您&Menu=yes" target="_blank" alt="在线服务"><img src=' http://wpa.qq.com/pa?p=1:540254000:4' border='0' alt='QQ在线服务' />孝爱天堂</a>
                        </strong>
                    </p>
                    <p>天堂纪念网旗下网站：<a href="http://www.5201000.com/" target="_blank">中文站</a> <a href="http://www.heaven9.com/" target="_blank">英文站</a> <a href="http://www.bz086.com/" target="_blank">天堂殡葬网</a></p>
                    <p>
                        关健词：<a href="http://www.5201000.com/" title="网上祭奠">网上祭奠</a>
                        <a href="http://www.5201000.com/" title="网上祭奠">祭奠网</a>
                        <a href="http://www.5201000.com/" title="网上祭拜">网上祭拜</a>
                        <a href="http://www.5201000.com/" title="网上祭祀">网上祭祀</a>
                        <a href="http://www.5201000.com/Memorials" title="网上纪念馆">网上纪念馆</a>
                        <a href="http://www.5201000.com/" title="祭祀网">祭祀网</a>
                        <a href="http://www.5201000.com/Memorials" title="网上扫墓">网上扫墓</a>
                        <a href="http://www.waheaven.com/Culture2/List.aspx?ClassID=51" title="悼词范文">悼词范文</a>
                        <a href="http://www.waheaven.com/Culture2/List.aspx?ClassID=52" title="讣告范文">讣告范文</a>
                        <a href="http://www.waheaven.com/Culture2/List.aspx?ClassID=58" title="祭文范文">祭文范文</a><br />
                        <a href="http://www.5201000.com/" title="网上纪念">网上纪念</a>
                        <a href="http://www.5201000.com/" title="网上公墓">网上公墓</a>
                        <a href="http://www.waheaven.com/Dream/Index.html" title="周公解梦">周公解梦</a>
                        <a href="http://www.waheaven.com/Genealogys/Index.aspx" title="在线家谱">在线家谱</a>

                        <a href="http://www.waheaven.com/Genealogys/Index.aspx" title="网上家谱">网上家谱</a>
                    </p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="row attention">
                    <div class="col-md-12 col-sm-4 col-xs-4"><img width="100" src="/resource/images/membercenter/weixin.png" /><p>关注天堂微信平台</p></div>

                </div>
            </div>
        </div>
    </div>
</div>
<!---------------页脚结束----------------->
<script type="text/javascript" src="/resource/scripts/jquery.cycle2.min.js"></script>
<script type="text/javascript" src="/resource/scripts/index/index.js"></script>

<div class="modal fade user-info-dialog" tabindex="-1" role="dialog">
</div>
<div id="show_msg" class="">
    <span class="glyphicon glyphicon-ok"></span> <strong></strong>
</div>
<div id="customerService">
    <ul>
        <li>
            <a target="_blank" class="cs-icon cs1" href="http://www.53kf.com/company.php?arg=waheaven&amp" >
                <span></span><div>在线咨询<small>CONSULT</small></div>
            </a>
        </li>
        <li>
            <a class="cs-icon cs3" href="tencent://message/?uin=540254000&Menu=yes">
                <span></span><div>QQ客服<small>CONSULT</small></div>
            </a>
        </li>
        <li>
            <div class="cs-attention"><img src="/Resource/Images/weixin.png"></div>
            <a class="cs-icon cs6" href="javascript:;" data-type="weixin">
                <span></span><div>微 信<small>扫一扫</small></div>
            </a>
        </li>
        <li>
            <a class="cs-icon cs2" href="tencent://message/?uin=2691250801&Menu=yes" target="_blank">
                <span></span><div>推广合作<small>EXTEND</small></div>
            </a>
        </li>
        <li>
            <a class="cs-icon cs7" href="#" target="_blank">
                <span></span><div>分 享<small>SHARE</small></div>
            </a>
        </li>
        <li>
            <a class="cs-icon cs5" href="javascript:;" id="top_btn">
                <span></span><div>返回顶部<small>TOP</small></div>
            </a>
        </li>
    </ul>
</div>
<script>
    window._bd_share_config = {
        common: {
            bdText: document.title,
            bdDesc: $("meta[name=Description]").attr("content"),
            bdUrl:document.URL
        },
        share: [{
            "bdSize": 24
        }],
        slide: [{
            bdImg: 0,
            bdPos: "right",
            bdTop: 240
        }]
    }

    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?ec55666211ebb7bb67bd550bf5fa0d9e";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();

    $(function () {
        $.getScript("http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=" + ~(-new Date() / 36e5) + "", function () {});

        //var AutoZzHide = function () {
        //    var zztime = setTimeout(function () {
        //        if ($("#cnzz_stat_icon_1258742622").size() > 0) {
        //            $("#cnzz_stat_icon_1258742622").hide();
        //            clearTimeout(zztime);
        //        }
        //        else {
        //            AutoZzHide();
        //        }
        //    },50)
        //}
        //var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://"); document.write(unescape("%3Cspan id='cnzz_stat_icon_1258742622'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1258742622' type='text/javascript'%3E%3C/script%3E"));
        //AutoZzHide();

    })

</script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>