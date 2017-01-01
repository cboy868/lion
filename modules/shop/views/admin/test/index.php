<?php 
use app\core\helpers\Url;
?>
<h1>支付测试</h2>


<a href="<?=Url::toRoute(['create'])?>">创建订单</a>

<form method="post" action="<?Url::toRoute(['pay'])?>">
	<input name="order_id"  />
	<button>支付</button>
</form>
