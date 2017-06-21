<?php
use yii\helpers\Html;
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
    <link type="text/css" rel="stylesheet" href="/theme/tomb/static/css/style.css">
    <link type="text/css" rel="stylesheet" href="/theme/tomb/static/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/theme/tomb/static/css/headerfooter.css">
    <link rel="icon" href="/theme/tomb/static/images//favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/theme/tomb/static/images//favicon.ico" type="image/x-icon">


    <script src="/theme/tomb/static/js/device.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        if(device.mobile()){
            window.location = "http://m.baidujx.com/";  //可以换成http地址
        }
    </script>

    <script src="/theme/tomb/static/js/jquery.min.js" type="text/javascript"></script>
    <script src="/theme/tomb/static/js/bootstrap.min.js" type="text/javascript"></script>

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
                    <ul class="nav navbar-nav navbar-left">
                        <li class="list-inline"><a href=" http://e.baidu.com/localservice?subsite=jx" target="_blank">代理商查询</a></li>
                        <li class="divider"></li>
                        <li><a href="header-branch" data-toggle="modal" data-target="#myModal">查看分公司</a></li>
                        <!-- <li><a href="http://demo.baidujx.com/web4.asp" target="_blank">模板中心</a></li>  -->
                        <li><a href="http://www.baidujx.com/login.php" target="_blank">模板中心</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#financial-center">财务中心</a></li>
                        <li><a href="http://club.baidujx.com/" target="_blank">智营销俱乐部</a></li>
                        <li><a href="fwtk.html" target="_blank" >服务条款 </a></li>

                        <!-- <li class="divider"></li> -->
                        <!-- <li><a href="">问题反馈</a></li> -->
                    </ul>
                </div>
                <div class="col-xs-5 rexian-padding-right">
                    <p class="text-right"><img src="/theme/tomb/static/picture/phone.png"/>免费热线：<b>400-0791-666&nbsp;&nbsp;&nbsp;13970974914</b></p>
                </div>
            </div>
        </div>
    </div>
    <!--导航栏1-->

    <!--导航栏2-->
    <div class="navbar navbar-inverse" id="navbar">
        <div class="container container-fixed">
            <div class="navbar-header">
                <!-- 自适应隐藏导航展开按钮 -->
                <!--  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                         data-target="#navbar-collapse-1">
                     <span class="sr-only">Toggle navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button> -->
                <!-- 导航条LOGO -->
                <a class="navbar-brand navbar-brand-style" href="/">
                    <img src="/theme/tomb/static/picture/pic02.png">
                    <!--<img  src="/theme/tomb/static/picture/happy-new-year.gif" style="height: 60px; margin-left: 10px;">-->
                </a>
            </div>
            <div class="nav-1" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right navbar-nav-ul">
                    <li class="active">
                        <a href="/" class="a-line-height">
                            首页
                        </a>
                    </li>
                    <li class="child ">
                        <a class="a-line-height">
                            产品
                        </a>
                        <ul>
                            <li><a href="products.html">百度推广</a></li>
                            <li><a href="nuomi.html">百度糯米</a></li>
                            <li><a href="market.html">营销网站</a></li>
                            <li><a href="finance.html"  >百度金融 </a></li>
                            <li><a href="http://www.appjx.cn/" target="_blank" class="child-radius">全网服务 </a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="list7.html" class="a-line-height">
                            客户案例
                        </a>
                    </li>
                    <li class="">
                        <a href="list3.html" class="a-line-height">
                            华邦资讯
                        </a>
                    </li>
                    <li class="">
                        <a href="about.html" class="nav-about a-line-height">
                            关于我们
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?=$content?>
<!----------------联系我们、问题咨询-----------start---------->
<div class="contact-us">
    <div class="container container-fixed">
        <div class="row" style="margin-top:90px;">
            <div class="span12">
                <div class="span6 col-xs-6">
                    <form method="post" action="put.php" id="pageForm" name="myForm">
                        <input type="hidden" name="source" value="2" />
                        <input type="hidden" name="template" value="/" />
                        <fieldset>
                            <legend>问题咨询</legend>
                            <input class="form-inline input-1" type="text" name="company" id="fcompany" placeholder="公司名称" autocomplete="off" />
                            <input class="form-inline input-1 input-2" type="text" name="name" id="fname" placeholder="联系人" autocomplete="off" />
                            <input class="form-inline input-1 input-2" type="text" name="phone" id="fphone" placeholder="您的手机号码" autocomplete="off" />

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
                            <input class="form-control" type="text" name="info" placeholder="请用一句简单的话概述您的要求" autocomplete="off" style="margin-top: 40px;" />
                            <button type="submit" class="btn" style="background: #FF4134; color: #fff; margin-top: 40px; font-size: 18px; padding: 6px 20px; border-radius:0;">
                                提交问题，我们帮您解答
                            </button>
                        </fieldset>
                    </form>
                </div>
                <div class="span6 col-xs-6" style="padding-left: 150px;" >
                    <address class="address">
                        <p class="text-style-8" style="margin-bottom:20px;">联系我们</p>
                        <p class="text-style-9">400-0791-666</p>
                        <p class="text-style-9">13970974914</p>
                        地址：南昌市红谷滩新区学府大道899号慧谷创意产业园3楼<br><br>
                        体验中心：上海路699号699创意产业园5A栋<br><br>
                        邮箱：ask@baidujx.com<br>
                        <a role="button" class="text-style-10"  data-toggle="modal" data-target="#myModal">查看其他分公司</a>

                        <div class="div-bg">
                            <div class="div-bg-1">
                                <img src="/theme/tomb/static/picture/pic010.png">
                                <!--<div class="caption">-->
                                <p class="text-style-11">江西华邦服务中心</p>
                                <!--</div>-->
                            </div>

                            <div class="div-bg-2">
                                <img src="/theme/tomb/static/picture/pic012.png">
                                <!--<div class="caption">-->
                                <p class="text-style-11">江西华邦公众号</p>
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
        <p class="pull-left">Copyright 2017 江西华邦传媒有限公司</p>

        <ul class="pull-right">
            <li>
                <a href="http://218.65.88.116/wljg/wwdzbssq/licenceView.pt?licencekey=20160805091948748941&amp;enttype=1" target="_blank">
                    <img src="/theme/tomb/static/picture/pic128.png">
                </a>
            </li>
            <li>
                <a href="https://ss.knet.cn/verifyseal.dll?sn=e13122736010044521evwi000000&amp;ct=df&amp;a=1&amp;pa=0.7373232821026035" target="_blank">
                    <img src="/theme/tomb/static/picture/pic129.png">
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

