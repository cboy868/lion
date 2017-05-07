/**
 * JSer: mayichao
 * Date: 14-7-16
 * public class
**/
$(function(){

	eleCSS = function(me){

		return me = {
			init : function(){
				me.firstChild();
				me.lastChild();
				me.rem();
			},
			firstChild : function(){
				$('.nav ul li:first').addClass('first');
			},
			lastChild : function(){
				$(' .nav ul li:last, .last > .tabbox > .items:last, .after_sale .process a.round:last, .blog-list dl:last').addClass('last');

				$('.set_lastli ul').each(function(i, el){
					var lastLi = $(el).find('li:last');
					lastLi.addClass('last');
				});
			},
			rem : function(){
				$('ul.product_box, div.flower_list').each(function(i, el){
					var item = $(el).children();

					item.each(function(i, el){
						if(i%6==5){
							$(el).addClass('padr0');
						}
					})

				});
				$('.blog_slider .btns a:odd').addClass('marr0');
			}
		}
	}();

	nav = function(me){
		var off = true;
		return me = {
			init : function(){
				me.listSwitch('#sys-msg', '#sys-msgcontent');
				me.listSwitch('#order_pay', '#order-msgcontent');
			},
			listSwitch : function(obj1, obj2){
				$(obj1).click(function(){

					off ? $(obj2).show() : $(obj2).hide();
					off = !off;

				});
			}
		};

	}();

	colorInterlaced = function(me){

		return me = {
			init : function(){
				me.setColor('.news_list', 'even');
				me.setColor('.record_con', 'even');
			},
			setColor : function(obj, iNum){
				$(obj).each(function(i, el){
					var item = $(el).children();
					item.each(function(i,el){
						if(i%2==0){
							$(this).addClass(iNum);
						}
					})
				});
			}
		}

	}();

	titMove = function(me){

		var titMoveBox = $('.tit_move_box');
		var moveTit = null;

		var centralPointX = 0;
		var centralPointY = 0;

		var a = $('.tit_move_box li').eq(0).width()/2;
		var b = $('.tit_move_box li').eq(0).height()/2;

		return me={init:function(){me.move()},getDir:function(a,b,c,d,e,f){var g="",h=Math.atan(a/b),i=Math.atan(c/d);return g=h>i?e:f},dir:function(c,d,e){var f,g;centralPointX=d.offset().left+d.width()/2,centralPointY=d.offset().top+d.height()/2,f=c.pageX,g=c.pageY,f>centralPointX&&centralPointY>g?d.data(e,me.getDir(a,b,f-centralPointX,centralPointY-g,"up","right")):f>centralPointX&&g>centralPointY?d.data(e,me.getDir(b,a,g-centralPointY,f-centralPointX,"right","down")):centralPointX>f&&g>centralPointY?d.data(e,me.getDir(b,a,g-centralPointY,centralPointX-f,"left","down")):centralPointX>f&&centralPointY>g&&d.data(e,me.getDir(a,b,centralPointX-f,centralPointY-g,"up","left"))},move:function(){titMoveBox.each(function(){var a=$(this),b=a.find("li");b.mouseenter(function(a){var b=$(this);switch(moveTit=b.find("h2.tit_move > span"),me.dir(a,b,"inTxt"),b.data("inTxt")){case"up":moveTit.css({left:"0",top:-1*moveTit.height()+"px"});break;case"right":moveTit.css({left:moveTit.width()+"px",top:"0"});break;case"down":moveTit.css({left:"0",top:moveTit.height()+"px"});break;case"left":moveTit.css({left:-1*moveTit.width()+"px",top:"0"})}moveTit.stop().animate({left:0,top:0},200,"linear")}),b.mouseleave(function(a){var b=$(this);switch(me.dir(a,b,"outTxt"),b.data("outTxt")){case"up":moveTit.stop().animate({top:-1*moveTit.height()+"px",left:0},200,"linear");break;case"right":moveTit.stop().animate({left:moveTit.width()+"px",top:0},200,"linear");break;case"down":moveTit.stop().animate({top:moveTit.height()+"px",left:0},200,"linear");break;case"left":moveTit.stop().animate({left:-1*moveTit.width()+"px",top:0},200,"linear")}})})}};
	}();

	listScroll = function(me){
		var timer = null,
		weLen = $('.wechat_box div.items').length,
		messageLen = $('.memorial_mess .det > .message_li').length;
		return me = {
			init : function(){
				timer = setInterval(function(){
					me.weScroll();
					me.noteScroll();
				}, 5000);
				me.mTimer();
			},
			weScroll : function(){
				if(weLen >= 5){
					$('.wechat_box div.items:first').animate({
						opacity : 0
					}, 500, function(){
						$(this).animate({
							height : 0,
							padding : 0,
							marginBottom : 0
						}, 500, function(){
							$('.wechat_box div.det').append($(this));
							$(this).removeAttr('style');
						});
					});
				}
			},
			noteScroll : function(){
				if(messageLen >= 5){
					$('.memorial_mess .det > .message_li:first').slideUp(500, function(){
						$('.memorial_mess .det').append($(this));
						$(this).show();
					});
				}
			},
			mTimer : function(){
				if(weLen < 5 && messageLen < 5)clearInterval(timer);
			}
		}
	}();

	getToday = function(me){

		return me = {
			init : function(){
				me.now();
			},
			now : function(){
				var d = new Date(),
				vYear = d.getFullYear(),
				vMon = d.getMonth() + 1,
				vDay = d.getDate();

				var $html = '<p>今天是&nbsp;' + vYear + '年&nbsp;' + (vMon < 10 ? "0" + vMon : vMon) + '月&nbsp;' + (vDay < 10 ? "0"+ vDay : vDay) + '日&nbsp;' + '</p>';

				$('.memorial_day .today').append($html);
			}
		}

	}();

	backTop = function(me){

		var $html = null;
		return me = {
			init : function(){
				me.create();
				me.move();
				me.winScroll();
			},
			create : function(){
				$html = '<div class="back_top" data-to="body"></div>';
        		$('body').append($html);
			},
			move : function(){
				$('.back_top').click(function(e){
					e.preventDefault();

					var target = $(this).data('to'),
					target_offset = $(target).offset().top;
					$('html, body').stop().animate({scrollTop: target_offset}, 300);

				});
			},
			winScroll : function(){
				$(window).scroll(function(){
					scrollT = $(this).scrollTop();
					if(scrollT > 100){
						$('.back_top').stop().fadeTo(200, 1);
					}else{
						$('.back_top').stop().fadeTo(200, 0 ,function(){
							$(this).hide();
						});
					};
				});
			}
		}

	}();

	album = function(me){

		var imgMark,
		zoomBox,
		zoomImg;

		var bigImg = $('.tomb-bigshow img').eq(0),
		smallImg = $('#imgUl li'),
		nextBtn = $('.cutright'),
		prevBtn = $('.cutleft'),
		num = 0,
		ulLeft = 0,
		len = smallImg.length,
		w = smallImg.width() + parseInt(smallImg.css('margin-right'));

		bigImg.data('zoom', $('#imgUl li').eq(0).data('zoom'));

		return eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('7={1n:6(){7.K();7.R();7.13()},K:6(){$("1m.T z a").q(6(){g U=$(5).s("U");g S=$(5).E().s("G");$(5).E().E().C().F("T "+S+"K");$(5).1l();p 1p})},R:6(){L.1q(6(){b($(5).V()==c)p;c=$(5).V();7.m(W);7.m(11);7.D()});L.B(\'a\').q(6(e){e.1r()});W.q(6(){b(c==1k-1){7.I($(5));p}7.m($(5).N(\'u\'));c++;7.M(4,0,-4)});11.q(6(){b(c==0){7.I($(5));p}7.m($(5).N(\'u\'));c--;7.M(4,3,4)})},I:6(j){b(!j.Q(\'r\')){j.F(\'r\')}},m:6(j){b(j.Q(\'r\')){j.C(\'r\')}},M:6(Z,Y,12){X=1C($(\'#x\').o(\'h\'));b(c%Z==Y){$(\'#x\').1A().1B({h:(X+w*12)+\'i\'},1u,\'1t\')}7.D()},D:6(){L.J(c).F(\'P\').N().C(\'P\');O.v(\'H\',$(\'#x z\').J(c).v(\'H\'));O.s(\'A\',$(\'#x z\').J(c).v(\'1E\'))},13:6(){$(\'.15-1d\').1y(6(){g 18=$(5).B(\'y\').v(\'H\');8=\'<u G="1g"></u>\';f=\'<1e G="1i"><y A=""></1e>\';$(5).1z(8);$(5).1x(f);8=$(\'.1g\');f=$(\'.1i\');f.o({h:$(5).1c().h+$(5).9()+10+\'i\',n:$(5).1c().n+\'i\',1w:\'1v\'});k=f.B(\'y\');k.s(\'A\',18);k.o({9:\'19\',1D:\'19\'})},6(){8.14();f.14()});$(\'.15-1d\').1s(6(e){g l=e.1o-$(5).17().h-8.9()/2;g t=e.1j-$(5).17().n-8.d()/2;b(l<0){l=0}1a b(l>$(5).9()-8.9()){l=$(5).9()-8.9()}b(t<0){t=0}1a b(t>$(5).d()-8.d()){t=$(5).d()-8.d()}8.o({h:l+\'i\',n:t+\'i\'});g 16=l/($(5).9()-8.9());g 1f=t/($(5).d()-8.d());k.o({h:1b.1h(16*(f.9()-k.9()))+\'i\',n:1b.1h(1f*(f.d()-k.d()))+\'i\'})})}}',62,103,'|||||this|function|me|imgMark|width||if|num|height||zoomBox|var|left|px|obj|zoomImg||removeDisabled|top|css|return|click|disabled|attr||span|data||imgUl|img|li|src|find|removeClass|imgChange|parent|addClass|class|zoom|addDisabled|eq|star|smallImg|fnMove|siblings|bigImg|active|hasClass|ev|cl|rating|title|index|nextBtn|ulLeft|n2|n1||prevBtn|n3|imgZoom|remove|tomb|iScaleX|offset|iSrc|683px|else|Math|position|bigshow|div|iScaleY|img_mark|floor|img_zoom|pageY|len|blur|ul|init|pageX|false|mouseover|preventDefault|mousemove|linear|200|9998|zIndex|after|hover|append|stop|animate|parseInt|heidth|big'.split('|'),0,{}));
	}();

	tipsTxt = function(me){

		return me = {

			init : function(){
				me.showTips();
			},
			showTips : function(){

				var delayTimer = null;

				$('.tips_box').each(function(i, el){

					var $html = '<div class="tips"><b><i></i></b><p></p></div>';

					$(el).append($html);

					var tips = $(el).find('.tips'),
						hoverEle = $(el).find('.hover_ele'),
						t = $(el).get(0).offsetHeight - 20;
					
					hoverEle.hover(function(){
						var $this = $(this);

						delayTimer = setTimeout(function(){

							tips.find('p').html($this.data('tip-txt'));
							tips.css({
								left : $this.position().left + 'px',
								top : t + 'px'
							});
							tips.fadeIn(300);

						}, 200);
						
					},function(){
						clearTimeout(delayTimer);
						if(tips.is(':visible'))tips.hide();
					});
				});
				

			}

		};

	}();


	eleCSS.init(); // 元素的一些CSS设置
	nav.init(); // 导航条
	colorInterlaced.init(); // 新闻列表隔行变色
	backTop.init(); //返回顶部

});
/*列表滚动*/
(function(){

    function move(obj, speed){
        var first = obj.children().eq(0);
        first.slideUp(speed, function() {
            obj.append($(this));
            $(this).show();
        });
    }
    function autoScroll(obj, json){
        var speed = json.speed || 1000,
            interval = json.interval || 5000,
            toStop = json.toStop || false,
            timer = null;

        if(toStop){
            obj.hover(function(){
                clearInterval(timer);
            },function(){
                autoPlay();
            });
        }

        function autoPlay(){
            timer = setInterval(function(){
                if (obj.is(':visible')) {
                    move(obj, speed);
                }
            }, interval);
        }
        autoPlay();
        
    }
    (!jQuery.AutoScroll)&&(jQuery.AutoScroll = autoScroll);

})();