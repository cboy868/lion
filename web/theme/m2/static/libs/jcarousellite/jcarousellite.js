/**
 * jCarouselLite - jQuery plugin to navigate images/any content in a carousel style widget.
 * @requires jQuery v1.2 or above
 *
 * http://gmarwaha.com/jquery/jcarousellite/
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 1.0.1
 * Note: Requires jquery 1.2 or above from version 1.0.1
 */

/**
 * Creates a carousel-style navigation widget for images/any-content from a simple HTML markup.
 *
 * The HTML markup that is used to build the carousel can be as simple as...
 *
 *  <div class="carousel">
 *      <ul>
 *          <li><img src="image/1.jpg" alt="1"></li>
 *          <li><img src="image/2.jpg" alt="2"></li>
 *          <li><img src="image/3.jpg" alt="3"></li>
 *      </ul>
 *  </div>
 *
 * As you can see, this snippet is nothing but a simple div containing an unordered list of images.
 * You don't need any special "class" attribute, or a special "css" file for this plugin.
 * I am using a class attribute just for the sake of explanation here.
 *
 * To navigate the elements of the carousel, you need some kind of navigation buttons.
 * For example, you will need a "previous" button to go backward, and a "next" button to go forward.
 * This need not be part of the carousel "div" itself. It can be any element in your page.
 * Lets assume that the following elements in your document can be used as next, and prev buttons...
 *
 * <button class="prev">&lt;&lt;</button>
 * <button class="next">&gt;&gt;</button>
 *
 * Now, all you need to do is call the carousel component on the div element that represents it, and pass in the
 * navigation buttons as options.
 *
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev"
 * });
 *
 * That's it, you would have now converted your raw div, into a magnificient carousel.
 *
 * There are quite a few other options that you can use to customize it though.
 * Each will be explained with an example below.
 *
 * @param an options object - You can specify all the options shown below as an options object param.
 *
 * @option btnPrev, btnNext : string - no defaults
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev"
 * });
 * @desc Creates a basic carousel. Clicking "btnPrev" navigates backwards and "btnNext" navigates forward.
 *
 * @option btnGo - array - no defaults
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      btnGo: [".0", ".1", ".2"]
 * });
 * @desc If you don't want next and previous buttons for navigation, instead you prefer custom navigation based on
 * the item number within the carousel, you can use this option. Just supply an array of selectors for each element
 * in the carousel. The index of the array represents the index of the element. What i mean is, if the
 * first element in the array is ".0", it means that when the element represented by ".0" is clicked, the carousel
 * will slide to the first element and so on and so forth. This feature is very powerful. For example, i made a tabbed
 * interface out of it by making my navigation elements styled like tabs in css. As the carousel is capable of holding
 * any content, not just images, you can have a very simple tabbed navigation in minutes without using any other plugin.
 * The best part is that, the tab will "slide" based on the provided effect. :-)
 *
 * @option mouseWheel : boolean - default is false
 * @example
 * $(".carousel").jCarouselLite({
 *      mouseWheel: true
 * });
 * @desc The carousel can also be navigated using the mouse wheel interface of a scroll mouse instead of using buttons.
 * To get this feature working, you have to do 2 things. First, you have to include the mouse-wheel plugin from brandon.
 * Second, you will have to set the option "mouseWheel" to true. That's it, now you will be able to navigate your carousel
 * using the mouse wheel. Using buttons and mouseWheel or not mutually exclusive. You can still have buttons for navigation
 * as well. They complement each other. To use both together, just supply the options required for both as shown below.
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      mouseWheel: true
 * });
 *
 * @option auto : number - default is null, meaning autoscroll is disabled by default
 * @example
 * $(".carousel").jCarouselLite({
 *      auto: 800,
 *      speed: 500
 * });
 * @desc You can make your carousel auto-navigate itself by specfying a millisecond value in this option.
 * The value you specify is the amount of time between 2 slides. The default is null, and that disables auto scrolling.
 * Specify this value and magically your carousel will start auto scrolling.
 *
 * @option speed : number - 200 is default
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      speed: 800
 * });
 * @desc Specifying a speed will slow-down or speed-up the sliding speed of your carousel. Try it out with
 * different speeds like 800, 600, 1500 etc. Providing 0, will remove the slide effect.
 *
 * @option easing : string - no easing effects by default.
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      easing: "bounceout"
 * });
 * @desc You can specify any easing effect. Note: You need easing plugin for that. Once specified,
 * the carousel will slide based on the provided easing effect.
 *
 * @option vertical : boolean - default is false
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      vertical: true
 * });
 * @desc Determines the direction of the carousel. true, means the carousel will display vertically. The next and
 * prev buttons will slide the items vertically as well. The default is false, which means that the carousel will
 * display horizontally. The next and prev items will slide the items from left-right in this case.
 *
 * @option circular : boolean - default is true
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      circular: false
 * });
 * @desc Setting it to true enables circular navigation. This means, if you click "next" after you reach the last
 * element, you will automatically slide to the first element and vice versa. If you set circular to false, then
 * if you click on the "next" button after you reach the last element, you will stay in the last element itself
 * and similarly for "previous" button and first element.
 *
 * @option visible : number - default is 3
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      visible: 4
 * });
 * @desc This specifies the number of items visible at all times within the carousel. The default is 3.
 * You are even free to experiment with real numbers. Eg: "3.5" will have 3 items fully visible and the
 * last item half visible. This gives you the effect of showing the user that there are more images to the right.
 *
 * @option start : number - default is 0
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      start: 2
 * });
 * @desc You can specify from which item the carousel should start. Remember, the first item in the carousel
 * has a start of 0, and so on.
 *
 * @option scrool : number - default is 1
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      scroll: 2
 * });
 * @desc The number of items that should scroll/slide when you click the next/prev navigation buttons. By
 * default, only one item is scrolled, but you may set it to any number. Eg: setting it to "2" will scroll
 * 2 items when you click the next or previous buttons.
 *
 * @option beforeStart, afterEnd : function - callbacks
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      beforeStart: function(a) {
 *          alert("Before animation starts:" + a);
 *      },
 *      afterEnd: function(a) {
 *          alert("After animation ends:" + a);
 *      }
 * });
 * @desc If you wanted to do some logic in your page before the slide starts and after the slide ends, you can
 * register these 2 callbacks. The functions will be passed an argument that represents an array of elements that
 * are visible at the time of callback.
 *
 *
 * @cat Plugins/Image Gallery
 * @author Ganeshji Marwaha/ganeshread@gmail.com
 */

