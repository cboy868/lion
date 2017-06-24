<?php
$this->title = '首页';
?>
<!---------------轮播-------------start----->
<div id="myCarousel" class="carousel slide myCarousel carousel-banner">
    <ol class="carousel-indicators" style="margin-top: 70px;">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    </ol>
    <?php $focus = focus(1,5);?>
    <ul class="carousel-inner carousel-min-width">
        <?php foreach ($focus as $f): ?>
        <li class="item">
            <a href="<?=$f['link']?>"
               style="background: url(<?=$f['cover']?>) no-repeat center center!important;"
               target="_blank">
            </a>
        </li>
        <?php endforeach;?>
    </ul>
    <!-- 轮播（Carousel）导航 -->
    <a class="carousel-control left carousel-left" href="#myCarousel"
       data-slide="prev">&lt;</a>
    <a class="carousel-control right carousel-right" href="#myCarousel"
       data-slide="next">&gt;</a>
</div>
<!---------------轮播-------------end----->


<!--互联网时代-->
<div class="mod-wrap" id="mod-wrap">
    <div class="mod-inner">
        <!--标题-->
        <div class="mod-titile">
            <h4>在互联网时代，如何解决网络营销之道</h4>
            <span>华邦多年互联网从业经验，提供高品质的网络营销整合服务，让您离成功更迈进一步</span>
        </div>
        <!--图标内容-->
        <div class="mod-content" id="mod-content">
            <ul class="mod-content-ul" id="mod-content-ul">
                <li>
                    <a href="market.html">
                        <div class="mod-pic"><img src="/theme/stone/static/picture/pic134.png"/></div>
                        <h3>营销网站</h3>
                        <p>专业建站服务</p>
                        <span>开启互联网营销之路</span>
                    </a>
                </li>
                <li>
                    <a href="products.html">
                        <div  class="mod-pic"><img src="/theme/stone/static/picture/pic132.png"/></div>
                        <h3>百度推广</h3>
                        <p>多资源，高流量</p>
                        <span>让有需求的客户找到您</span>
                    </a>
                </li>
                <li>
                    <a href="http://www.appjx.cn/" target="_blank">
                        <div  class="mod-pic"><img src="/theme/stone/static/picture/pic133.png"/></div>
                        <h3>全网营销服务</h3>
                        <p>高效率，高精准</p>
                        <span>提升互联网营销能力</span>
                    </a>
                </li>
                <li>
                    <a href="finance.html">
                        <div  class="mod-pic"><img src="/theme/stone/static/picture/pic130.png"/></div>
                        <h3>百度金融</h3>
                        <p>闪电申请，秒速审批</p>
                        <span>开启互联网营销之路</span>
                    </a>
                </li>
                <li>
                    <a href="nuomi.html">
                        <div class="mod-pic"><img src="/theme/stone/static/picture/pic131.png"/></div>
                        <h3>百度糯米</h3>
                        <p>千万级用户群体</p>
                        <span>解决客户少的问题</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!---------------案例----------start-->

<?php
$cases = cmsArticle(1, null, 10, '420x240');
?>
<div class="anli" id="anli">
    <div class="container container-fixed">
        <p class="text-center text-style-1">从业以来我们的经验案例</p>

        <p class="text-center text-style-2">10年的互联网从业经验，成就了我们如今的专业，让更多的客户走上了网络营销的道路</p>

        <div class="btn-center only">
            <div class="btn-group ">
                <?php foreach ($cases['list'] as $k=>$case):?>
                <button type="button" class="btn btn-lg btn-js btn-js-<?=$case['id']?> <?php if($k==0)echo 'active';?>"><?=$case['name']?></button>
                <?php endforeach;?>
            </div>
        </div>

        <div class="row-div-join" id="row-div-join">
            <?php foreach ($cases['list'] as $k=>$case):?>
            <div class="row-div-<?=$case['id']?>" style="<?php if($k!=0)echo'display:none';?>">
                <div class="row" style="margin-top: 50px;">
                    <?php if (isset($case['child'])):?>
                        <?php foreach ($case['child'] as $v):?>
                        <div class="col-xs-3 div1">
                            <div class="thumbnail div2">
                                <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>" target="_blank">
                                    <img src="<?=$v['cover']?>" style="height: 160px;">
                                </a>
                                <div class="caption">
                                    <p><?=$v['title']?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>

                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!---------------案例----------end-->

