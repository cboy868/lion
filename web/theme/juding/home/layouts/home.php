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

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


    <link rel="stylesheet" href="/theme/juding/static/css/global.css" />
    <link href="/theme/juding/static/css/pageloader.css" rel="stylesheet" type="text/css" media="all" id="pageloader-css" />
    <link rel="stylesheet" type="text/css" href="/theme/juding/static/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/theme/juding/static/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/theme/juding/static/css/jquery.jscrollpane.css" />

    <script src="/theme/juding/static/js/jquery-1.11.1.min.js" type="text/javascript" ></script>
    <script src="/theme/juding/static/js/slider.js" type="text/javascript"></script>
    <script src="/theme/juding/static/js/jcarousellite_1.0.1.min.js"  type="text/javascript"></script>
    <script type="text/javascript" src="/theme/juding/static/js/owl.carousel.min.js"></script>

    <script type="text/javascript" src="/theme/juding/static/js/jquery.superslide.2.1.1.js"></script>

</head>


<body>
<?php $this->beginBody() ?>
<link rel="stylesheet" href="/theme/juding/static/css/style.css" />
<script type="text/javascript" src="/theme/juding/static/js/touchslide.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/mobile.index.js"></script>
<script type="text/javascript" src="/theme/juding/static/js/index.js"></script>

<div id="warpper" >
    <div id="header">
        <div class="warp">
            <a class="logo" href="/"><img src="/theme/juding/static/images/logob.png" style="width:50%;" /></a>
            <a class="menu"><img class="menua" src="/theme/juding/static/picture/menu.png" style="width:50%;"  /></a>
            <a class="menu"><img class="menub" src="/theme/juding/static/picture/menuuu.png" style=" display:none "  /></a>
        </div>
    </div>

    <div id="right">

        <div class="right-c">
            <div class="nei">

                <ul>
                    <li class="one"><a  href="/" style="background:none !important;">首页</a></li>
                    <li class="one"><a  href="javascript:">关于我们</a></li>
                    <ul class="xia2">
                        <li class="second"><a  href="/About/list/2.html">关于軒尼斯</a></li><li class="second"><a  href="/About/list/3.html">发展历程</a></li><li class="second"><a  href="/About/list/16.html">董事长寄语</a></li><li class="second"><a  href="/About/list/33.html">团队展示</a></li>
                    </ul>
                    <li class="one"><a  href="javascript:">媒体中心</a></li>
                    <ul class="xia2">
                        <li class="second"><a  href="/Article/list/5.html">企业新闻</a></li><li class="second"><a  href="/Article/list/78.html">企业文化</a></li><li class="second"><a  href="/Video/list/7.html">軒尼斯TV</a></li><li class="second"><a  href="/Article/list/13.html">軒尼斯商报</a></li><li class="second"><a  href="/Article/list/85.html">行业新闻</a></li>
                    </ul>
                    <li class="one"><a  href="javascript:">产品展厅</a></li>
                    <ul class="xia2">
                        <li class="second"><a  href="/Product/list/35.html">产品展示</a></li><li class="second"><a  href="/Product/list/36.html">展厅形象</a></li>
                    </ul>
                    <li class="one"><a  href="/Cases/list/55.html">成功案例</a></li>
                    <!-- <ul class="xia2">
                        <li class="second"><a  href="/Join/list/11.html">职位招聘</a></li>
                    </ul> -->
                    <li class="one"><a  href="/Product/list/17.html">加盟轩尼斯</a></li>
                    <li class="one"><a  href="/Page/list/19.html">联系我们</a></li>
                    <li class="one"><a  href="/Join/list/8.html">人才招聘</a></li>


                </ul>

            </div>
            <div id="footer">
                <div class="warp">
                    <ul style=" width:90%;   margin:0 auto;">
                        <li style=" border-left:none"><a href="/Member/list/84.html"><img src="/theme/juding/static/picture/small-1.png" style="width:20px;height:20px;">&nbsp;经销商登录</a></li>
                        <li><a href="javascript:void(0);" class="fuwu">&nbsp;微信服务号</a></li>
                        <li><a href="javascript:void(0);" class="dingyue">&nbsp;微信订阅号</a></li>
                        <li><a href="1" class="shangcheng">&nbsp;官方商城</a></li>
                    </ul>
                </div>
                <div style="position: relative;  margin: 0 4%; width: 90%; margin-top:2%">
                    <ol style=" width:86%; margin:0 auto;overflow:hidden;" >
                        <input name="" type="text"  style="background: rgba(0, 0, 0, 0);width:88%; height:20px;margin:0 auto;overflow:hidden;" />

                        <input name="" type="button"  style="background:url(/theme/juding/static/images/suosou.png) no-repeat;width:10%; height:25px; padding-bottom:7px;overflow:hidden;" />
                    </ol>
                    <h6 style=" width:86%;border-bottom: 1px solid #999; margin:0 auto;"></h6>
                </div>
                <div style="margin-top: 1%;width: 100%; text-align:center;">
                    <img src="/theme/juding/static/picture/pel.png" style="width:22px; height:24px;margin-bottom: 4%; ">
                    <span style="color:#aa0001;font-size: 18px;font-weight: 600;">440-830-0808</span>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    TouchSlide({
        slideCell:"#slideBox",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell:".bd ul",
        effect:"leftLoop",
        interTime: 5000,
        delayTime: 500 ,
        autoPage:true,//自动分页
        autoPlay:true //自动播放
    });
