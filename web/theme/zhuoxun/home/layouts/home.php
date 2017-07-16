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
    <?php
        if ($this->title) {
            $title = $this->title .' - ' . g('title');
        } else {
            $title = g('title');
        }
    ?>
    <title><?=$title?></title>
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
    <script type="text/javascript" src="/theme/zhuoxun/static/js/jquery.kinmaxshow-1.0.min.js"></script>
    <script src="/theme/zhuoxun/static/js/bootstrap.js"></script>
    <script src="/theme/zhuoxun/static/js/jquery.bootstrap-autohidingnavbar.js"></script>
</head>


<body>
<style>
    .nav > li > a {
        margin-left: 45px;
    }
    /*@media screen and (max-width:992px) {*/
        /*.navbar-header .navbar-brand.abc {*/
            /*width: 100%;*/
            /*display: none;*/
        /*}*/
    /*}*/
    /*@media screen and (max-width:768px) {*/
        /*.navbar-header .navbar-brand.abc {*/
            /*width: 100%;*/
            /*display: inline-block;*/
        /*}*/
    /*}*/
    /*@media screen and (max-width:300px) {*/
        /*.navbar-header .navbar-brand.abc {*/
            /*width: 100%;*/
            /*display: none;*/
        /*}*/
    /*}*/
</style>
<?php $this->beginBody() ?>
<div class="fade out">
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">卓迅网络-公墓管理系统</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand abc" href="/" alt="nice design">
                        <img src="/theme/zhuoxun/static/image/logo2.png" alt="卓迅网络" class="topimg1" title="" />
                        <img src="/theme/zhuoxun/static/image/logo.png" alt="卓迅公墓管理系统" class="topimg2">
                    </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav navbar-right">
                            <?php foreach ($navs as $k => $v):?>
                                <?php if($v['id'] == 2) continue;?>
                                <?php if ($c_nav == $v['url']):?>
                                    <li class='active'>
                                <?php else:?>
                                    <li>
                                <?php endif;?>
                                <li class='<?php if($c_nav == $v['url']):?>active<?php endif;?>' >
                                    <a href="<?=Url::toRoute($v['url'])?>"><?=$v['name']?></a>
                                </li>
                            <?php endforeach;?>
                        </ul>
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
                <img src="/theme/zhuoxun/static/image/footer_logo.png" />
            </div>
            <div class="con">
                <ul class="list1">
                    <li>
                        <h1>公墓管理系统</h1>
                    </li>
                    <li>
                        <a href="<?=url(['/cms/home/grave/index','#'=>'templatemo1'])?>">服务体系</a>
                    </li>
                    <li>
                        <a href="<?=url(['/cms/home/grave/index','#'=>'templatemo2'])?>">解决方案</a>
                    </li>
                    <li>
                        <a href="<?=url(['/cms/home/grave/index','#'=>'templatemo3'])?>">服务优势</a>
                    </li>
                    <li>
                        <a href="<?=url(['/cms/home/grave/index','#'=>'templatemo4'])?>">合作流程</a>
                    </li>
                </ul>
                <ul class="list1">
                    <li>
                        <h1>卓迅知识库</h1>
                    </li>

                    <?php $cates = cmsCates(8, [17,18,19,20,21], 10)?>

                    <?php foreach ($cates as $v): ?>
                    <li>
                        <a href='<?=url(["/cms/home/knowledge/index", "cid"=>$v["id"]])?>'><?=$v['name']?></a>
                    </li>
                    <?php endforeach;?>
                </ul>

                <!--
                <ul class="list1">
                    <li>
                        <h1>新闻动态</h1>
                    </li>

                    <li>
                        <a href='<?=url(['/news/home/default/index','cid'=>1])?>'>公司资讯</a>
                    </li>

                    <li>
                        <a href='<?=url(['/news/home/default/index','cid'=>2])?>'>行业新闻</a>
                    </li>
                </ul>
