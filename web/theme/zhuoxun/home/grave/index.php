<?php
$this->title="公墓管理系统介绍";
?>
<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<script type='text/javascript' src="/theme/zhuoxun/static/js/common.js"></script>
<script type='text/javascript' src="/theme/zhuoxun/static/js/jquery.singlepagenav.min.js"></script>

<script type="text/javascript">
    jQuery(function(){
        $ = jQuery ;
        $("#templatemo_menu ul").singlePageNav({offset: $('#templatemo_menu').outerHeight()});

    });
</script>
<?php $focus = focus(1, 1, '2560x600')?>
<div class="about_box"
     style="background:url(<?=$focus['focus'][0]['cover']?>) no-repeat center top; background-size:cover; width:100%;  ">
</div>
<!--about_box-->
<div class="mian_tab navbg"  id="templatemo_menu">
    <ul>
        <li><a href="#templatemo1">服务体系</a></li>
        <li><a href="#templatemo2">解决方案</a></li>
        <li><a href="#templatemo3">服务优势</a></li>
        <li><a href="#templatemo4">合作流程</a></li>
        <li><a href="#demand">联系我们</a></li>
    </ul>
</div>
<!--mian_tab-->
<script  type="text/javascript">$(".navbg").capacityFixed();
</script>
<div id="templatemo1" class="service1">
    <div class="title">
        <h1>公墓管理模块体系</h1>
    </div>
    <div class="con">
        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_04.png"/> </dd>
            <dt>
            <h2>公墓业务办理</h2>
            </dt>
            <dt> 墓位新购/续费业务 </dt>
            <dt> 安葬业务 </dt>
            <dt> 瓷像/影雕制作 </dt>
            <dt> 碑文自动生成 </dt>
            <dt> 智能保存业务数据 </dt>
        </dl>
        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_12.png"/> </dd>
            <dt>
            <h2>公墓电商</h2>
            </dt>
            <dt> PC端商城 </dt>
            <dt> 微商城 </dt>
            <dt> 商品财务统计 </dt>
            <dt> 商品打包出售设计 </dt>
            <dt> 供货商/进销存管理 </dt>
        </dl>
        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_10.png"/> </dd>
            <dt>
            <h2>微信公众号</h2>
            </dt>
            <dt> 企业风采展示 </dt>
            <dt> 微商城 </dt>
            <dt> 业务咨询办理 </dt>
            <dt> 多公众号运营 </dt>
            <dt> 业务记录及提醒 </dt>
        </dl>
        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_08.png"/> </dd>
            <dt>
            <h2>网络纪念馆</h2>
            </dt>
            <dt> PC端纪念馆 </dt>
            <dt> 公众号端纪念馆 </dt>
            <dt> 建馆申请 </dt>
            <dt> 祝福留言 </dt>
            <dt> 点烛/上香等 </dt>
        </dl>

        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_06.png"/> </dd>
            <dt>
            <h2>公墓门户平台</h2>
            </dt>
            <dt> 新闻资讯 </dt>
            <dt> 个性图文管理 </dt>
            <dt> 客户中心 </dt>
            <dt> 选墓预约 </dt>
            <dt> 全站自定义SEO关键词 </dt>
        </dl>
        <dl>
            <dd> <img src="/theme/zhuoxun/static/image/service_bt_14.png"/> </dd>
            <dt>
            <h2>公墓后台管理</h2>
            </dt>
            <dt> 严谨权限管理 </dt>
            <dt> 客户关系管理(CRM) </dt>
            <dt> 统计报表 </dt>
            <dt> 数据备份及导出 </dt>
            <dt> 员工/客户/业务员管理 </dt>
        </dl>
    </div>
</div>
<!--service1-->
<div id="templatemo2" class="solution">
    <h1>解决方案</h1>
    <div class="con">
        <?php
        $post = cmsCateAndArticle(9, 16, 8, '417x249');
        ?>
        <?php foreach ($post['posts'] as $v):?>
        <dl>
            <dd><a href="javascript:;">
                    <img src="<?=$v['cover']?>" alt="">
                </a>
            </dd>
            <dt>
                <h3><a href="javascript:;"><?=$v['title']?></a></h3>
            </dt>
            <dt><?=$v['summary']?></dt>
        </dl>
        <?php endforeach;?>
    </div>
</div>
<!--solution-->
<div id="templatemo3"   class="project_gray">
    <div class="project" style="margin-top: 0px">
        <div class="title" >
            <h1>服务优势</h1>
            <span>创意、流程、执行缺一不可</span></div>

        <?php $focus = focus(5, 3, '760x480')?>
        <div class="project_con">
            <?php foreach ($focus['focus'] as $v):?>
            <dl>
                <dd ><a href="javascript:;">
                        <img src="<?=$v['cover']?>" alt="">
                    </a>
                </dd>
                <dt><?=$v['intro']?></dt>
            </dl>
            <?php endforeach;?>
        </div>
        <!--project_con--></div>
    <!--project-->
</div>
<!--project_gray-->
<div id="templatemo4"  class="path" >
    <h1>服务流程</h1>
    <div class="pic">
        <img src="/theme/zhuoxun/static/image/path.jpg" title="目标 立项 项目实施 调整 维护">
    </div>
</div>
<!--path-->
<!--client-->
<div class="demand_box" id="templatemo4">
    <div class="demand" id="demand">
        <h1>快速提交您的需求</h1>
        <div class="demand_table">
            <form enctype="multipart/form-data" method="post" action="<?=url('/cms/home/contact/us')?>">
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
        <!--demand_bottom-->
    </div>
</div>
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

<!--  这边放底部  -->


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
<script>
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 5);
</script>

