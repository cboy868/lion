<?php
use yii\helpers\Html;
use app\core\widgets\Alert;


$controller = Yii::$app->controller;
$controller_id = $controller->id;
$module_id = $controller->module->id;
$action_id = $controller->action->id;

$c_nav = $module_id .'_'. $controller_id .'_'. $action_id;
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="keywords" content="<?=g("keywords")?>" />
    <meta name="description" content="<?=g("description")?>" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?=g("title")?></title>
    <?php $this->head() ?>
    <link type="text/css" rel="stylesheet" href="/theme/stone/static/css/style.css">
    <link type="text/css" rel="stylesheet" href="/theme/stone/static/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/theme/stone/static/css/headerfooter.css">
    <link rel="icon" href="/theme/stone/static/images//favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/theme/stone/static/images/favicon.ico" type="image/x-icon">

    <script src="/theme/stone/static/js/jquery.min.js" type="text/javascript"></script>
    <script src="/theme/stone/static/js/bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".bomb-inner-content-pl li").click(function(){
                $(this).addClass("active").siblings().removeClass("active");
            });
        })
    </script>
</head>


<body>
<?php $this->beginBody() ?>

<!--头部的开始-->
<div class="header-pos" style="min-width: 1170px;">
    <div class="navbar navbar-style">
        <div class="container container-fixed">
            <div class="row">
                <div class="col-xs-7 head-padding">
                </div>
                <div class="col-xs-5 rexian-padding-right">
                    <p class="text-right">
                        <img src="/theme/stone/static/picture/phone.png"/>热线电话：
                        <b><?=g("hotline")?></b>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--导航栏1-->

    <!--导航栏2-->
    <div class="navbar navbar-inverse" id="navbar">
        <div class="container container-fixed">
            <div class="navbar-header">
                <!-- 导航条LOGO -->
                <a class="navbar-brand navbar-brand-style" href="/">
                    <img src="<?=g("logo")?>" width="406" height="46">
                </a>
            </div>

            <div class="nav-1" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right navbar-nav-ul">
                    <li class="<?php if($c_nav == 'home_default_index')echo'active';?>">
                        <a href="/" class="a-line-height">
                            首页
                        </a>
                    </li>
                    <li class="child <?php if($c_nav == 'shop_home_default_index')echo'active';?>">
                        <a class="a-line-height" href="<?=url(['/shop/home/default/index'])?>">
                            产品
                        </a>

                    </li>
                    <li class="<?php if($c_nav == 'cms_home_case_index')echo'active';?>">
                        <a href="<?=url(['/cms/home/case/index'])?>" class="a-line-height">
                            客户案例
                        </a>
                    </li>
                    <li class="<?php if($c_nav == 'news_home_default_index')echo'active';?>">
                        <a href="<?=url(['/news/home/default/index'])?>" class="a-line-height">
                            <?=g('cp_name')?>资讯
                        </a>
                    </li>
                    <li class="<?php if($c_nav == 'cms_home_about_us')echo'active';?>">
                        <a href="<?=url(['/cms/home/about/us'])?>" class="nav-about a-line-height">
                            关于我们
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?=Alert::widget()?>
<?=$content?>
<!----------------联系我们、问题咨询-----------start---------->
<div class="contact-us">
    <div class="container container-fixed">
        <div class="row" style="margin-top:90px;">
            <div class="span12">
                <div class="span6 col-xs-6">
                    <form method="post" action="<?=url(['/cms/home/contact/msg'])?>" id="pageForm" name="myForm">
                        <input type="hidden" name="source" value="2" />
                        <input type="hidden" name="template" value="/" />
                        <fieldset>
                            <legend>问题咨询</legend>
                            <input name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" type="hidden">
                            <input class="form-inline input-1" type="text" name="company" id="fcompany" placeholder="公司名称" autocomplete="off" />
                            <input class="form-inline input-1 input-2" type="text" name="username" id="fname" placeholder="联系人" autocomplete="off" />
                            <input class="form-inline input-1 input-2" type="text" name="mobile" id="fphone" placeholder="您的手机号码" autocomplete="off" />

                            <span class="help-block span-style">您的企业现在面临的问题？</span>
                            <div>
                                <label class="checkbox checkbox-inline-1">
                                    <input type="checkbox" name="problem[]" value="不知道怎么开始网络营销" /> 不知道怎么开始网络营销？
                                </label>
                                <label class="checkbox checkbox-inline-1 ">
                                    <input type="checkbox" name="problem[]" value="不知如何利用已有网站" /> 不知如何利用已有网站？
                                </label>
                            </div>
                            <div>
                                <label class="checkbox checkbox-inline-1">
                                    <input type="checkbox" name="problem[]" value="不知怎样提升营销效果" /> 不知怎样提升营销效果？
                                </label>
                                <label class="checkbox checkbox-inline-1 ">
                                    <input type="checkbox" name="problem[]" value="其他" />其他
                                </label>
                            </div>
                            <input class="form-control" type="text" id="ftitle" name="title" placeholder="请用一句简单的话概述您的要求" autocomplete="off" style="margin-top: 40px;" />
                            <button type="submit" class="btn" style="background: #FF4134; color: #fff; margin-top: 40px; font-size: 18px; padding: 6px 20px; border-radius:0;">
                                提交问题，我们帮您解答
                            </button>
                        </fieldset>
                    </form>
                </div>
                <div class="span6 col-xs-6" style="padding-left: 150px;" >
                    <address class="address">
                        <p class="text-style-8" style="margin-bottom:20px;">联系我们</p>
                        <p class="text-style-9"><?=g("cmobile")?></p>
                        地址：<?=g("address")?><br><br>
                        邮箱：<?=g("uemail")?><br>

                        <div class="div-bg">
                            <div class="div-bg-2">
                                <img src="/theme/stone/static/picture/pic012.png">
                                <!--<div class="caption">-->
                                <p class="text-style-11"><?=g("cp_name")?>公众号</p>
                                <!--</div>-->
                            </div>
                        </div>
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
<!----------------联系我们、问题咨询-----------end------------>
<!-----------------footer---------------->
<footer class="footer">
    <div class="container container-fixed footer-div clearfix">
        <p class="pull-left"><?=g("reserved")?></p>

        <ul class="pull-right">
            <li>
                <a href="#" target="_blank">
                    <img src="/theme/stone/static/picture/pic128.png">
                </a>
            </li>
            <li>
                <a href="#" target="_blank">
                    <img src="/theme/stone/static/picture/pic129.png">
                </a>
            </li>
        </ul>
    </div>
