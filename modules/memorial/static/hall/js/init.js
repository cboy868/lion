/**
 * Created by yc on 2015/8/11.
 */

// overflow hide
$.fn.sline = function (options) {
    var defaults = {
        chidrenEle : 'li',
        selfWidth : 0
    };

    var opts = $.extend(defaults, options);
    var _self = $(this);
    var _wrapper = _self.children();
    var _wrapperWidth = 0;

    _self.children().children(opts.chidrenEle).each(function(){
        _wrapperWidth += $(this).outerWidth(true);
    });

    if(!opts.selfWidth)
        opts.selfWidth = _self.width();

    _wrapper.width(_wrapperWidth);
    var _offset = _wrapper.height() / 2 - 10;

    if(opts.selfWidth < _wrapper.width()){
        _self.parent().prepend('<a class="sline_prev" href="javascript:;"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="sline_next" href="javascript:;"><span class="glyphicon glyphicon-chevron-right"></span></a>');
        _self.parent().children('.sline_next').add(_self.parent().children('.sline_prev')).css('top', _offset).click(function(){
            var _move = opts.selfWidth;
            var left = 0;
            if($(this).is('.sline_next')) {
                left = _self.scrollLeft() + _move;
            }else{
                left = _self.scrollLeft() - _move;
            }
            _self.animate({scrollLeft:left});
        });
    }

    _wrapper.children().children().click(function(){
        if(opts.selfWidth != _self.width())
            opts.selfWidth = _self.width();

        //$(this).parent().addClass('active').siblings().removeClass('active');
        var left =  $(this).parent()[0].offsetLeft;
        left -= (opts.selfWidth/2) - ($(this).parent().width()/2);
        _self.animate({scrollLeft: left});
    });

}

$('.person-info').sline({selfWidth:233});

//input num
$(document).on('blur', '._num', function(){
//$("._num").blur(function() {
    //var num = $(this).val();
    //var limit = $(this).attr('data-limit');
    //num = parseInt(num);
    //num = isNaN(num) ? 1 : num;
    //num = num <= 0 ? 1 : num;
    //num = num >= limit ? limit : num;
    //$(this).val(num);
});

// counter
$.fn.mCounter = function(options) {
    var defaults = {
        changeEle: null,
        baseData: 0
    };
    var opts = $.extend(defaults, options);
    this.each(function(){
        var mCounter = $(this);
        var limit = mCounter.attr("data-limit");
        limit = limit == "" ? 1 : limit;
        var textEle = mCounter.children("input:text");

        var changeValue = 0;
        if(opts.changeEle != null && opts.baseData != 0) {
            changeValue = parseInt(opts.baseData);
        }
        var temp = 0;

        // minus
        mCounter.children("a").first().click(function(){
            var num = textEle.val();
            num = num == "" ? 1 : num;
            num = parseInt(num);
            num--;
            num = num <= 0 ? 1 : num;
            if(opts.changeEle != null) {
                temp = num * changeValue;
                opts.changeEle.text(temp.toFixed(2));
            }
            textEle.val(num);
        });
        // add
        mCounter.children("a").last().click(function(){
            var num = textEle.val();
            num = num == "" ? 1 : num;
            num = parseInt(num);
            num++;
            num = num >= limit ? limit : num;
            if(opts.changeEle != null) {
                temp = num * changeValue;
                opts.changeEle.text(temp.toFixed(2));
            }
            textEle.val(num);
        });
        // input
        textEle.blur(function() {
            var num = $(this).val();
            num = parseInt(num);
            num = isNaN(num) ? 1 : num;
            num = num <= 0 ? 1 : num;
            num = num >= limit ? limit : num;
            if(opts.changeEle != null) {
                temp = num * changeValue;
                opts.changeEle.text(temp.toFixed(2));
            }
            textEle.val(num);
        });
    });
};