-->
                <ul class="list1">
                    <li>
                        <h1>联系我们</h1>
                    </li>
                    <li>
                        <a href='<?=url(['/cms/home/contact/us','#'=>'templatemo2'])?>'>产品优势</a>
                    </li>
                    <li>
                        <a href='<?=url(['/cms/home/contact/us','#'=>'templatemo4'])?>'>留言反馈</a>
                    </li>
                </ul>

                <ul class="list1">
                    <li>
                        <h1>合作伙伴</h1>
                    </li>
                    <li>
                        <a href='http://www.stone139.com/' target="_blank">石材</a>
                    </li>
                    <li>
                        <a href="http://www.zhongshenginfo.com/" target="_blank">众盛信息</a>
                    </li>
                </ul>
            </div>

            <style>
                .foot ul.list2 h1 {color: #222}
                .copy_about a.gt{color:#33a600}.foot .copy_about  i.qq{width:18px;height:18px;background:url(/theme/zhuoxun/static/image/copyright_ico.gif) 0 0 no-repeat;display:inline-block;vertical-align:middle}
                .copy_about a.qqmsn{width:78px;height:21px;background:url(/theme/zhuoxun/static/image/copyright_ico.gif) 0 -72px no-repeat;display:inline-block;vertical-align:middle;margin-top:1px}.copy_about .qqtext{display:inline-block;vertical-align:middle}
                .copy_about i.weixin{width:18px;height:18px;background:url(/theme/zhuoxun/static/image/copyright_ico.gif) 0 -18px no-repeat;display:inline-block;vertical-align:middle}.copy_about i.tel{width:18px;height:18px;background:url(/theme/zhuoxun/static/image/copyright_ico.gif) 0 -36px no-repeat;display:inline-block;vertical-align:middle}.copy_about i.mail{width:18px;height:18px;background:url(/theme/zhuoxun/static/image/copyright_ico.gif) 0 -54px no-repeat;display:inline-block;vertical-align:middle}
            </style>
            <ul class="list2 copy_about">
                <li>
                    <h1>联系我们</h1>
                </li>
                <li> <i class="qq"></i>
                    <span class="qqtext">Q Q：</span>
                    <a target="_blank" class="qqmsn" href="http://wpa.qq.com/msgrd?v=3&amp;uin=651199357&amp;site=qq&amp;menu=yes" title="我要咨询"></a>
                </li>
                <li> <i class="weixin"></i>
                    微信：boi531
                </li>
                <li>
                    <i class="tel"></i>
                    电话：<?=g("cmobile")?>
                </li>
                <li>
                    <i class="mail"></i>
                    邮件：<?=g("uemail")?>
                </li>
            </ul>


        </div>
        <?php $links = links(10);?>

        <div class="foot_bottom">
            <p id='maker'>
                友情链接：
                <?php foreach ($links as $v):?>
                <a href="<?=$v['link']?>" target="_blank" ><?=$v['name']?></a>
                <?php endforeach;?>
            <div style="clear:both;"></div>
            </p>
            <p><?=g("reserved")?> <?=g("beian")?><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255593087'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1255593087%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script></p>

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

    <a title="" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=g('qq_kefu')?>&amp;site=qq&amp;menu=yes" target="_blank" class="qq">
        <i class="f_top up_qq"></i>
    </a>
    <span class="dh">
        <i class="f_top up_tel"></i>
        <div class="hide" style="top:-7px">
            <div class="hied_con">
                <dl>
                    <dt>咨询电话</dt>
                    <dt><a href="tel:<?=g("cmobile")?>"><?=g("cmobile")?></a></dt>
                </dl>
            </div>
        </div>
    </span>
    <!--
    <a title="" href="javascript:;" class="wx weixin2 dh">
        <i class="f_top up_wx"></i>
        <div class="hide" style="top: -45px">
            <div class="hied_con">
                <img src="/theme/zhuoxun/static/image/ma2.jpg">
            </div>
        </div>
    </a>
    -->
    <a title="" href="javascript:;" class="gotop" style="display: block;"><i class="f_top up_up"></i></a>
</ul>
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

