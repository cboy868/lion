<?php
use yii\helpers\Html;
use yii\helpers\Url;

 $controller = Yii::$app->controller;
 $controller_id = $controller->id;
 $module_id = $controller->module->id;
 $action_id = $controller->action->id;

 $c_nav = '/'.$module_id .'/'. $controller_id .'/'. $action_id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?= Html::csrfMetaTags() ?>
        <title><?=$this->title?> - <?=g("title")?> - <?=g("cp_name")?></title>
        <?php $this->head() ?>

        <meta name="keywords" content="<?=g("keywords")?>" />
        <meta name="description" content="<?=g("description")?>">
        <meta name="author" content="zhuo-xun.com">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon -->
        <link rel="shortcut icon" href="/theme/zx/static/img/favicon.ico">

        <!-- Web Fonts -->
        <!-- Bootstrap core CSS -->
        <link href="/theme/zx/static/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Font Awesome CSS -->
        <link href="/theme/zx/static/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Fontello CSS -->
        <link href="/theme/zx/static/fonts/fontello/css/fontello.css" rel="stylesheet">

        <!-- Plugins -->
        <link href="/theme/zx/static/plugins/rs-plugin/css/settings.css" media="screen" rel="stylesheet">
        <link href="/theme/zx/static/plugins/rs-plugin/css/extralayers.css" media="screen" rel="stylesheet">
        <link href="/theme/zx/static/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
        <link href="/theme/zx/static/css/animations.css" rel="stylesheet">
        <link href="/theme/zx/static/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">

        <!-- iDea core CSS file -->
        <link href="/theme/zx/static/css/style.css" rel="stylesheet">
        <!-- Color Scheme (In order to change the color scheme, replace the red.css with the color scheme that you prefer)-->
        <link href="/theme/zx/static/css/skins/green.css" rel="stylesheet">

        <!-- Custom css --> 
        <link href="/theme/zx/static/css/custom.css" rel="stylesheet">
        <!-- [if lt IE 9] -->
        <script type="text/javascript"  src="/theme/zx/static/js/html5shiv.js"></script >
        <script type="text/javascript" src="/theme/zx/static/js/selectivizr.js"></script>
        <!--[endif]-->
        
    </head>

<body class="front">
<?php $this->beginBody() ?>
    <div class="scrollToTop"><i class="icon-up-open-big"></i></div>
    <div class="page-wrapper">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-2  col-sm-6">

                        <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"></a><a href="#" class="bds_tsina" data-cmd="tsina"></a><a href="#" class="bds_tqq" data-cmd="tqq"></a><a href="#" class="bds_renren" data-cmd="renren"></a><a href="#" class="bds_weixin" data-cmd="weixin"></a></div>
                        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    </div>
                    <div class="col-xs-10 col-sm-6">

                        <!-- header-top-second start -->
                        <!-- ================ -->
                        <div id="header-top-second"  class="clearfix">
                        </div>
                        <!-- header-top-second end -->

                    </div>
                </div>
            </div>
        </div>
            <header class="header fixed clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">

                            <!-- header-left start -->
                            <!-- ================ -->
                            <div class="header-left clearfix">

                                <!-- logo -->
                                <div class="logo">
                                    <a href="<?=Url::toRoute('/')?>"><img id="logo" src="/theme/zx/static/images/logo_red.png" alt="iDea"></a>
                                </div>

                                <!-- name-and-slogan -->
                                <div class="site-slogan">
