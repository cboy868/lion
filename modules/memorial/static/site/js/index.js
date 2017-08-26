
/**
 * Created by Administrator on 2015/10/9.
 */

$(function(){
    $('#zsList').scrollList({scrollNum:2});
    $('#loveList').scrollList({scrollNum:1,viewNum:2,delayTime:5000});
    $('#visitList').roll(4000);
    $('#mailList').roll(4200);
    $('#onlineList').roll(4000);
    //$('.person').sline({showController:false});
});

$.fn.extend({
    roll:function(delay){
        var rollTime = 0;
        var $this = $(this);
        var roll = function(){
            $this.children('li').last().addClass('cur').hide().remove().clone().insertBefore($this.children('li').eq(0));
            $this.children('li.cur').slideDown('slow',function(){
                $this.removeClass('cur');
            });
        }
        $this.hover(function(){
            clearInterval(rollTime);
        },function(){
            rollTime = setInterval(roll, delay);
        }).trigger("mouseleave");
    },
    getRegion:function(){

    }
});

;(function($) {
    $.fn.scrollList = function(options) {
            var defualts = {
                viewNum : 5,
                scrollNum : 1,
                speed : 500,
                delayTime : 3000,
                auto : true
            };
            var opts = $.extend({}, defualts, options),
                obj = $(this),
                move = 0,
                iShow = obj.children('ul'),
                iItems = iShow.children('li'),
                prev = $(".prev", obj).css('opacity',0.6),
                next = $(".next", obj).css('opacity',0.6),
                itemWidth = iItems.eq(0).outerWidth(true);
                mLen = 0,
                cLen = 0;

            //iShow.css({width:iItems.length*itemWidth+'px'});

            next.on({
                click:function(){
                    nextfun();
                }
            });

            prev.on({
                click:function () {
                    prevfun();
                }
            })

            var nextfun = function(){
                itemWidth = iItems.eq(0).outerWidth(true);
                //iShow.css({width:iItems.length*itemWidth+'px'});
                mLen = itemWidth * opts.scrollNum;
                cLen = (iItems.length - opts.viewNum) * itemWidth;
                if(move < cLen){
                    if((cLen - move) > mLen){
                        iShow.animate({left:"-=" + mLen + "px"}, opts.speed);
                        move += mLen;
                    }else{
                        iShow.animate({left:"-=" + (cLen - move) + "px"}, opts.speed);
                        move += (cLen - move);
                    }
                }else{
                    move = 0;
                    iShow.animate({left:"0px"}, opts.speed);
                }
            }

            var prevfun = function(){
                itemWidth = iItems.eq(0).outerWidth(true);
                //iShow.css({width:iItems.length*itemWidth+'px'});
                mLen = itemWidth * opts.scrollNum;
                cLen = (iItems.length - opts.viewNum) * itemWidth;
                if(move > 0){
                    if(move > mLen){
                        iShow.animate({left: "+=" + mLen + "px"}, opts.speed);
                        move -= mLen;
                    }else{
                        iShow.animate({left: "+=" + move + "px"}, opts.speed);
                        move = 0;
                    }
                }
            }

            //set time
            var settime;

            obj.hover(function () {
                if(iItems.length > opts.viewNum)
                    prev.add(next).fadeIn('fast');

                clearInterval(settime);
            }, function () {
                if(iItems.length > opts.viewNum)
                    prev.add(next).fadeOut('fast');

                settime = setInterval(function () {
                    nextfun();
                }, opts.delayTime);
            }).trigger("mouseleave");
    };
})(jQuery);


