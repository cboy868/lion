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
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?=g("title")?></title>
    <?php $this->head() ?>
    <meta name="keywords" content="<?=g("keywords")?>" />
    <meta name="description" content="<?=g("description")?>" />

    <meta name=author content="<?=g("author")?>" />
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui"/>
    <meta name="format-detection" content="telephone=no"/>

    <link href="/theme/zhuoxun/static/css/menu.css" rel="stylesheet"/>

    <link href="/theme/zhuoxun/static/css/load6.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/zhuoxun/static/css/ext.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/bootstrap-collapse.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/respond.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/jquery.royalslider.min.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/nprogress.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/qrcode.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/respond.js"></script>
    <script type="text/javascript" src="/theme/zhuoxun/static/js/jquery.kinMaxShow-1.0.min.js"></script>
    <script src="/theme/zhuoxun/static/js/bootstrap.js"></script>
    <script src="/theme/zhuoxun/static/js/jquery.bootstrap-autohidingnavbar.js"></script>
</head>


<body>
<?php $this->beginBody() ?>
<div class="fade out">
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">厦门创易网络-网站建设专家</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="/" alt="nice design">
                    <img src="/theme/zhuoxun/static/images/logo2.png" alt="<?=g("fullname")?>" class="topimg1" title="" />
                    <img src="/theme/zhuoxun/static/images/logo.png" alt="<?=g("fullname")?>" class="topimg2">
                </a> </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php foreach ($navs as $k => $v):?>
                        <li class='<?php if($c_nav == $v['url']):?>active<?php endif;?>' >
                            <a href="<?=Url::toRoute($v['url'])?>"><?=$v['name']?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $(window).scroll(function(){
                if($(document).scrollTop() > 1){
                    $('.navbar-default').addClass('on')
                }else{
                    $('.navbar-default').removeClass('on')
                }
            })

        })
    </script>



<?=$content?>
    <div class="main_foot">
        <div class="foot2">
            <div class="foot_logo">
                <img src="/theme/zhuoxun/static/images/foot_logo.png" />
                <!-- <p style="font-size:16px; margin:5px 0 0 5px; color:#333;">厦门首家私人定制型网站建设</p> -->
            </div>
            <div class="con">
                <ul class="list1">
                    <li>
                        <h1>服务</h1>
                    </li>
                    <li>
                        <a href="/service/#templatemo1">服务体系</a>
                    </li>
                    <li>
                        <a href="/service/#templatemo2">解决方案</a>
                    </li>
                    <li>
                        <a href="/service/#templatemo3">服务优势</a>
                    </li>
                    <li>
                        <a href="/service/#templatemo4">合作流程</a>
                    </li>
                </ul>
                <ul class="list1">
                    <li>
                        <h1>案例</h1>
                    </li>

                    <li>
                        <a href='/cases/list-4-1'>企业网站</a>
                    </li>

                    <li>
                        <a href='/cases/list-1-1'>平台门户网站</a>
                    </li>

                    <li>
                        <a href='/cases/list-2-1'>电商网店</a>
                    </li>

                    <li>
                        <a href='/cases/list-3-1'>移动APP</a>
                    </li>

                </ul>
                <ul class="list1">
                    <li>
                        <h1>动态</h1>
                    </li>

                    <li>
                        <a href='/article/list-2-1.html'>行业时讯</a>
                    </li>

                    <li>
                        <a href='/article/list-3-1.html'>产品设计</a>
                    </li>
                </ul>
                <ul class="list1">
                    <li>
                        <h1>知识</h1>
                    </li>
                    <li>
                        <a href='/article/list-4-1.html'>产品运营</a>
                    </li>
                    <li>
                        <a href='/article/list-5-1.html'>微营销</a>
                    </li>
                    <li>
                        <a href='/article/list-6-1.html'>用户体验</a>
                    </li>
                    <li>
                        <a href='/article/list-7-1.html'>SEO推广</a>
                    </li>

                </ul>
            </div><!--
<ul class="list2">
<li>
  <h1>商务合作</h1>
</li>
<li>邮箱：info@0592ui.com</li>

<li>座机：0592-3177731</li>
<li>
Q Q：17001781
<a href="http://wpa.qq.com/msgrd?v=3&uin=17001781&site=qq&menu=yes" target="_blank"> <i class="qq"></i>
  点击交谈