<!--                                    简洁、强大公墓办公系统-->
                                </div>

                            </div>
                            <!-- header-left end -->

                        </div>
                        <div class="col-md-9">

                            <!-- header-right start -->
                            <!-- ================ -->
                            <div class="header-right clearfix">

                                <!-- main-navigation start -->
                                <!-- ================ -->
                                <div class="main-navigation animated">

                                    <!-- navbar start -->
                                    <!-- ================ -->
                                    <nav class="navbar navbar-default" role="navigation">
                                        <div class="container-fluid">

                                            <!-- Toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>

                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                                <ul class="nav navbar-nav navbar-right">
                                                    <li class="<?php if($c_nav == '/home/default/index'):?>active<?php endif;?>">
                                                        <a href="<?=Url::toRoute('/')?>" >首页</a>
                                                    </li>
                                                    <!-- mega-menu start -->
                                                    <li class="mega-menu <?php if($c_nav == '/home/default/about'):?>active<?php endif;?>">
                                                        <a href="<?=Url::toRoute('/home/default/about')?>">关于我们</a>
                                                    </li>
                                                    <!-- mega-menu end -->
                                                    <li class="<?php if($c_nav == '/shop/home/default/index'):?>active<?php endif;?>">
                                                        <a href="<?=Url::toRoute('/shop/home/default/index')?>">产品</a>
                                                    </li>
                                                    <!-- mega-menu end -->
                                                    <li class="<?php if($c_nav == '/news/home/default/index'):?>active<?php endif;?>">
                                                        <a href="<?=Url::toRoute('/news/home/default/index')?>">公墓系统思考/博客</a>
                                                    </li>
                                                    <!--
                                                    <li class="">
                                                        <a href="shop-listing-sidebar.html">商城案例</a>
                                                    </li> -->
                                                    <!-- mega-menu start -->
                                                    <li class="mega-menu <?php if($c_nav == '/home/default/contact'):?>active<?php endif;?>">
                                                        <a href="<?=Url::toRoute('/home/default/contact')?>">联系我们</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <!-- navbar end -->
                                </div>
                                <!-- main-navigation end -->
                            </div>
                            <!-- header-right end -->
                        </div>
                    </div>
                </div>
            </header>

    <?=$content?>
    <footer id="footer">
            <!-- .subfooter start -->
            <!-- ================ -->
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <span><?=g("beian")?></span> |
                                <span>Copyright &copy; 2017.<?=g("fullname")?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav class="navbar navbar-default" role="navigation">
                                <!-- Toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>   
                                <div class="collapse navbar-collapse" id="navbar-collapse-2">
                                    <ul class="nav navbar-nav">
                                        <li><a href="<?=Url::toRoute('/')?>">首页</a></li>
                                        <li><a href="<?=Url::toRoute('/home/default/about')?>">关于我们</a></li>
                                        <li><a href="<?=Url::toRoute('/shop/home/default/index')?>">产品</a></li>
                                        <li><a href="<?=Url::toRoute('/news/home/default/index')?>">公墓系统思考/博客</a></li>
<!--                                        <li><a href="--><?//=Url::toRoute('/home/default/about')?><!--">Portfolio</a></li>-->
                                        <li><a href="<?=Url::toRoute('/home/default/contact')?>">联系我们</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .subfooter end -->

        </footer>
        <!-- footer end -->

    </div>

    <!-- JavaScript files placed at the end of the document so the pages load faster
        ================================================== -->
        <!-- Jquery and Bootstap core js files -->
        <script type="text/javascript" src="/theme/zx/static/plugins/jquery.min.js"></script>
        <script type="text/javascript" src="/theme/zx/static/bootstrap/js/bootstrap.min.js"></script>

        <!-- Modernizr javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/modernizr.js"></script>

        <!-- jQuery REVOLUTION Slider  -->
        <script type="text/javascript" src="/theme/zx/static/plugins/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="/theme/zx/static/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

        <!-- Isotope javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/isotope/isotope.pkgd.min.js"></script>

        <!-- Owl carousel javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/owl-carousel/owl.carousel.js"></script>

        <!-- Magnific Popup javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- Appear javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/jquery.appear.js"></script>

        <!-- Count To javascript -->
        <script type="text/javascript" src="/theme/zx/static/plugins/jquery.countTo.js"></script>

        <!-- Parallax javascript -->
        <script src="/theme/zx/static/plugins/jquery.parallax-1.1.3.js"></script>

        <!-- Contact form -->
        <script src="/theme/zx/static/plugins/jquery.validate.js"></script>

        <!-- Initialization of Plugins -->
        <script type="text/javascript" src="/theme/zx/static/js/template.js"></script>

        <!-- Custom Scripts -->
        <script type="text/javascript" src="/theme/zx/static/js/custom.js"></script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
