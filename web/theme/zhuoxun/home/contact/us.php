<?php
$this->title = "联系我们";
?>
<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<script type='text/javascript' src="/theme/zhuoxun/static/js/common.js"></script>
<script type='text/javascript' src="/theme/zhuoxun/static/js/jquery.singlePageNav.min.js"></script>
<script type="text/javascript">
    jQuery(function(){
        $ = jQuery ;
        $("#templatemo_menu").singlePageNav({offset: 600});
    });
</script>
<?php $focus = focus(6, 1, '2560x600')?>
<div class="contact_top_bg" style="background: url(<?=$focus['focus'][0]['cover']?>) center top no-repeat;">
    <!--
    <div class="cmain">
        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=g("qq_kefu")?>&amp;site=qq&amp;menu=yes" target="_black" class="qqmes" title="企业建站咨询">企业建站咨询</a>
        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=g("qq_kefu")?>&amp;site=qq&amp;menu=yes" target="_black" class="qqmes2" title="公墓管理系统咨询">公墓系统咨询</a>
        <a class="tel" href="tel:<?=g("cmobile")?>"></a>
    </div>
    -->
</div>
<!--about-->
<div class="mian_tab navbg"  id="templatemo_menu">
    <ul>
        <div style=" display:inline;">
            <!--
            <li>
            <a href="#templatemo1">我们是谁</a>
          </li>
          -->
            <li>
                <a href="#templatemo2">卓迅公墓管理系统产品优势</a>
            </li>
            <!--
            <li>
                <a href="#templatemo3">我们的团队</a>
            </li>
            -->
            <li>
                <a href="#templatemo4">联系我们</a>
            </li>
        </div>

    </ul>
</div>
<!--mian_tab-->
<script  type="text/javascript">$(".navbg").capacityFixed();</script>
<!--
<div class="main_about"  id="templatemo1">
    <div class="who">
        <div class="title or">
            <h1>关于卓迅</h1>
        </div>
        <p>
            卓迅网络于2017年4月正式成立，主要提供公墓行业互联网+解决方案，
            为企业带来便利同时提高营销水平
        </p>
    </div>

    <div class="bottom">
        <dl>
            <dd>
                <img src="/theme/zhuoxun/static/image/xiangmu_03.jpg"></dd>
            <dt>
            <h2>我们沉浸于用户体验</h2>
            <dt>
            <h2>帮您挖掘和创新更大商机的可能</h2>
            </dt>
        </dl>
        <dl>
            <dd>
                <img src="image/guanyu_06.png"></dd>
            <dt>
            <h2>服务思维下的商业解决方案设计</h2>
            <dt>
            <h2>撇弃浮夸去直达共同的目标</h2>
            </dt>
        </dl>
        <dl>
            <dd>
                <img src="image/guanyu_08.png"></dd>
            <dt>
            <h2>精益合作和分享的态度</h2>
            <dt>
            <h2>让我们鼎力相助你的梦想</h2>
            </dt>
        </dl>
    </div>
</div>
-->
<!--main_about-->
<?php $focus = focus(7, 6, '760x480')?>
<div id="templatemo2"   class="project_gray">
    <div class="project" >
        <div class="title">
            <h1>卓迅公墓管理系统优势</h1>
            <span><?=$focus['cate']['intro']?></span>
        </div>
        <div class="project_con">
            <?php foreach ($focus['focus'] as $v):?>
            <dl>
                <dd >
                    <a href="javascript:;">
                        <img src="<?=$v['cover']?>" alt="<?=$v['title']?>" title="<?=$v['title']?>">
                    </a>
                </dd>
                <dt>
                    <?=$v['intro']?>
                </dt>
            </dl>
            <?php endforeach;?>
        </div>
        <!--project_con-->
    </div>
    <!--project-->