<!------------------我们的营销实力--------------start--------------->
<div class="index-big">
    <div class="section translucent-bg bg-image-2 pb-clear" id="pb-clear">
        <div class="container container-fixed object-non-visible" data-animation-effect="fadeIn">

            <p class="text-center font-style1">我们的网络营销实力</p>


            <p class="text-center font-style2" style="margin-top:0;">
                以“专注网络营销服务，为江西80%的企业提供解决方案”为企业使命，现已发展成为省内<br />具有影响力的知名网络服务公司之一。
            </p>

            <div class="row">
                <div class="counter col-xs-4">
                    <div class="thumbnail bg-style1">
                        <div class="caption">
                            <h2 class="timer count-title count-title1" id="count-number" data-to="12" data-speed="1500"
                                style="position: relative">11</h2>
                            <p class="count-text ">与百度深度合作年数</p>
                        </div>
                    </div>
                </div>

                <div class="counter col-xs-4">
                    <div class="thumbnail bg-style1">
                        <div class="caption">
                            <h2 class="timer count-title count-title2" id="count-number2" data-to="38442"
                                data-speed="1500">33886</h2>

                            <p class="count-text ">公司服务客户数</p>
                        </div>
                    </div>

                </div>

                <div class="counter col-xs-4">
                    <div class="thumbnail bg-style1">
                        <div class="caption">
                            <h2 class="timer count-title count-title count-title1" id="count-number3" data-to="24684"
                                data-speed="1500">22682</h2>

                            <p class="count-text ">华邦建站数量</p>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
<!------------------我们的营销实力--------------end--------------->

<!------------------授权代理服务中心----------start---------->
<div class="proxy-center" style="background:url('/theme/stone/static/images/newimg.jpg') no-repeat center center!important;" >
    <a href="about.html"><div style="width:100%;height:100%"></div></a>
</div>
<!------------------授权代理服务中心----------end---------->


<!-----------------华邦最新动态和活动----------start------->
<?php $news=  news(null, 9, '346x231');?>
<div class="dynamic-activity">
    <div class="container container-fixed">
        <p class="text-center text-style-5"><?=g("cp_name")?>最新动态资讯</p>

        <p class="text-center text-style-6">最新动态与活动的聚集地</p>

        <div class="row" style="margin-top: 70px;">
            <?php foreach ($news as $v):?>
            <div class="col-xs-4">
                <div class="thumbnail div3">
                    <a class="div3-min" href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>">
                        <img src="<?=$v['cover']?>">
                    </a>
                    <div class="caption">
                        <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"
                           title="<?=$v['title']?>" class="tooltip-text">
                            <?=$v['title']?>
                        </a>

                        <p class="text-style-7">
                            <?=$v['summary']?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>

        <div class="btn-center">
            <a href="<?=url(['/news/home/default/index'])?>" class="btn-private">查看更多</a>
        </div>
    </div>
</div>

<!-----------------华邦最新动态和活动----------end--------->

