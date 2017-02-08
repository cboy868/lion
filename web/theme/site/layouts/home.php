<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\HomeAsset;
use yii\helpers\Url;
use app\assets\FontawesomeAsset;

FontawesomeAsset::register($this);
HomeAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head lang="<?= Yii::$app->language ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title><?= Html::encode($this->title) ?>   <?=g('seo_title')?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?=g('seo_description')?>">
        <meta name="keywords" content="<?=g('seo_keywords')?>">
        <meta name="robots" content="INDEX,FOLLOW">

        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>

        <!--[if lt IE 9]>
          <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
    <?php $this->beginBody() ?>
        <div id="notification"></div>
        <div class="wrapper">
            <noscript>
                &lt;div class="global-site-notice noscript"&gt;
                    &lt;div class="notice-inner"&gt;
                        &lt;p&gt;
                            &lt;strong&gt;JavaScript seems to be disabled in your browser.&lt;/strong&gt;&lt;br /&gt;
                            You must have JavaScript enabled in your browser to utilize the functionality of this website.                &lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            </noscript>
            <div class="page no-background">
                <div class="top-header-container">
                    <div class="top-header">
                        <div class="row i-top-links">       
                            <div class="col-md-12 nova-mg-pd">          
                                <p class="welcome-msg pull-right">Welcome to Eleganza Tiles, Inc. </p>
                            </div>
                        </div>
                    </div>

                </div>
                <nav class="navbar">
                      <form class="navbar-form pull-right" role="search">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                      </form>
                </nav>
            <div class="header-container">
                <div class="header">
                    <div class="i-header-content">
                        <div class="row nova-mg-pd">
                            <div class="col-md-12">
                                <div class="header-center">                     
                                    <h1 class="logo"><a href="#" title="Eleganza Tiles, Inc." class="logo"><img src="/theme/site/static/img/logo.png" alt="Eleganza Tiles, Inc."></a></h1>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="navbar<!--  navbar-default -->" role="navigation">
                  <div class="container-fluid col-md-6 col-md-offset-3">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="#"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" style="font-size:120%">
                      <ul class="nav navbar-nav">
                        <li class=""><a href="<?=Url::toRoute('default/index')?>">Home</a></li>
                        <li class=""><a href="<?=Url::toRoute('about/index')?>">About Us</a></li>
                        <li class=""><a href="<?=Url::toRoute('product/index')?>">Products</a></li>
                        <li><a href="<?=Url::toRoute('resources/index')?>">Resources</a></li>
                        <li><a href="<?=Url::toRoute('about/contact')?>" class="level-top">Contact Us</a></li>  
                      </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
                </nav>
            </div>
            <!-- header finish -->


            <?= $content ?>

            <div class="newsletter-box">
                <form action="#" method="post" id="newsletter-validate-detail">

                    <div class="form-group field-contactform-email col-sm-offset-3" style="padding-top:15px;text-align:left">
                        <div class="input-group col-sm-6 ">
                          <input type="text" class="form-control email" placeholder="SIGN UP FOR NEWSLETTER" data-required>
                          <span class="input-group-btn">
                            <button class="btn btn-warning ebtn" type="button" style="background-color:#E28903" data-loading-text="committing...">SUBMIT</button>
                          </span>
                        </div><!-- /input-group -->
                          <div class="help-block error pull-"></div>

                    </div>

                </form>
            </div>
        <div class="footer-container">
            <div class="footer-aditional">
                <div class="box-border-3 border-top pading-top-bottom-20">
                    <div class="col-md-6">
                        <div class="bottom-menu-column ">
                            <div class="col-md-4">
                            <h4>Resources</h4>
                            <div class="block-content" style="display: block;">
                            <ul class="bottom-menu">
                             <?php 
                                $lists = focus(4, 5);
                             ?>
                             <?php foreach ($lists as $v): ?>
                                <li><a href="<?=$v['link']?>" target="_blank"><?=$v['title']?></a></li>
                             <?php endforeach ?>
                            </ul>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <h4>Company</h4>
                            <div class="block-content" style="display: block;">

                            <ul class="bottom-menu">
                            <li><a href="<?=Url::toRoute(['about/view', 'mod'=>3, 'id'=>1])?>" target="_blank">About Us</a></li>
                            <li><a href="<?=Url::toRoute(['about/contact'])?>" target="_blank">Contact Us</a></li>
                            <li><a href="<?=Url::toRoute(['about/view', 'mod'=>3, 'id'=>2])?>" target="_blank">Employment</a></li>
                            </ul>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <h4>Partner Links</h4>
                            <div class="block-content" style="display: block;">
                            <?php $list = links(3)?>
                            <ul class="bottom-menu">
                            <?php foreach ($list as $v): ?>
                                <li><a href="<?=$v['link']?>" target="_blank"><?=$v['name']?></a></li>
                            <?php endforeach ?>
                            </ul>
                            </div>
                            </div>
                        </div>                              
                    </div>

                    <div class="col-md-3" style="text-align:left">
                        <div class="bottom-menu-column ">
                            <div class="col-md-12">
                                <h4>Latest NEWS</h4>
                                <div class="block-content" style="display: block; text-align:left;">
                                <ul class="bottom-menu">
                                 <?php 
                                    $lists = postList(5);
                                 ?>
                                 <?php foreach ($lists as $v): ?>
                                    <li><a href="<?=$v['url']?>" target="_blank"><?=$v['title']?></a></li>
                                 <?php endforeach ?>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    </div>      
                </div>
           </div>
        </div>
        <div class="copyright-footer">
            <div class="footer">
                <div class="row nova-mg-pd">        
                    <div class="col-xs-12 col-sm-6 col-md-8 nova-mg-pd">                    
                        <address>© 2015 Eleganza Tiles, Inc. All Rights Reserved.<span><a href="<?=url(['/admin/default/login'])?>">管理中心</a></span></address>

                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 payment-logo nova-mg-pd">
                                     
                    </div>
                </div>
            </div>
        </div>
        

        </div>
    </div>


    <a href="#page" id="toTop" style="display: block;"><span id="toTopHover"></span>To Top</a>

<?php $this->endBody() ?>

<?php $this->beginBlock('ease') ?>  
    jQuery(document).ready(function() {
        jQuery().UItoTop({ easingType: 'easeOutQuart' });  

        $('button.ebtn').click(function(e){
            e.preventDefault();
            
            var email = $('.email').val();

            if (email.length == 0) {$('.error').text('邮箱不可为空');return}

            var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

            if(!emailreg.test(email)) {
                {$('.error').text('请填写正确的邮箱格式');return}
            }

            var btn = $(this);
            btn.button('loading');

            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";

            var url = "<?=Url::toRoute(['default/email'])?>";
            $.post(url, {email:email, _csrf:csrf}, function(xhr){
                $('.error').text(xhr.info);
                setTimeout(function () {
                    btn.button('reset');
                }, 1000);
            },'json');
        }); 


    });
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['ease'], \yii\web\View::POS_END); ?>  


    </body>
</html>
<?php $this->endPage() ?>
