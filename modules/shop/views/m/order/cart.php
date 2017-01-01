<?php 
use app\core\helpers\Url;
?>
<link type="text/css" rel="stylesheet" href="/static/libs/meal/css/shop.css" />


<link href="/static/libs/meal/css/mobiscroll.animation.css" rel="stylesheet" type="text/css" />
<link href="/static/libs/meal/css/mobiscroll.widget.css" rel="stylesheet" type="text/css" />
<link href="/static/libs/meal/css/mobiscroll.widget.ios.css" rel="stylesheet" type="text/css" />
<link href="/static/libs/meal/css/mobiscroll.scroller.css" rel="stylesheet" type="text/css" />
<link href="/static/libs/meal/css/mobiscroll.scroller.ios.css" rel="stylesheet" type="text/css" />
<div class="sp2">
	<div class="sp5">
		<img class="pq13" src="/static/libs/meal/img/foot.jpg"/>
		<div class="sp6">
			<div class="sp7">北京烤鸭</div>
			<div class="sp8">50.00</div>
		</div>
		<div class="pq10">
			<button type="button" class="down" onclick="gwc.js(-1,this)"><img class="pp1" src="/static/libs/meal/img/pp2.png"/></button>
			<input type="text" value="0" u-price="100.52" />
			<button type="button" class="up" onclick="gwc.js(1,this)"><img class="pp1" src="/static/libs/meal/img/pp1.png"/></button>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="sp5">
		<img class="pq13" src="/static/libs/meal/img/foot.jpg"/>
		<div class="sp6">
			<div class="sp7">北京烤鸭</div>
			<div class="sp8">50.00</div>
		</div>
		<div class="pq10">
			<button type="button" class="down" onclick="gwc.js(-1,this)"><img class="pp1" src="/static/libs/meal/img/pp2.png"/></button>
			<input type="text" value="0" u-price="100.52" />
			<button type="button" class="up" onclick="gwc.js(1,this)"><img class="pp1" src="/static/libs/meal/img/pp1.png"/></button>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="sp5">
		<img class="pq13" src="/static/libs/meal/img/foot.jpg"/>
		<div class="sp6">
			<div class="sp7">北京烤鸭</div>
			<div class="sp8">50.00</div>
		</div>
		<div class="pq10">
			<button type="button" class="down" onclick="gwc.js(-1,this)"><img class="pp1" src="/static/libs/meal/img/pp2.png"/></button>
			<input type="text" value="0" u-price="100.52" />
			<button type="button" class="up" onclick="gwc.js(1,this)"><img class="pp1" src="/static/libs/meal/img/pp1.png"/></button>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="sp13">
		<div class="sp9">
			<div class="sp10">用餐时间：</div>
			
			<input class="sp11" type="text" name="test" id="test" />
			
			<div class="clear"></div>
		</div>
		<div class="sp9">
			<div class="sp10">总价：</div>

			<input class="sp11 a-price" type="text" placeholder="" readonly="readonly">

			<div class="clear"></div>
		</div>
		<div class="sp9">
			<div class="sp10" style="text-align:center;">备注：</div>
			<input class="sp12" type="text" placeholder="">
			<div class="clear"></div>
		</div>
	</div>
	<div class="sp14">
		<a href="" class="sp15">加菜</a>
		<a href="" class="sp16">确认下单</a>
		<div class="clear"></div>
	</div>
</div>
<div class="foot">
	<a href="<?=Url::toRoute(['/m/shop/meal/index'])?>" class="pq15" style="text-decoration:none;">
		<img src="/static/libs/meal/img/657.png" width="20px" height="20px"style="margin-top:5px;"/>
		<div class="pq16">点餐</div>
	</a>
	<a href="<?=Url::toRoute(['/m/shop/order/cart'])?>" class="pq15" style="text-decoration:none;">
		<img src="/static/libs/meal/img/654.png" width="20px" height="20px"style="margin-top:5px;"/>
		<div class="pq16">购物车</div>
	</a>
	<a href="<?=Url::toRoute(['/m/shop/meal/profile'])?>" class="pq15" style="text-decoration:none;">
		<img src="/static/libs/meal/img/587.png" width="20px" height="20px"style="margin-top:5px;"/>
		<div class="pq16">我</div>
	</a>
</div>


<script src="/static/libs/meal/js/jquery-1.11.1.min.js"></script>
<script src="/static/libs/meal/js/mobiscroll.core.js"></script>
<script src="/static/libs/meal/js/mobiscroll.widget.js"></script>
<script src="/static/libs/meal/js/mobiscroll.scroller.js"></script>
<script src="/static/libs/meal/js/mobiscroll.util.datetime.js"></script>
<script src="/static/libs/meal/js/mobiscroll.datetimebase.js"></script>
<script src="/static/libs/meal/js/mobiscroll.widget.ios.js"></script>
<script src="/static/libs/meal/js/mobiscroll.i18n.zh.js"></script>






<?php $this->beginBlock('cart') ?>  
var gwc ={
	yxwp:{},
	jieguo:{},
	js:function(add_num,ele){
		//获取&&设置数据
		var res=parseInt($(ele).parent().find("input").val())+add_num;
		var num=Math.max(res,0);
		$(ele).parent().find("input").val(num);
		
		var name=$(ele).parent().parent().parent().find(".dr3").html();

		var price = parseFloat($(ele).parent().find('input').attr('u-price'));
		var taocan=$(ele).parent().parent().find("tc").html();
		
		gwc.yxwp[name+taocan]={"价格":price,"数量":num};//导入数据
		gwc.dis();//调用显示函数
	},
	dis:function(){
		var arr= Object.keys(gwc.yxwp);
		gwc.jieguo={
			ys:arr.length,
			fs:0,
			zj:0,
		};
		for(i in gwc.yxwp){//console.log(gwc.yxwp[i]);
			if(gwc.yxwp[i].数量>0){
				gwc.jieguo.fs+=gwc.yxwp[i].数量;
				gwc.jieguo.zj+=gwc.yxwp[i].数量 * gwc.yxwp[i].价格;
			}else{
				gwc.jieguo.ys--;
			}
		}
		var asd= gwc.jieguo.zj;
		asd = parseFloat(asd.toFixed(2));
		$('.a-price').val(asd);

	}
};

$(function () {
	var nowData=new Date();
	var opt= { 
		theme:'ios', //设置显示主题 
		mode:'scroller', //设置日期选择方式，这里用滚动
		display:'bottom', //设置控件出现方式及样式
		preset : 'datetime', //日期:年 月 日 时 分
		minDate: nowData, 
		maxDate:new Date(nowData.getFullYear(),nowData.getMonth(),nowData.getDate()+7,22,00),
//              dateFormat: 'yy-mm-dd', // 日期格式
//              dateOrder: 'yymmdd', //面板中日期排列格式
		stepMinute: 5, //设置分钟步长
		yearText:'年', 
		monthText:'月',
		dayText:'日',
		hourText:'时',
		minuteText:'分',
		lang:'zh' //设置控件语言};
	};
	$('#test').mobiscroll(opt);
});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cart'], \yii\web\View::POS_END); ?>  

