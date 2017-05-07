/**
 * JSer: mayichao
 * Date: 14-3-14
 * 公共类
**/

YW = {

    Localtion : function (naLabel, _this, padLeft){
        naLabel.stop().animate({
            left: _this.position().left + 'px',
            width: _this.width() + padLeft*2 + 'px'
        }, 300);
    },

    ShowHide : function(_class, _scrollTop){
        if(_scrollTop > 100){
            _class.stop().fadeTo(200, 1);
        }else{
            _class.stop().fadeTo(200, 0 ,function(){
                _class.hide();
            });
        }   
    },

    BackTo : function(obj){
        obj.each(function(i, item){
            var $this = $(this);
            var target = $this.data('to');
            target_offset = $(target).offset().top;
            $('html, body').stop().animate({scrollTop: target_offset}, 300); 
        });   
    },

    NavMove : function(){
        //导航hover
        var $nav = $('.header ul.nav');
        var $navLi = $('.header ul.nav li');
        var $naLabel = $('.header ul.nav li.nav_lable');
        var $aItem = $navLi.find('a');
        var $padLeft = parseInt($aItem.css('paddingLeft'));

        $navLi.each(function(){
            var $this = $(this);
            if($this.hasClass('active')){
                $naLabel.css({
                    left: $this.position().left + 'px' 
                });
            }
        });
        $aItem.hover(function (){
            
            var $this = $(this);

            if($this.parent('li').hasClass('active')){
                YW.Localtion($naLabel, $this, $padLeft);

                return;
            }
            $naLabel.show();
            YW.Localtion($naLabel, $this, $padLeft);

        });
        $nav.mouseleave(function (){
            $naLabel.stop().hide();
        });
    },

    BackTop : function(){
        //返回顶部
        var $html = '<div class="back_top png" data-to="body"></div>';
        $('body').append($html);

        var backTopBtn = $('.back_top');
        $(window).scroll(function(e){
            e.preventDefault();
            var _scrollTop = $(this).scrollTop();
            YW.ShowHide(backTopBtn, _scrollTop);
        });     
        backTopBtn.click(function(e){
            e.preventDefault();
            var _this = $(this);
            YW.BackTo(_this);
        });
    },

    EvenColor : function(){
        // 列表隔行变色
        var aListEven = $('.news_list li:even');
        aListEven.each(function(i, item){
            var $this = $(this);
            $this.addClass('even');
        });
    },

    RqCodeSizeChange : function(){
        var $html = '<div class="rq_code_ab"><img src="/static/skin/img/sacrifice/rq_code_img.jpg" /></div>',
            saCon = $('.sa_con');

            saCon.append($html);

        var rqCodeImg = saCon.find('.rq_code_ab img'),
            rqCodeSize = rqCodeImg.width();

        rqCodeImg.hover(function(){

            var $this = $(this);
            $this.stop().animate({
                width : rqCodeSize*2,
                height : rqCodeSize*2,
                marginLeft : Math.round(-rqCodeSize/2),
                marginTop : Math.round(-rqCodeSize/2)
                
            }, 300, function(){
                $(this).css({
                    boxShadow : '2px 2px 3px rgba(0,0,0,.5)'
                });
            });

        }, function(){

            var $this = $(this);
            $this.stop().animate({
                width : rqCodeSize,
                height : rqCodeSize,
                marginLeft : 0,
                marginTop : 0
            }, 300,function(){
                $(this).css({
                    boxShadow : 'none'
                });
                $(this).removeAttr('style');
            });
            
        });
    }

};
$(function(){
    YW.NavMove();
    YW.BackTop();
    YW.EvenColor();
    YW.RqCodeSizeChange();
});
function vhCenter(obj, maxHeight, maxWidth, border, backgroundColor, loadingImg){
    if (obj == undefined || maxHeight == undefined || maxWidth == undefined) {
        return;
    }
    var backgroundColor = backgroundColor || "#FFFFFF";
    var border = border || "1px solid #CCCCCC";
    var loadingImg = loadingImg || true;
    var imgPad = function(imgObj){
        var cssAttr = {"background":backgroundColor};
        var paddingV = paddingH = 0;
        var imgHeight = imgObj.height();
        var imgWidth  = imgObj.width();
        if (imgHeight == 0) {
            $("body").append('<div id="tmpImg" style="position:absolute;width:0px;visibility:hidden;overflow:hidden;"><img src="'+imgObj.attr('src')+'" /></div>');
            imgHeight = $("#tmpImg > img").height();
            imgWidth = $("#tmpImg > img").width();
            $("#tmpImg").remove();
        }
        if (imgHeight < maxHeight) {
            paddingV = (maxHeight - imgHeight)/2;
            $.extend(cssAttr, {"padding-top":paddingV, "padding-bottom":paddingV});
        }
        if (imgWidth < maxWidth) {
            paddingH = (maxWidth - imgWidth)/2;
            $.extend(cssAttr, {"padding-left":paddingH, "padding-right":paddingH});
        }
        if (border != 'none') {
            $.extend(cssAttr, {"border":border});
        }
        imgObj.css(cssAttr);
    };
    $.each(obj, function(k, v){
        var img = $(v);
        if (loadingImg) {
            img.hide();
            var divWidth = maxWidth+2, divHeight = maxHeight+2;
            if (border == 'none') {
                divWidth = maxWidth;
                divHeight = maxHeight;
            }
            img.before('<div class="loadingImg" style="width:'+divWidth+'px; height:'+divHeight+'px;"></div>');
        }
        img.load(function(){
            imgPad(img);
            if (loadingImg) {
                img.prev("div.loadingImg").hide();
                img.show();
            }
        });
        $(window).load(function(){
            imgPad(img);
            if (loadingImg) {
                img.prev("div.loadingImg").hide();
                img.show();
            }
        });
    });
}