<script type="text/javascript">
    $(function(){
        //在可视区域范围内，响应div图标整体向上的动画效果变量声明
        var bbb = 0;
        var dd = 0;
        var c = document.getElementById("mod-content").offsetTop;
        var d = window.pageYOffset||document.documentElement.scrollTop || document.body.scrollTop||0;
        var n = $(window).height();
        var m = d + n;

//      滚动前判断是否在可视区域范围内，"如何解决网络营销之道"模块图标向上移动并出现动画
        if ((c < n && bbb == 0) || (c >= d && c <= m && bbb == 0)) {
            bbb++;
            $("#mod-content").css({
                "top": "140px"
            })
        }

//      滚动前判断是否在可视区域范围内，"从业以来我们的经验案例"模块图标向上移动并出现动画
        var cn=document.getElementById("anli").offsetTop;
        if((cn < n && dd == 0) || (cn >= d && cn <= m && dd == 0)){
            dd++;
            $("#row-div-join").css({
                "top":"300px"
            })
        }

        var b = 0;
        $(window).scroll(function () {
            var top = window.pageYOffset||document.documentElement.scrollTop || document.body.scrollTop||0; /*获取网页被卷去的高度*/

//            滚动到一定距离，右下角的按钮组才出现
            if (top >= 300){
                $(".icon-tool").css({
                    display: "block"
                });
            }else{
                $(".icon-tool").css({
                    display: "none"
                })
            }

//            导航条动画效果
            if (top > 40) {
                $(".navbar-style").addClass("navbar-display");
                $(".header-pos").addClass("header-fixed");
                $(".header-pos .navbar-inverse").css({"box-shadow": "0px 3px 18px -5px #aaa"});
            } else {
                $(".navbar-style").removeClass("navbar-display");
                $(".header-pos").removeClass("header-fixed");
                $(".header-pos .navbar-inverse").css({"box-shadow": "none"});
            }

//           数字从0滚动到指定数值的判断条件，通过start()函数调用index.js执行
            var a = document.getElementById("pb-clear").offsetTop;
            if (a >= top && a <= (top + $(window).height()) && b == 0) {
                //数字跳动调用
                b++;
                start();
            }

//      滚动后判断是否在可视区域范围内，"如何解决网络营销之道"模块图标向上移动并出现动画
            if ((c < n && bbb == 0) || (c >= top && c <= (top + $(window).height()) && bbb == 0)) {
                //图标整体向上
                bbb++;
                $("#mod-content").css({
                    "top": "140px"
                })
            }
//      滚动后判断是否在可视区域范围内，"从业以来我们的经验案例"模块图标向上移动并出现动画
            if((cn < n && dd == 0) || (cn >= top && cn <= (top + $(window).height()) && dd == 0)){
                dd++;
                $("#row-div-join").css({
                    "top":"300px"
                })
            }
        });

//        返回顶部
        $(".goTop").click(function(){
            $("html,body").animate({scrollTop: 0}, "slow");
        });

    })
</script>

<script src="/theme/stone/static/js/index.js" type="text/javascript"></script>

<!--[if IE 8]>
<script type="text/javascript">
    $(function(){
        $(".row-div-join").css({
            "top": "300px"
        })

        $(".mod-content").css({
            "top": "140px"
        })
    })
</script>
<![endif]-->

<script type="text/javascript">
    $(function () {
        //  bootstrap自定义修改轮播自动播放时间
        $('.carousel').carousel({
            interval: 3000
        });

        //轮播图默认显示第一张图片
        $(".carousel-inner.carousel-min-width li").eq(0).addClass("active");

        //轮播小圆点自动匹配轮播图片个数
        var aa = $(".carousel-min-width li").length;
        var bb = $(".carousel-indicators li").length;

        //当图片个数大于小圆点数（实际就是添加了图片）
        while (aa > bb){
            var num = bb - 1;
            $(".carousel-indicators").append("<li data-target='#myCarousel' data-slide-to=''></li>");
            bb++;
            $(".carousel-indicators li").eq(bb -1).attr("data-slide-to",num + 1);
        }

        //当图片个数小于小圆点数（实际就是删除了图片）
        while(aa < bb){
            $(".carousel-indicators li").eq(bb - 1).remove();
            bb--;
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        /*
         *   导航文字颜色切换
         */
        $(".nav-inner.right li").click(function () {
            $(".nav-inner.right li a").css({"color": "#666666"});
            $(this).children("a").css({"color": "#ff5541"})
        });
        /**/
        $(".btn-js").click(function () {
            var i=$(this).index();
            $(this).css({"background": "#e03636", "color": "#fff"})
            $(this).siblings().css({"background": "rgba(255,255,255,0)", "color": "#e03636"});
            $(this).parents(".btn-center.only").next(".row-div-join").children().eq(i).show()
                .siblings().hide();
        });

        /*
         *   弹框
         */
        $("[data-toggle='tooltip']").tooltip();
        $(".header-branch").click(function () {
            $(this).parents(".header").prev(".bomb").delay(100).fadeIn();
            $(this).parents(".header").prev(".bomb").children(".bomb-inner").delay(200).fadeIn();
        });
        $(".bomb-inner-title img").click(function () {
            $(this).parents(".bomb").delay(100).fadeOut();
            $(this).parents(".bomb-inner").delay(200).fadeOut();
        });
    })
</script>