<?php 
use app\core\helpers\Url;
?>
<link type="text/css" rel="stylesheet" href="/static/libs/meal/css/uc.css" />  <!--本页css-->
<div class="me2">
	<div class="me3">
		<img class="me4" src="/static/libs/meal/img/100.png"/>
	</div>
</div>
<div class="me5">
	<a href="<?=Url::toRoute(['/m/shop/order/list'])?>" class="me8">
		<img class="me7" src="/static/libs/meal/img/dingdan.png" width="20"/>
		<div class="me6">我的订单</div>
		<img class="me9" src="/static/libs/meal/img/rig.png" width="20"/>
		<div class="clear"></div>
	</a>
	<a href="<?=Url::toRoute(['/m/shop/meal/setting'])?>" class="me8">
		<img class="me7" src="/static/libs/meal/img/xinxi.png" width="22"/>
		<div class="me6">个人信息</div>
		<img class="me9" src="/static/libs/meal/img/rig.png" width="20"/>
		<div class="clear"></div>
	</a>
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