</div>
<!--project_gray-->
<!--
<div class="team_box"  id="templatemo3">
    <div class="team or public">
        <div class="title or">
            <h1>我们的团队</h1>
        </div>
        <div class="top">
            <p>
                我们是追求品质与力求不断超越自己的团队，每一位成员也是亲密的伙伴，与公司一起成长与发展。我们尊重每次合作的机会与挑战，不断精进，
                力求完美。团队秉承专注、专业的设计服务思维，让客户通过设计发挥产品的最大价值，并发掘无限的可能。热爱设计并坚信设计的力量让我们不断前进…
            </p>
        </div>
        <div class="team_con">
            <div class="left_cor">
                <div class="boxgrid" style="background:url(/theme/zhuoxun/static/image/team_2.jpg) no-repeat; background-size:cover;">
                    <div class="cover">
                        <h3>团队建设活动摄影</h3>
                    </div>
                </div>
                <div class="boxgrid" style="background:url(/theme/zhuoxun/static/image/team_3.jpg) no-repeat; background-size:cover;">
                    <div class="cover">
                        <h3>团队建设活动摄影</h3>
                    </div>
                </div>
                <div class="boxgrid" style="background:url(/theme/zhuoxun/static/image/team_4.jpg) no-repeat; background-size:cover;">
                    <div class="cover">
                        <h3>团队建设活动摄影</h3>
                    </div>
                </div>
                <div class="boxgrid" style="background:url(/theme/zhuoxun/static/image/team_5.jpg) no-repeat; background-size:cover;">
                    <div class="cover">
                        <h3>团队建设活动摄影</h3>
                    </div>
                </div>
            </div>
            <div class="right_cor">
                <div class="boxgrid" style="background:url(/theme/zhuoxun/static/image/team_6.jpg) no-repeat; background-size:cover;">
                    <div class="cover1">
                        <h3>团队建设活动摄影</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!--team_box-->
<div class="demand_box" id="templatemo4">
    <div class="demand" id="demand">
        <h1>快速提交您的需求</h1>
        <div class="demand_table">
            <form enctype="multipart/form-data" method="post">
                <div class="row">
                    <label>
                        <span>您的姓名</span>
                        <input type="text" class="txt w1 input1"  name="username"></label>
                    <label>
                        <span>邮箱</span>
                        <input type="text" class="txt w1 input2" name="email"></label>
                </div>
                <!--row-->
                <div class="row">
                    <label>
                        <span>电话</span>
                        <input type="text" class="txt w1 input3"  name="mobile"></label>
                    <label>
                        <span>公司名称</span>
                        <input type="text" class="txt w1 input4" name="company"></label>
                </div>
                <!--row-->
                <div class="row">
                    <label>
                        <span>您的需求描述？</span>
                        <textarea class="txt w2 input5" name="intro"></textarea>
                    </label>
                </div>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <!--row-->
                <div class="row">
                    <input type="submit" class="btn ajaxformbtn" value="发送您的需求">
                    <p class="xin">
                        或者发送商务咨询到邮箱：
                        <a href="mailto:<?=g("uemail")?>"><?=g("uemail")?></a>
                    </p>
                </div>
                <!--row-->
            </form>
        </div>
        <!--demand_table-->
        <!--demand_bottom-->
    </div>
</div>
<!--demand_box-->
<script type="text/javascript"><!--
$(function () {
    <?php
        if (Yii::$app->session->hasFlash('success')) {
            echo 'alert("留言成功，非常感谢您的关注,我们会尽快联系您");';
        }
    ?>
});

    $('.ajaxformbtn').click(function(){
        var status = true;
        if(!$(".input1").val()){
            $(".input1").prev().css('color','red');
            status = false;
        }
        if(!$(".input2").val()){
            $(".input2").prev().css('color','red');
            status = false;
        }else{
            var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
            if (!reg.test($(".input2").val())) {
                $(".input2").val('');
                $(".input2").prev().css('color','red');
                $(".input2").prev().text('邮箱格式不正确');
                $(".input2").prev().css('display','block')
                status = false;
            }
        }
        if(!$(".input3").val()){
            $(".input3").prev().css('color','red');
            status = false;
        }else{
            if ($(".input3").val().length!=11) {
                $(".input3").val('');
                $(".input3").prev().css('color','red');
                $(".input3").prev().text('手机号不正确');
                $(".input3").prev().css('display','block')
                status = false;
            }
        }
        if(!$(".input4").val()){
            $(".input4").prev().css('color','red');
            status = false;
        }
        if(!$(".input5").val()){
            $(".input5").prev().css('color','red');
            status = false;
        }
        if(status==false){
            return false;
        }
    });
    //--></script>