/**
 * @change gaojj@alltosun.com 修改为如果剩余的图片少于滚动数，则直接滚动到最后/最先一张图
 * @change gaojj@alltosun.com 修改按钮的样式为hidden，隐藏；原先为disabled
 * @change gaojj@alltosun.com 2010.04.20 增加o.bigImg，大图的播放效果；
 * @change gaojj@alltosun.com 2010.04.21 增加o.imgSrc默认的图片设置；增加currClass缩略图选中样式；增加imgInfo回调方法
 * @change gaojj@alltosun.com 2011.02.25 增加如果在自动滚动过程中，鼠标移动到滚动图层时，停止滚动
 * @change gaojj@alltosun.com 2011.02.25 增加o.fixedDivSize，用于固定div的宽度/高度，定义此参数后将不再使用liSize*o.visible作为div的宽度/高度
 * @change gaojj@alltosun.com 2011.02.25 @TODO 增加o.scrollCurrLiSize，定义此参数为true后，则每次滚动按照每个li自身的宽度/高度进行滚动
 */

(function($) {                                          // Compliant with jquery.noConflict()
$.fn.jCarouselLite = function(o) {
    o = $.extend({
        btnPrev: null,
        btnNext: null,
        btnGo: null,
        mouseWheel: false,
        auto: null,

        speed: 200,
        easing: null,

        vertical: false,
        circular: true,
        visible: 3,
        start: 0,
        scroll: 1,

        beforeStart: null,
        afterEnd: null,
        /**
         * bigImg 对应的大图的img标签的jQuery选择器
         */
        bigImg : null,
        /**
         * 默认的图片设置，现有loading图片、鼠标上一张/下一张指针
         */
        imgSrc : {
    	            'loading' : '/static/images/common/loadinfo.net.gif',
    	            'prevCur' : '/static/images/common/prev.cur',
    	            'nextCur' : '/static/images/common/next.cur'
    	         },
        /**
         * 缩略图选中的class样式
         */
        currClass : 'curr',
        /**
         * imgInfo 显示当前大图时预留的接口，可以自定义显示其他内容，如大图标题，描述，页码等
         * @param thumbImgObj是显示当前大图对应的缩略图的jQuery对象
         */
        imgInfo: function(thumbImgObj){return true;},
		/**
		 * fixedDivSize 用于固定div的宽度/高度，定义此参数后将不再使用liSize*o.visible作为div的宽度/高度
		 */
		fixedDivSize: 0,
		/**
		 * 定义此参数为true后，则每次滚动按照每个li自身的宽度/高度进行滚动
		 */
		scrollCurrLiSize: false
    }, o || {});

    return this.each(function() {                           // Returns the element collection. Chainable.

        var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
        var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi.size(), v = o.visible;

        // 2010.04.20, gaojj, 添加点击缩略图显示对应大图
        if (o.bigImg) {
	        var thumb = $("img", div), bigImg = $(o.bigImg);
	        var loadingImg = o.imgSrc.loading, prevCur = o.imgSrc.prevCur, nextCur = o.imgSrc.nextCur;
	        var bigImgWidth = bigImg[0].offsetWidth, bigImgHeight = bigImg[0].offsetHeight;
	        var bigImgWrapWidth = bigImg.parent('div').width();
	        var bigImgWrapHeight = bigImg.parent('div').height();
	        // @FIXME 如何获取loading图片的宽高？
	        var loadingLeft = bigImgWrapWidth/2-24, loadingTop = bigImgWrapHeight/2-24;
	        // 选中的class样式
	        var currClass = o.currClass;
	        // 缩略图显示点击鼠标手势
	        thumb.css('cursor', 'pointer');
	        // 点击缩略图，显示选中效果
	        tLi.click(function() {
	        	tLi.removeClass(currClass);
	            $(this).addClass(currClass);
	        });
	        var maskDiv = loadingDiv = '';
	        loadingDiv += '<div class="loadingImage" style="position: absolute; text-align:left; opacity: 0.5; filter: alpha(opacity=50); visibility: hidden; background: none; width: '+bigImgWrapWidth+'px; height: '+bigImgWrapHeight+'px; left:0px;">';
	        loadingDiv += '<span style="margin-left: '+loadingLeft+'px;"><img src="'+loadingImg+'" style="margin-top:'+loadingTop+'px; height:auto; width:auto; border: 0 none;"></span>';
	        loadingDiv += '</div>';
	        var loadingObj = $(loadingDiv);
	        bigImg.before(loadingObj);
	        maskDiv += '<div class="goPrev" style="background:#ffffff; opacity: 0; filter: alpha(opacity=0); position: absolute; visibility: visible; cursor:url('+prevCur+'), pointer; width: '+bigImgWrapWidth/2+'px; height: '+bigImgWrapHeight+'px; left:0px;">';
	        maskDiv += '</div>';
	        maskDiv += '<div class="goNext" style="background:#ffffff; opacity: 0; filter: alpha(opacity=0); position: absolute; visibility: visible; cursor:url('+nextCur+'), pointer; width: '+bigImgWrapWidth/2+'px; height: '+bigImgWrapHeight+'px; left: '+(bigImgWrapWidth/2)+'px;">';
	        maskDiv += '</div>';
	        var maskObj = $(maskDiv);
	        bigImg.before(maskObj);
	        // 显示对应的缩略图
	        var relativeThumb = function(type){
	            var currentThumb = $("li."+currClass, div);
	            var nextThumb;
	            if (type == 'next') {
	            	// 下一张
		            if(currentThumb.next("li").length == 0) {
		            	nextThumb = $("li:first", div);
		            } else {
		            	nextThumb = currentThumb.next("li");
		            }
	            } else {
	            	// 上一张
	            	if(currentThumb.prev("li").length == 0) {
		            	nextThumb = $("li:last", div);
		            } else {
		            	nextThumb = currentThumb.prev("li");
		            }
	            }
	            $("li", div).removeClass(currClass);
	            nextThumb.addClass(currClass);
	            showImage($("img", nextThumb));
	            // 触发小图跟随滚动
	            //if (!o.btnGo) alert('欲触发小图跟随滚动，请设置btnGo参数，并给所有btnGo参数对应的dom加入btnGo的class');
	            try{
	            	$(".btnGo", nextThumb).trigger("click");
	            } catch (e) {
	            	if(e instanceof ReferenceError) {
	            		alert('欲触发小图跟随滚动，请在缩略图所属的li中，给btnGo参数对应的dom加入btnGo的class！');
	            	}
	            }
	        };
	        var mouseAction;
			if (typeof(o.mouseAction) == 'undefined') {
				mouseAction = relativeThumb;
			} else {
				mouseAction = o.mouseAction;
			}
	        // 点击上一张/下一张大图显示对应的缩略图
	        //$(".goNext, .goPrev", maskObj).click(function(){
	        $(".goNext, .goPrev").click(function(){
	        	var type;
	        	if ($(this).hasClass("goNext")) type = 'next';
	        	if ($(this).hasClass("goPrev")) type = 'prev';
	        	if (type != undefined) mouseAction(type);
	        });
	        thumb.click(function() {
	        	  showImage($(this));
	      	});

	        // 显示大图
	        function showImage(thumbImgObj, bigImageSrc){
	            $(".loadingImage").css('visibility','visible');
	            // @FIXME 必须在img标签后加入class为bigSrc，值为大图地址的input标签，可否考虑其他扩展性更好的方案？
	            if (bigImageSrc == undefined) {
					bigImageSrcObj = thumbImgObj.nextAll('.bigSrc');
					if (bigImageSrcObj.length == 0) {
						alert('请在img标签后加入class为bigSrc，值为大图地址的input标签');
						return;
					}
					bigImageSrc = bigImageSrcObj.val();
				}
	            
	            bigImg.attr("src", bigImageSrc).load(function(){
	            	//$(".loadingImage").css('visibility','hidden');								
					//待大图显示后设置相关div的高度	
		        	var bigImgHeight = bigImg.height();
		            $(".loadingImage").height(bigImgHeight).css('visibility','hidden');
		            $("img", $(".loadingImage")).css('marginTop', bigImgHeight/2);
		            $(".goNext, .goPrev").height(bigImgHeight);
					//设置大图外层div的高度和大图的高度一直
					bigImg.parent('div').height(bigImgHeight);
	            });
	            if(o.imgInfo instanceof Function) o.imgInfo(thumbImgObj);							
	        }
        }
        // 2010.04.20, gaojj, 添加点击缩略图显示对应大图

        if(o.circular) {
            ul.prepend(tLi.slice(tl-v-1+1).clone())
              .append(tLi.slice(0,v).clone());
            o.start += v;
        }

        var li = $("li", ul), itemLength = li.size(), curr = o.start;
        //div.css("visibility", "visible");

        li.css({overflow: "hidden", float: o.vertical ? "none" : "left"});
        ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
        div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});

        var liSize = o.vertical ? height(li) : width(li);   // Full li size(incl margin)-Used for animation
        var ulSize = liSize * itemLength;                   // size of full ul(total length, not just for the visible items)
        var divSize = o.fixedDivSize != 0 ? o.fixedDivSize : liSize * v;                           // size of entire div(total length for just the visible items)

		var animSize = curr*liSize;
		if (!o.scrollCurrLiSize) {
			li.css({width: li.width(), height: li.height()});
			var startLi = li.slice(0, curr);
			animSize = o.vertical ? height(startLi) : width(startLi);
		}
		ul.css(sizeCss, ulSize+"px").css(animCss, -animSize);
        
        div.css(sizeCss, divSize+"px");                     // Width of the DIV. length of visible images
        div.css("visibility", "visible");

        if(o.btnPrev)
            $(o.btnPrev).click(function() {
                return go(curr-o.scroll);
            });

        if(o.btnNext)
            $(o.btnNext).click(function() {
                return go(curr+o.scroll);
            });

        if(o.btnGo)
            $.each(o.btnGo, function(i, val) {
                $(val).click(function() {
                    return go(o.circular ? o.visible+i : i);
                });
            });

        if(o.mouseWheel && div.mousewheel)
            div.mousewheel(function(e, d) {
                return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
            });

        if(o.auto) {
            autoInterval = setInterval(function() {
                go(curr+o.scroll);
            }, o.auto+o.speed);

			// 2011.02.25 gaojj 如果在自动滚动过程中，鼠标移动到滚动图层时，停止滚动
			div.mouseover(function(){
				clearInterval(autoInterval);
			});
			div.mouseout(function(){
				autoInterval = setInterval(function() {
					go(curr+o.scroll);
				}, o.auto+o.speed);
			});
		}

        function vis() {
            return li.slice(curr).slice(0,v);
        };

        function go(to) {

            if(!running) {

                if(o.beforeStart)
                    o.beforeStart.call(this, vis());

                if(o.circular) {            // If circular we are in first or last, then goto the other end
                    if(to<=o.start-v-1) {           // If first, then goto last
                        ul.css(animCss, -((itemLength-(v*2))*liSize)+"px");
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be lesser depending on the number of elements.
                        curr = to==o.start-v-1 ? itemLength-(v*2)-1 : itemLength-(v*2)-o.scroll;
                    } else if(to>=itemLength-v+1) { // If last, then goto first
                        ul.css(animCss, -( (v) * liSize ) + "px" );
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be greater depending on the number of elements.
                        curr = to==itemLength-v+1 ? v+1 : v+o.scroll;
                    } else curr = to;
                } else {                    // If non-circular and to points to first or last, we just return.
                	// 修改为如果剩余的图片少于滚动数，则直接滚动到最后一张图
                    if (to>itemLength-v) to = itemLength-v;
                    // 修改为如果剩余的图片少于滚动数，则直接滚动到第一张图
                    if(to<0) to=0;
                    curr = to;
                }                           // If neither overrides it, the curr will still be "to" and we can proceed.

                running = true;

				var animSize = curr*liSize;
				if (o.scrollCurrLiSize) {
					var currLi = li.eq(curr);
					//@FIXME 每次滚动li自身的高度
					//animSize = o.vertical ? height(currLi) : width(currLi);
				}
				
                ul.animate(
                    animCss == "left" ? { left: -animSize } : { top: -animSize } , o.speed, o.easing,
                    function() {
                        if(o.afterEnd)
                            o.afterEnd.call(this, vis());
                        running = false;
                    }
                );
                // Disable buttons when the carousel reaches the last/first, and enable when not
                if(!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass("hidden");
                    // 因上面调整了如果剩余的图片少于滚动数，则直接滚动到第一或者最后一张图
                    // 故此处curr只有在为0或者最后一张图时才不能滚动，才隐藏按钮
//                   $( (curr-o.scroll<0 && o.btnPrev)
                   $( (curr==0 && o.btnPrev)
                        ||
//                       (curr + o.scroll > itemLength-v && o.btnNext)
                       (curr == itemLength-v && o.btnNext)
                        ||
                       []
                     ).addClass("hidden");
                }
            }
            return false;
        };
    });
};

function css(el, prop) {
    return parseInt($.css(el[0], prop)) || 0;
};
function width(el) {
	if (!el[0]) {
		return false;
	}
    return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {
    return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};

})(jQuery);