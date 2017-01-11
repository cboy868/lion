<?php 

use app\assets\TooltipAsset;

use app\core\helpers\Url;
TooltipAsset::register($this);

$this->registerJsFile('@web/static/site/fav.js', ['depends'=>['yii\web\YiiAsset'], 'position'=> yii\web\View::POS_END]);
?>


<span class="tooltip" title="This is my span's tooltip message!">Some text</span>
 
<a href="#" class="fav" res-name="goods" res-id="12" title="标题">点此收藏 (<span class="favcnt">12</span>)</a>

<div class="tab">
	<div class="tab-head">
		<strong>我的收藏</strong> <span class="tab-more"></span>
		<ul class="tab-nav">
			<li class="active"><a href="#tab-start">产品</a> </li>
			<li><a href="#tab-css">文章</a> </li>
			<li><a href="#tab-units">图集</a> </li>
		</ul>
	</div>
	<div class="tab-body">
		<div class="tab-panel active" id="tab-start">
			<div class="list-link">
				<a href="#"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a> 
				<a href="#" class="active"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a>
			</div>
		</div>
		<div class="tab-panel" id="tab-css">
			<div class="list-link">
				<a href="#"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a> 
				<a href="#" class="active"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a>
			</div>
		</div>
		<div class="tab-panel" id="tab-units">
			<div class="list-link">
				<a href="#"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a> 
				<a href="#" class="active"><span class="float-right badge bg-main"></span> <button class="float-right badge bg-main">删除</button> 第二个 <small>(2017-02)</small></a>
			</div>
		</div>
	</div>
</div>




<?php $this->beginBlock('fav') ?> 
$(function(){
	$('.fav').click(function(){
		var res_name = $(this).attr('res-name');
		var res_id = $(this).attr('res-id');
		var title = $(this).attr('title');
		var res_url = document.location.href;
		var _csrf = $('meta[name=csrf-token]').attr('content');
		var url = "<?=Url::toRoute(['/member/default/favor'])?>"
		$('.fav').fav(res_name, res_id, res_url, title, _csrf, url);
	});
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['fav'], \yii\web\View::POS_END); ?>  