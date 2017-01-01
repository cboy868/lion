<?php 
use app\core\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/index.css">
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/jquery.mmenu.all.css">
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/demo.css">
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/component.css">
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/leftdaohang.css">
<link rel="stylesheet" type="text/css" href="/static/libs/meal/css/demo.css">

<style type="text/css">
	.pq10 {
	    width: 70px;
	}
	button .plus{
		cursor: pointer;
	}
</style>
<div id="header">
	<!-- <a href="#menu-left"></a> -->
	平泉餐饮
	<!-- <a href="#menu-right" class="right friends"></a> -->
</div>
<div id="content">
	<div class="big" id="huas">
		
		<ul id="nav-dh">
			<div class="zz">
				<?php foreach ($cates as $k => $v): ?>
					<li><a href="#<?=$v['id']?>" class=""><?=$v['name']?></a></li>
				<?php endforeach ?>
				<div style="height:20%;"></div>
			</div>
		</ul>
		
		<div class="rightmenu">
			<?php foreach ($goods as $k => $v): ?>
				<div class="con1" id="<?=$k?>">
					<div style="height:50px;width:100%;"></div>
					<?php foreach ($v as $meal): ?>
						<div class="pq3">
							<a class="bot1" href="<?=Url::toRoute(['view', 'id'=>$meal['id']])?>"><img class="pq13" src="<?=$meal['thumb']?>"/></a>
							<div class="pq7">
								<div class="pq4"><?=$meal['name']?></div>
								
								<div class="pq5"><span style="color:#f60;">￥<?=$meal['price']?></span>

									<?php if (count($meal['sku']) == 1): ?>
										<div class="pq10" goods-id="<?=$sku['goods_id']?>" sku-id="<?=$sku['id']?>" tit="<?=$meal['name']?>">
											<button type="button" class="down minus"><img class="pp1" src="/static/libs/meal/img/pp2.png"/></button>
											<input type="text" value="0" u-price="<?=$meal['price']?>" class="cl<?=$meal['id'] . $sku['id']?>" />
											<button type="button" class="up plus"><img class="pp1" src="/static/libs/meal/img/pp1.png"/></button>
											<div class="clear"></div>
										</div>
									<?php endif ?>
								</div>
							</div>
							<div class="clear"></div>
							<?php if (count($meal['sku']) > 1): ?>
								<?php foreach ($meal['sku'] as $sku): ?>
									<div class="pq8" >
										<div class="pq9"><tc><?=$sku['name']?></tc>： <span style="color:#f60;">￥<?=$sku['price']?></span></div>
										<div class="pq10" goods-id="<?=$sku['goods_id']?>" sku-id="<?=$sku['id']?>" tit="<?=$sku['name']?>">
											<button type="button" class="down minus"><img class="pp1" src="/static/libs/meal/img/pp2.png"/></button>
											<input type="text" value="0" u-price="<?=$sku['price']?>" class="cl<?=$meal['id'] . $sku['id']?>" />
											<button type="button" class="up plus"><img class="pp1" src="/static/libs/meal/img/pp1.png"/></button>
											<div class="clear"></div>
										</div>
										<div class="clear"></div>
									</div>
								<?php endforeach ?>
							<?php endif ?>
						
						</div>
					<?php endforeach ?>
				</div>	
			<?php endforeach ?>
			
		</div>
	</div>	
	<div class="bao">
		<div class="sidebar">
			<div class="fudi">
				<img src="/static/libs/meal/img/65465.png" width="12%" style="margin-left:7%;float:left;margin-top:12px;"/>
				<div class="shop_cars_dis" style="color:#fff;font-size:16px;margin-left:2%;float:left;">￥00.00</div>
				<div class="clear"></div>
			</div>
			<a href="" class="chouxin" style="text-decoration:none;">去结算</a>
			<div class="clear"></div>
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
	</div>
</div>

<nav id="menu-left">
	<ul>
		<li><a class="cg1" href="index.html" style="color:#fff;background-color:#d27a82;">所有菜品</a></li>
		<li><a class="cg1" href="darp.html">饺子</a></li>
		<li><a class="cg1" href="soup.html">汤</a></li>
	</ul>
</nav>

