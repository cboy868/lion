// JavaScript Document
$(function(){
	
	//一次滚动一屏，不自动滚动，点击滚动，可作为导航
		$('#marquee1').kxbdSuperMarquee({
			//isAuto:false,
			time:5,
			distance:255,
			btnGo:{left:'#goL',right:'#goR'},
			direction:'left'
		});
		
		/*工程案例*/
		$(".p_img img").resizeImg({
			w:228, //设置图片最大宽度
			h:318 //设置图片最大高度
		});
		
		$(".big img").resizeImg({
			w:490, //设置图片最大宽度
			h:312 //设置图片最大高度
		});
		
		$(".small img").resizeImg({
			w:239, //设置图片最大宽度
			h:150 //设置图片最大高度
		});
		
		/*合作伙伴*/		
		$(".pic img").resizeImg({
			w:244, //设置图片最大宽度
			h:88 //设置图片最大高度
		});
		
		/*新闻*/		
		$(".pis img").resizeImg({
			w:183, //设置图片最大宽度
			h:109 //设置图片最大高度
		});
		
		/*荣誉资质*/		
		$(".pic2 img").resizeImg({
			w:200, //设置图片最大宽度
			h:136 //设置图片最大高度
		});
		
		//子页热销
		$(".piclist1 li img").resizeImg({
			w:168, //设置图片最大宽度
			h:211 //设置图片最大高度
		});
		
		//案例品列表
		$(".piclist li img").resizeImg({
				w:205, //设置图片最大宽度
				h:233 //设置图片最大高度
			});

	
});

$(document).ready(function(){

//首先将#top_arrow隐藏

    $("#top_arrow").hide();

//当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失

    $(function () {
        $(window).scroll(function(){
            if ($(window).scrollTop()>100){
                $("#top_arrow").fadeIn(400);
            }
            else
            {
                $("#top_arrow").fadeOut(400);
            }
        });

//当点击跳转链接后，回到页面顶部位置

        $("#top_arrow").click(function(){
            $('body,html').animate({scrollTop:0},400);
            return false;
        });
    });
});

function saveReport() {
$("#showDataForm").ajaxSubmit(function(message) {
// 对于表单提交成功后处理，message为提交页面saveReport.htm的返回内容
});

return false; // 必须返回false，否则表单会自己再做一次提交操作，并且页面跳转
}

