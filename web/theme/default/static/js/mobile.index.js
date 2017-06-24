// JavaScript Document
/*分享插件*/
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];

/*控制页面的高度*/

$(window).on("ready load resize",function(){
    var con = $('#content').height();
    var w_h = $(window).height();
    var w_hh = document.body.scrollHeight;
    var header = $('#header').height();
    var footer = $('#footer').height();
    var s_h=w_h-header-footer;
    var con = $('#content').height();
    if(con<=s_h){
        $('#content').css({'min-height':s_h})
    } else{
        $('#content').css({'height':'auto'})
    }

    var right = w_h-header;
    $('#right').css({'height':w_h});

})

$(function(){
    var w =$(window).width();
    var h =$(window).height();
    $('#closeR').css({'width':w,'height':h})

    $('#header .menu').click(function(){
        if($('#right').css('display') == 'none'){
            $('#right').animate({'right':0},300);
            $('#right').css('display','block');
            $('#header .menu .menua').css('display','none');
            $('#header .menu .menub').css('display','block');
        } else{
            $("#right").animate({
                'right':'-100%'
            },300, function() {
                $('#right').css('display','none');
            });
            // $('#right').animate({'right':'-100%'},200);
            // $('#right').css('display','none');
            $('#header .menu .menua').css('display','block');
            $('#header .menu .menub').css('display','none');
        }
    });

    $('#right ul .one').click(function(){
        var aa=$(this);
        if($(aa).next('.xia2').css('display') == 'block'){
            $(aa).next('.xia2').slideUp();
            $(aa).removeClass('one_on')

        }else{
            $(aa).next('.xia2').slideToggle(200)
            $(aa).siblings('.one').next('.xia2').slideUp();
            $(aa).addClass('one_on').siblings().removeClass('one_on');
        }
    })
    $('#right ul .second').click(function(){
        var aa=$(this);
        if($(aa).next('.xia3').css('display') == 'block'){
            $(aa).next('.xia3').slideUp();
            $(aa).removeClass('second_on')
        }else{
            $(aa).next('.xia3').slideToggle(200)
            $(aa).siblings('.second').next('.xia3').slideUp();
            $(aa).addClass('second_on').siblings().removeClass('second_on');
        }
    })

    $('#header .header_search').click(function(){
        var s =$('#warpper #search');
        if(s.css('display') == 'none'){
            s.css('display','block')
        }else{
            s.css('display','none')
        }

    })


})

$(function(){
    $('inputText').bind({
        focus:function(){
            if (this.value == this.defaultValue){
                this.value="";
            }
        },
        blur:function(){
            if (this.value == ""){
                this.value = this.defaultValue;
            }
        }
    });
})

function tabs(tabTit,on,tabCon){
    $(tabCon).each(function(){
        $(this).children().eq(0).css("display","block");
        $(this).children().eq(0).siblings("div").css("display","none");
    });

    $(tabTit).each(function(){
        $(this).children().eq(0).addClass(on);
    });

    $(tabTit).children().click(function(){
        $(this).addClass(on).siblings().removeClass(on);
        var index=$(tabTit).children().index( $(this) );
        $(tabCon).children().eq(index).css("display",'block').siblings().css("display","none");
    })
}