</script>
<script type="text/javascript">
    TouchSlide({ slideCell:"#slideBoxs", mainCell:".bds ul", effect:"leftLoop" });
</script>


<!-- 头部 -->

<div class="header">
    <div class="header-show">
        <div class="wrap clearfix">
            <h1 class="blogo fl">
                <a href="/" target="_blank">
                    <img src="/theme/juding/static/images/logob.png" alt="" />
                </a>
            </h1>
            <!-- <a href="javascript:void(0)" class="nav-close"></a> -->
            <div class="headerr fr">
                <div class="headerr-top">
                    <a href="/Member/list/84.html" class="jingxiao">经销商登录</a>                    <span>|</span>
                    <a href="javascript:void(0)" class="dingyue">微信订阅号
                    </a>
                    <span>|</span>
                    <a href="javascript:void(0)" class="fuwu">微信服务号
                    </a>
                    <div class="weixin-layout"></div>
                    <div class="weixin-content">
                        <div class="dingyue-content">
                            <p>轩尼斯门窗-微信订阅号</p>
                            <img src="/theme/juding/static/picture/dingyue.jpg" alt="" />
                        </div>
                        <div class="fuwu-content">
                            <p>轩尼斯门窗-微信服务号</p>
                            <img src="/theme/juding/static/picture/fuwu.jpg" alt="" />
                        </div>
                    </div>
                    <a href="#" class="search fr"><span>|</span></a>
                    <span>|</span>
                    <a href="#" class="shangcheng" style="background:none;padding-left:0px;">官方商城 </a>

                </div>
                <div class="headerr-down clearfix">
                    <a href="index.php?m=Search&a=index" class="search fr" target="_blank"><span>|</span></a>
                    <ul class="pnav fr clearfix">
                        <li>
                            <a href="/" class="head" target="_blank">首页</a>
                        </li>
                        <li >
                            <a href="/About/list/2.html" class="head" target="_blank">关于我们 </a>
                            <!-- <div class="body">
                                <div class="pnav-wrap">
                                <a href="/About/list/2.html">关于軒尼斯</a><a href="/About/list/3.html">发展历程</a><a href="/About/list/16.html">董事长寄语</a><a href="/About/list/33.html">团队展示</a>                                </div>
                            </div> -->
                        </li>
                        <li >
                            <a href="/Article/list/5.html" class="head" target="_blank">媒体中心</a>
                            <div class="body">
                                <div class="pnav-wrap">
                                    <a href="/Article/list/5.html" target="_blank" title="">企业新闻</a><a href="/Article/list/78.html" target="_blank" title="">企业文化</a><a href="/Video/list/7.html" target="_blank" title="">軒尼斯TV</a><a href="/Article/list/13.html" target="_blank" title="">軒尼斯商报</a><a href="/Article/list/85.html" target="_blank" title="">行业新闻</a>                                </div>
                            </div>
                        </li>

                        <li >
                            <a href="/Product/list/35.html" class="head" target="_blank">产品展厅</a>
                            <div class="body">
                                <div class="pnav-wrap">
                                    <a href="/Product/list/35.html" target="_blank">产品展示</a><a href="/Product/list/36.html" target="_blank">展厅形象</a>                                </div>
                            </div>
                        </li>
                        <li >
                            <a href="/Cases/list/55.html" class="head" target="_blank">成功案例</a>
                            <!-- <div class="body">
                                <div class="pnav-wrap">
                                <a href="/Cases/list/68.html">窗</a><a href="/Cases/list/67.html">门</a><a href="/Cases/list/69.html">阳光房</a>                                </div>
                            </div> -->
                        </li>
                        <li >
                            <a href="/Product/list/17.html" class="head" target="_blank"> 加盟轩尼斯</a>
                            <!-- <div class="body">
                                <div class="pnav-wrap">
                                <a href="/Page/list/38.html">优秀经销商</a><a href="/Page/list/37.html">在线加盟</a><a href="/Page/list/39.html">加盟地图</a><a href="/Page/list/40.html">企业实力</a><a href="/Page/list/41.html">品牌荣誉</a><a href="/Page/list/42.html">在线客服栏</a>                                </div>
                            </div> -->
                        </li>
                        <li >
                            <a href="/Page/list/19.html" class="head" target="_blank">联系我们</a>
                        </li>
                        <li >
                            <a href="/Join/list/8.html" class="head" target="_blank">人才招聘</a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$content?>