</a>
</li>
<li>地址：厦门软件园二期望海路15号之一6层</li>
</ul> -->

            <style>
                .foot ul.list2 h1 {color: #222}
                .copy_about a.gt{color:#33a600}.foot .copy_about  i.qq{width:18px;height:18px;background:url(/theme/zhuoxun/static/images/copyright_ico.gif) 0 0 no-repeat;display:inline-block;vertical-align:middle}.copy_about a.qqmsn{width:78px;height:21px;background:url(/theme/zhuoxun/static/images/copyright_ico.gif) 0 -72px no-repeat;display:inline-block;vertical-align:middle;margin-top:1px}.copy_about .qqtext{display:inline-block;vertical-align:middle}.copy_about i.weixin{width:18px;height:18px;background:url(/theme/zhuoxun/static/images/copyright_ico.gif) 0 -18px no-repeat;display:inline-block;vertical-align:middle}.copy_about i.tel{width:18px;height:18px;background:url(/theme/zhuoxun/static/images/copyright_ico.gif) 0 -36px no-repeat;display:inline-block;vertical-align:middle}.copy_about i.mail{width:18px;height:18px;background:url(/theme/zhuoxun/static/images/copyright_ico.gif) 0 -54px no-repeat;display:inline-block;vertical-align:middle}
            </style>
            <ul class="list2 copy_about">
                <li>
                    <h1>联系我们</h1>
                </li>
                <li> <i class="qq"></i>
                    <span class="qqtext">Q Q：</span>
                    <a target="_blank" class="qqmsn" href="http://wpa.qq.com/msgrd?v=3&amp;uin=171532137&amp;site=qq&amp;menu=yes" title="我要咨询"></a>
                </li>
                <li> <i class="weixin"></i>
                    微信：xiamenui
                </li>
                <li>
                    <i class="tel"></i>
                    电话：0592-5193108 3177731
                </li>
                <li>
                    <i class="mail"></i>
                    邮件：vip@0592ui.com
                </li>
            </ul>


        </div>
        <div class="foot_bottom">
            <p id='maker'>
                友情链接：
                <a href="http://www.0592ui.com/" target="_blank" >厦门网站建设</a>
                <a href="http://weixin.0592ui.com/" target="_blank" >厦门微信营销平台</a>
                <a href="http://www.001studio.com/" target="_blank" >湛江网站建设</a>
                <a href="http://www.uecm.cn/" target="_blank" >十堰网站建设</a>
                <a href="http://www.72en.com/" target="_blank" >营销型网站建设</a>
                <a href="http://www.ihanshi.com/" target="_blank" >郑州网站建设</a>
                <a href="http://www.mcykj.com/" target="_blank" >北京网站设计</a>
                <a href="http://www.ceall.net.cn/" target="_blank" >佛山网络公司</a>
                <a href="http://www.azym.cn" target="_blank" >网站源码</a>
                <a href="http://www.szhrnet.com" target="_blank" >深圳app开发</a>
                <a href="http://www.hfwzdj.com/" target="_blank" >合肥制作网站</a>
                <a href="http://www.52phw.com/" target="_blank" >商丘网站建设</a>
                <a href="http://www.znbo.com/" target="_blank" >网站建设公司</a>
                <a href="http://www.gz898.com/" target="_blank" >广州做网站</a>
            <div style="clear:both;"></div>
            </p>
            <p>厦门创易网络科技有限公司 © 2008-2020 《中华人民共和国增值电信业务经营许可证》ISP/ICP闽B1-20160151 闽ICP备14001588号-1</p>
            <script> var _hmt = _hmt || []; (function() { var hm = document.createElement("script"); hm.src = "https://hm.baidu.com/hm.js?d2914f4b0a6ed08b223ed5bf3e7744dc"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(hm, s); })(); </script>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function($){
            $('.weixin2').click(function(){
                $('.theme-mask').show();
                $('.theme-mask').height($(document).height());
                $('.popover1').slideDown(200);
            })
            $('.close').click(function(){
                $('.theme-mask').hide();
                $('.popover1').slideUp(200);
            })
        })
    </script>

</div>
<script type="text/javascript">
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 5);
</script>
<script type="text/javascript">$(function(){$("#jsa").remove()})</script>
<ul id="side-bar" class="side-pannel side-bar">
    <a title="" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1700781&amp;site=qq&amp;menu=yes" target="_blank" class="qq"><i class="f_top up_qq"></i></a>
    <span class="dh"><i class="f_top up_tel"></i><div class="hide" style="top:-7px"><div class="hied_con"><dl><dt>咨询电话</dt><dt><a href="tel:0592-5193108">0592-5193108</a></dt><dt><a href="tel:0592-5193168">0592-5193168</a></dt></dl></div></div></span>
    <a title="" href="javascript:;" class="wx weixin2 dh"><i class="f_top up_wx"></i><div class="hide" style="top: -45px"><div class="hied_con"><img src="/theme/zhuoxun/static/images/ma2.jpg"></div></div></a>
    <a title="" href="javascript:;" class="gotop" style="display: block;"><i class="f_top up_up"></i></a></ul>
<script type="text/javascript">
    $(function(){
        $(window).scroll(function(){
            if($(window).scrollTop()>120){
                $("#side-bar .gotop").fadeIn();
            }
            else{
                $("#side-bar .gotop").fadeOut();
            }
        });
        $("#side-bar .gotop").click(function(){
            $('html,body').animate({'scrollTop':0},500);
        });
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

