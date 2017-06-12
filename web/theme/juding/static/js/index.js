function startRequest()
        {
        $(".zhanting-toggle").css("height",$(".zhanting-toggle .item").height());
        $(".dongtai-toggle").css("height",$(".dongtai-body .item").height());
       $(".case-toggle").css("height",$(".case-body .item").height());
        $(".zy_main").css("height",$(".jm-tuandui-text").height());
        lcW = $(".jm-qylc-dot li").length * 90;
        $(".jm-qylc-dot ul").css("width",lcW);
        $(".profile5-list .text").css("height",$(".profile5-list .pic").height());
        $(".profile2-dot,.profile2").css("height",$(".profile2-pic li img").height());
        }
$(document).ready(function(){
     setInterval("startRequest()",10);
    $(".pbanner").css("height",$(window).height()-90);
    $(".mbbanner").css("height",$(window).height()-50);
  $(window).on('load resize',function(event) {

        var winH = $(window).height()-90;
        $(".pbanner").css("height",$(window).height()-90);
        $(".mbbanner").css("height",$(window).height()-50);

        $(".zhanting-toggle").css("height",$(".zhanting-toggle .item").height());

        // $(".zhanting-toggle").css("height",500);
        $(".dongtai-toggle").css("height",$(".dongtai-body .item").height());
        // $(".dongtai-toggle").css("height",400);
        $(".case-toggle").css("height",$(".case-body .item").height());
        $(".zy_main").css("height",$(".jm-tuandui-text").height());
        lcW = $(".jm-qylc-dot li").length * 90;
        $(".jm-qylc-dot ul").css("width",lcW);
        $(".profile5-list .text").css("height",$(".profile5-list .pic").height());
        $(".profile2-dot,.profile2").css("height",$(".profile2-pic li img").height());

        // 导航----------
        if($(window).width()>700){
            $(".header-show").css("height","auto");
            // $(".nav-btn").mouseenter(function(event) {
            //     $(".header-see").hide();
            //     $(".header-show").slideDown("fast");
                
            // });
            // $(".header-show").mouseleave(function(event) {
            //     $(this).slideUp('fast', function() {
            //         $(".header-see").show();
            //     });
            // });
            $(".pnav li").hover(function() {
                $(this).addClass('li-on').children('.body').stop().slideDown("slow");
                var aL = $(".headerr-down li").eq(0).find('.head').offset().left;
                $(".headerr-down .pnav-wrap").css("marginLeft",aL);
            }, function() {
                $(this).removeClass('li-on').children('.body').stop().slideUp("slow");
                
            });
        }else{

            $(".header-show").css("height",winH);
            $(".nav-btn").click(function(event) {
                $(".header-see").hide();
                $(".header-show").slideDown("slow");
                
            });

            $(".nav-close").click(function(event) {
                $(".header-show").slideUp("fast", function() {
                    $(".header-see").show();
                });
            });
            $(".pnav li").click(function(event) {
                $(this).children('.body').slideToggle("fast");
                $(this).siblings('li').children('.body').slideUp("fast");
                $(this).toggleClass('li-on').siblings('li').removeClass('li-on');
            });
        }

    });
    // 首页-------------产品展厅
    $(".zhanting-toggle .zhanting-body").eq(0).css({"opacity":1,"zIndex":2});
    $(".zhanting-toggle .zhanting-body").eq(0).css('visibility','visible');
    $(".dongtai-toggle .dongtai-body").eq(0).css({"opacity":1,"zIndex":2});
    $('.dongtai-toggle .dongtai-body').eq(0).css('visibility','visible');
    $(".case-toggle .case-body").eq(0).css('visibility','visible');
    $(".case-toggle .case-body").eq(0).css({"opacity":1,"zIndex":2});
    toggle(".zhanting-head li",".zhanting-toggle .zhanting-body");
    toggle(".dongtai-head li",".dongtai-toggle .dongtai-body");
    toggle(".case-head li",".case-toggle .case-body");

    // 产品展厅
    $(".product1-pic").hover(function() {
        $(this).children('.product1-pic-hover').stop().fadeIn("fast");
    }, function() {
        $(this).children('.product1-pic-hover').stop().fadeOut("fast");
    });
    // 产品展厅2
    $(".product2-toggle .product2-body").eq(0).fadeIn();
    $(".product2-head li").click(function(event) {
        var index = $(this).index();
        $(this).addClass('on').siblings('li').removeClass('on');
        $(".product2-toggle .product2-body").eq(index).fadeIn("fast").siblings('').fadeOut("fast");
    });

    // 加盟页面
    $(".jm_main li").mouseenter(function(event) {
        $(this).addClass('jm-on').siblings('li').removeClass('jm-on');
    });
        // 加盟-高端
    $(".jm-gaoduan-toggle li").eq(0).fadeIn();
    $(".jm-gaoduan li").click(function(event) {
        $(this).addClass('gaoduan-on').siblings('li').removeClass('gaoduan-on');
        var index = $(this).index();
        $(".jm-gaoduan-toggle li").eq(index).fadeIn("slow").siblings('li').fadeOut();
    });

    // 关于轩尼斯
    $(".profile-layout").click(function(event) {
        $(this).fadeOut("fast");
    });
    $(".profile5-list li").click(function(event) {
        $(".profile-layout").fadeIn("slow");
    });
    $(".profile5-focus img").click(function(event) {
        $(".profile-layout").fadeIn("slow");
    });

  $(".profile-layout").click(function(event) {
        $(this).fadeOut("fast");
    });
    //$(".item").click(function(event) {
    //    $(".profile-layout").fadeIn("slow");
    //});
    var profile2L = $(".profile2-pic li").length;
    for(i=0;i<profile2L;i++){
        $(".profile2-dot ol").append("<li></li>");
    }
    var profile2_dots = new Array();
    $(".profile2-pic li").each(function(i) {
        profile2_dots[i] = $(this).find('img').attr("title");
    });
    
    $(".profile2-dot-c li").each(function(i) {
        $(this).text(profile2_dots[i]);
    });
    var num=0;
    var In = 0;
    $(".profile2-pic li").eq(0).show();
    $(".profile2-dot-c li").eq(0).addClass('on');
    // var myIndex = 10
    $(".profile2-dot-c li").click(function(event) {
        // myIndex++
        var index = $(this).index()
        $(this).addClass('on').siblings().removeClass("on");
        $(".profile2-pic li").eq(index).fadeIn("slow").siblings('li').fadeOut("slow");
        if (index>6) {
            In++;
            // if(In>profile2L-11){In==0}
            $(".profile2-dot-c ol").animate({"marginTop":-(index-6)*56}, 200);
        }else{
            In=0;
            $(".profile2-dot-c ol").animate({"marginTop":In*0}, 200);

        }

        num = index;
    });
    $(".profile2-arrow .profile2-next,.profile2-dot .profile2-dot-right").click(function(event) {           
        num++
        // myIndex++
        if(num>profile2L-1){num=0}
        $(".profile2-dot-c li").eq(num).addClass('on').siblings().removeClass("on");
        $(".profile2-pic li").eq(num).fadeIn("slow").siblings('li').fadeOut("slow");
        if (num>6) {
            In++;
            if(In>profile2L-8){In==0}
            $(".profile2-dot-c ol").animate({"marginTop":-(num-6)*56}, 200);
        }else{
            In=0;
            $(".profile2-dot-c ol").animate({"marginTop":In*0}, 200);

        }

    });        
    $(".profile2-arrow .profile2-prev,.profile2-dot .profile2-dot-left").click(function(event) {           
        num--
        // myIndex++            
        if(num<0){num=profile2L-1}
        $(".profile2-dot-c li").eq(num).addClass('on').siblings().removeClass("on");
        $(".profile2-pic li").eq(num).fadeIn("slow").siblings('li').fadeOut("slow");
        if (num>6) {
            In++;
            if(In>profile2L-8){In==0}
            $(".profile2-dot-c ol").animate({"marginTop":-(num-6)*56}, 200);
        }else{
            In=0;
            $(".profile2-dot-c ol").animate({"marginTop":In*0}, 200);

        }
    }); 
    // 企业新闻
    $(".pager-text").focus(function(event) {
        $(this).addClass('pager-on');
    });
    $(".pager-text").blur(function(event) {
        $(this).removeClass('pager-on');
    });
    $(".TV-list li").click(function(event) {
        $(".TV-layout-bg").fadeIn("slow");
        $(".TV-layout").fadeIn("slow");
    });
    $(".TV-layout-bg").click(function(event) {
        $(".TV-layout-bg").fadeOut("fast");
        $(".TV-layout").fadeOut("fast");
        $(".video-js .vjs-tech").get(0).pause();
    });
    // 人才招聘
    $(".talent-close").click(function(event) {
        $(".talent-layout").fadeOut("fast");
    });
    $(".talent-body .more").click(function(event) {
        $(".talent-layout").fadeIn("slow");
    });

    // 首页悬浮窗
    $(".yuyue-click").click(function(event) {
        $(".yuyue-layout").fadeIn("slow");
        $(".yuyue-content").fadeIn("slow");
    });
    $(".yuyue-layout").click(function(event) {
        $(".yuyue-layout").fadeOut("fast");
        $(".yuyue-content").fadeOut("fast");
    });

    // 浮动侧边栏======================================
    $(".float-box").hover(function() {
        $(".float-box p").stop().show("fast");
    }, function() {
        $(".float-box p").stop().hide("fast");
    });
    //订阅号
    $('.dingyue').click(function(){
        $('.weixin-layout').show();
        $('.weixin-content').show();
        $('.dingyue-content').show();
        $('.fuwu-content').hide();
    });
    $('.fuwu').click(function(){
       $('.weixin-layout').show();
        $('.weixin-content').show();
        $('.fuwu-content').show();
         $('.dingyue-content').hide();
    })
    $('.weixin-layout').click(function(){
        $('.weixin-layout').hide();
        $('.weixin-content').hide();
    })
});
function toggle(a,b){
    var myIndex = 10;
    $(a).click(function(event) {
        var index = $(this).index();
        myIndex++;
        $(this).addClass('on').siblings('li').removeClass('on');
        $(b).eq(index).css('visibility','visible').siblings().css('visibility','hidden');
        $(b).eq(index).css({"opacity": 1, "zIndex": myIndex }).siblings().css("opacity",0);
    });
}

// 验证码
function resetVerifyCode(){
    var timenow = new Date().getTime();
    document.getElementById('verifyImage').src= '/index.php?g=Home&m=Index&a=verify#'+timenow;
}


                      
                






