</footer>
<!-----------------footer---------------->

<!–[if lt IE 8]>
<script type="text/javascript">
    $(function(){
        //  使用jquery解决ie8不支持input表单placeholder属性问题
        $('[placeholder]').focus(function() {//获取焦点
            var input = $(this);
//val()读取表单元素的value值，attr()设置或返回被选元素的属性
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {//失去焦点
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur().parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    })
</script>
<![endif]–>

<script type="text/javascript">
    $(function(){
        $('#pageForm').submit(function(event){
            if(!check()){
                event.preventDefault();
                return false;
            }
        });

        $('#zixunform').submit(function(event){
            if(!checks()){
                event.preventDefault();
                return false;
            }
        });

    });

    function check()
    {
        var company = $('#fcompany');
        var name = $('#fname');
        var tel = $('#fphone');
        var title = $('#ftitle');

        if(!company.val().trim()){
            alert("请输入您的公司名称！");
            company.focus();
            return false;
        }
        if(!name.val().trim()){
            alert("请输入您的称呼！");
            name.focus();
            return false;
        }

        if(!title.val().trim()){
            alert("请简单描述您的要求！");
            title.focus();
            return false;
        }

        if(!/^1[3|4|5|7|8]\d{9}$/.test(tel.val())){
            alert("请填写正确的手机号");
            tel.focus();
            tel.val("");
            return false;
        }
        return true;
    }

    function checks()
    {
        var company = $('#mcompany');
        var name = $('#mname');
        var tel = $('#mphone');

        if(!company.val().trim()){
            alert("请输入您的公司名称！");
            company.focus();
            return false;
        }
        if(!name.val().trim()){
            alert("请输入您的称呼！");
            name.focus();
            return false;
        }

        if(!/^1[3|4|5|7|8]\d{9}$/.test(tel.val())){
            alert("请填写正确的手机号");
            tel.focus();
            tel.val("");
            return false;
        }
        return true;
    }
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