<nav id="menu-right">

	<div class="yinru">
		<div class="sc1">
			<div class="sc10">

				<?php foreach ($mix as $k => $v): ?>
					<div class="sc6">
						<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/rou.png"/></span><?=$v['name']?></div>
						<?php foreach ($v['child'] as $key => $val): ?>
							<div class="sc9" onclick="chg(this);" rel="<?=$key?>"><?=$val?></div>
						<?php endforeach ?>
						<div class="clear"></div>
					</div>
				<?php endforeach ?>
				
				<!-- <div class="sc6">
					<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/shucai.png"/></span>蔬菜</div>
					<div class="sc9" onclick="chg(this);">荷兰豆</div>
					<div class="clear"></div>
				</div>
				<div class="sc6">
					<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/doufu.png"/></span>制成品</div>
					<div class="sc9" onclick="chg(this);">豆腐</div>
					<div class="sc9" onclick="chg(this);">筱面</div>
					
					<div class="clear"></div>
				</div>
				<div class="sc6">
					<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/colo2.png"/></span>其他</div>
					<div class="sc9" onclick="chg(this);">玉米</div>
					<div class="sc9" onclick="chg(this);">可乐</div>
					<div class="clear"></div>
				</div>
				<div class="sc6">
					<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/xia.png"/></span>水产</div>
					<div class="sc9" onclick="chg(this);">鱿鱼</div>
					<div class="clear"></div>
				</div>
				<div class="sc6">
					<div class="sc7"><span><img class="sc15" src="/static/libs/meal/img/shuiguo.png"/></span>果品</div>
					<div class="sc9" onclick="chg(this);">香蕉</div>
					<div class="sc9" onclick="chg(this);">枣</div>
					<div class="clear"></div>
				</div> -->
			</div>
			<div class="sc8">
				<a href="" class="sc11" style="text-decoration:none;">重置</a>
				<a href="" class="sc12 btn-ok" style="text-decoration:none;">确定</a>
				<div class="clear"></div>
			</div>
		</div>


	</div>   <!-- 筛选引入  easy.js控制  代码在 shaixuan.html   —-->
	
</nav>

<script type="text/javascript" src="/static/libs/meal/js/jquery.js"></script>
<script type="text/javascript" src='/static/libs/meal/js/jquery.mmenu.js'></script>
<script type="text/javascript" src='/static/libs/meal/js/jquery.mmenu.searchfield.js'></script>
<script type="text/javascript" src='/static/libs/meal/js/jquery.mmenu.header.js'></script>
<script type="text/javascript" src='/static/libs/meal/js/jquery.mmenu.labels.js'></script>
<script type="text/javascript" src='/static/libs/meal/js/jquery.mmenu.counters.js'></script>
<script type="text/javascript" src='/static/libs/meal/js/modernizr.custom.js'></script>
<script type="text/javascript" src="/static/libs/meal/js/jquery.nav.js"></script>


<?php $this->registerJsFile('/static/site/sku.js',['position' => \yii\web\View::POS_END]);?>


<?php $this->beginBlock('cart') ?>

$(function(){

	Cart.reloadHtml();

	$('body').on('click', '.plus, .minus', function(){

		var obj = $(this).closest('div');
		var goods_id = obj.attr('goods-id'),
			sku_id   = obj.attr('sku-id'),
			num      = parseInt(obj.find('input').val()),
			price    = obj.find('input').attr('u-price'),
			title    = obj.attr('tit');

		num = $(this).hasClass('plus') ? ++num : (num == 0 ? 0: --num);
		obj.find('input').val(num);


		Cart.addItem(sku_id, goods_id, num, price, title);
        Cart.reloadHtml();

	});
})





<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cart'], \yii\web\View::POS_END); ?>  











<?php $this->beginBlock('index') ?>  

window.onscroll = function() {
	y=document.getElementById("nav-dh");
	if (window.scrollY < 35) {
		y.style.top=(50 - window.scrollY) + "px";
	}else {
		y.style.top="50px";
	}
} 
$(document).ready(function() {

	//$('#nav-dh').onePageNav();

});



var parse=[];
function chg(obj){ 
	var rel = $(obj).attr('rel');
	if(obj.className != "over"){ 
		obj.oldClass = obj.className;
		obj.className = "over"; 
		parse.push(rel);

	}else if(obj.oldClass){ 
		obj.className = obj.oldClass;
		var index = parse.indexOf(rel);
		parse.splice(index,1);
	} 
} 

//$('.btn-ok').click(function(e){
//	e.preventDefault();
//	var str = parse.join(',');
//});

$(function(){
	$('#nav-dh').onePageNav();
	$('nav#menu-left').mmenu();

//	The menu on the right
	var $menu = $('nav#menu-right');

	$menu.mmenu({
		position	: 'right',
		classes		: 'mm-light',
		counters	: true,
		labels		: {
			fixed		: !$.mmenu.support.touch
		}
	});

	//	Click a menu-item
	var $confirm = $('#confirmation');
	$menu.find( 'li a' ).not( '.mm-subopen' ).not( '.mm-subclose' ).bind(
		'click.example',
		function( e )
		{
			e.preventDefault();
			$confirm.show().text( 'You clicked "' + $.trim( $(this).text() ) + '"' );
			$('#menu-right').trigger( 'close' );
		}
	);
});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['index'], \yii\web\View::POS_END); ?>  