$.fn.imgHover = function (options) {
    var defaults = {
        childrenEle: 'dd',
        hover_width: 227,
        hover_height: 269
    };
    var opts = $.extend(defaults, options);
    var self = $(this);
    var itemWidth = $(this).children(opts.childrenEle).outerWidth();
    var itemHeight = $(this).children(opts.childrenEle).outerHeight();

    $(this).children(opts.childrenEle).addClass('is-loading');

    self.imagesLoaded()
        .always(function (instance) { })
        .done(function (instance) { })
        .fail(function () { })
        .progress(function (instance, image) {
            var $item = $(image.img).parent();
            $item.removeClass('is-loading');

            if (image.isLoaded) {
                var imageOffset = 0;
                var containerOffset = $(image.img).width() / 2;
                if ($(image.img).width() > itemWidth) {
                    imageOffset = ($(image.img).width() - itemWidth) / 2;
                } else {
                    $(image.img).css('width', itemWidth);
                    containerOffset = itemWidth / 2;
                    imageOffset = 0;
                }
                $(image.img).css('margin-left', -imageOffset + 'px').fadeIn();
                $item.hover(function (e) {
                    e.stopPropagation();
                    $(this).find('img').css('margin-left', 0);
                    $(this).css({ 'position': 'absolute', 'top': $(this).position().top, 'height': 'auto', 'z-index': '10', 'overflow': 'auto', marginLeft: -containerOffset + 'px', left: '50%' }).addClass('hover').stop().animate({
                        top: '18px'
                    }, 100);
                }, function () {
                    $(this).find('img').css('margin-left', -imageOffset + 'px');
                    $(this).css({ 'z-index': '0' }).removeClass("hover").stop().animate({
                    }, 100, function () {
                        $(this).removeAttr('style');
                    });
                });
            } else {
                $item.addClass('is-broken');
            }
        });
}


// load img
var imagesLoad = function (ele) {
    ele.imagesLoaded()
        .always( function( instance ) {
        })
        .done( function( instance ) {
        })
        .fail( function() {
        })
        .progress(function (instance, image) {
            var $item = $( image.img ).parent();
            $item.removeClass('is-loading');
            $(image.img).fadeIn();
            if ( !image.isLoaded ) {
                $item.addClass('is-broken');
            }
        });
}



//get url action
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return false;
    }
})();


//(function($) {
//    $.fn.popImage = function(f) {
//        var s = $.extend({}, $.fn.popImage.defaultSettings, f || {});
//        if ($("#popImage_cache").length == 0) {
//            $("<div id='popImage_cache'></div><div class='popImage_close'></div>").appendTo("body")
//        }
//        var g = $("#popImage_cache img").length;
//        return this.each(function(c) {
//            var d = $(this),
//                iw = d.outerWidth(),
//                ih = d.outerHeight(),
//                imgUrl = this[s.tagName],
//                c = g + c,
//                this_id = "slide" + c;
//            $('<img src="' + imgUrl + '" class="popImage_cached ' + this_id + '" title="click to close"/>').appendTo("#popImage_cache").hide();
//            d.click(function(e) {
//                var b = $('#popImage_cache .' + this_id),
//                    w_w = $(window).width(),
//                    w_h = $(window).height(),
//                    st = $(window).scrollTop();
//                $('.popImage_close').hide();
//                e.preventDefault();
//                position = d.offset(), o_h = b.height(), o_w = b.width();
//                var t = st + (w_h - o_h) / 2,
//                    l = (w_w - o_w) / 2;
//                b.css({
//                    'left': position.left,
//                    'top': position.top,
//                    'height': ih,
//                    'width': iw
//                });
//                $('.popImage_cached').hide();
//                b.show().fadeTo(0, 0.9);
//                b.animate({
//                    'left': l,
//                    'top': t,
//                    'height': o_h,
//                    'width': o_w,
//                    'opacity': 1
//                }, s.timeOut, function() {
//                    var a = b.offset();
//                    $('.popImage_close').css({
//                        'left': a.left + o_w - 18,
//                        'top': a.top - 15
//                    }).show()
//                })
//            });
//            $('.popImage_close,.popImage_cached').bind('click', function(a) {
//                $('.popImage_close').hide();
//                $('.popImage_cached').fadeOut(400, function(){
//                    $('.popImage_cached').removeAttr('style').hide();
//                });
//                a.preventDefault()
//            })
//        })
//    };
//    $.fn.popImage.defaultSettings = {
//        "tagName": "href",
//        "timeOut": "600"
//    }
//})(jQuery);