<div class="footer">
    <div style="display:block;height:0;width:0;overflow:hidden;">广帆<a href="http://www.guangfan.com">广州网站建设</a>公司</div>
    <div class="wrap">
        <div class="footer-top clearfix">
            <div class="foot-nav fl">
                <dl>
                    <dt><a href="/About/list/1.html" target="_blank">关于我们 </a></dt>
                    <dd><a href="/About/list/2.html" target="_blank">关于軒尼斯 </a></dd><dd><a href="/About/list/3.html" target="_blank">发展历程 </a></dd><dd><a href="/About/list/16.html" target="_blank">董事长寄语 </a></dd><dd><a href="/About/list/33.html" target="_blank">团队展示 </a></dd>                </dl>
                <dl>
                    <dt><a href="/Article/list/4.html" target="_blank">媒体中心</a></dt>
                    <dd><a href="/Article/list/5.html" target="_blank">企业新闻</a></dd><dd><a href="/Article/list/78.html" target="_blank">企业文化</a></dd><dd><a href="/Video/list/7.html" target="_blank">軒尼斯TV</a></dd><dd><a href="/Article/list/13.html" target="_blank">軒尼斯商报</a></dd><dd><a href="/Article/list/85.html" target="_blank">行业新闻</a></dd>                </dl>
                <dl>
                    <dt><a href="/Product/list/14.html" target="_blank">产品展厅</a></dt>
                    <dd><a href="/Product/list/35.html" target="_blank">产品展示</a></dd><dd><a href="/Product/list/36.html" target="_blank">展厅形象</a></dd>
                </dl>
                <dl>
                    <dt><a href="/Product/list/17.html" target="_blank">加盟轩尼斯 </a></dt>
                    <!--  <dd><a href="/Page/list/38.html">优秀经销商</a></dd><dd><a href="/Page/list/37.html">在线加盟</a></dd><dd><a href="/Page/list/39.html">加盟地图</a></dd><dd><a href="/Page/list/40.html">企业实力</a></dd><dd><a href="/Page/list/41.html">品牌荣誉</a></dd><dd><a href="/Page/list/42.html">在线客服栏</a></dd> -->

                </dl>
                <dl>
                    <dt><a href="/Cases/list/55.html" target="_blank">成功案例</a></dt>
                </dl>
                <dl>
                    <dt><a href="/Join/list/8.html" target="_blank">人才招聘</a></dt>
                    <!-- <dd><a href="/Join/list/11.html">职位招聘</a></dd> -->
                </dl>
                <dl class="foot-hot">
                    <dt>
                        全国热线
                    </dt>
                    <dd>
                        400-830-0808
                    </dd>
                </dl>
            </div>
            <div class="foot-r fr">
                <ul class="qrcode">
                    <li>
                        <img src="/theme/juding/static/picture/577f033b21728.jpg" alt="" /><br />
                        <p>
                            軒尼斯服务号
                        </p>
                    </li>
                    <li>
                        <img src="/theme/juding/static/picture/577f031780d09.jpg" alt="" /><br />
                        <p>
                            軒尼斯订阅号
                        </p>
                    </li>                </ul>
                <div class="share">
                    <div class="bdsharebuttonbox">
                        <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-down">
            <p>
                <span style="color:#868585;font-family:FZDBSJW, " line-height:normal;text-align:right;white-space:normal;background-color:#131111;"="">Copyright@ 2016 佛山市旭辉五金发展有限公司 All rights reserved.</span>
            </p>		</div>
    </div>

</div>




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

