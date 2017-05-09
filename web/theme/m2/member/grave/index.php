<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls//css/product.css">
<div class="product common">
	<div class="container">
		<div class="skin_img shadow"><img src="/theme/m2/static/gls//img/product/skin_product.jpg" /></div>
		<div class="self_service shadow">
			<h2 class="tit1">
				<span class="txta">自助服务</span>
			</h2>
			<div class="det">
				<a href="#">
					<div class="pic bg1"></div>
					<h4>购买墓位</h4>
				</a>
				<a href="#">
					<div class="pic bg2"></div>
					<h4>远程祭祀</h4>
				</a>
				<a href="#">
					<div class="pic bg3"></div>
					<h4>绢花租摆</h4>
				</a>
				<a href="#">
					<div class="pic bg4"></div>
					<h4>预定鲜花</h4>
				</a>
				<a href="#">
					<div class="pic bg5"></div>
					<h4>随葬用品</h4>
				</a>
				<a href="#">
					<div class="pic bg6"></div>
					<h4>修补金箔</h4>
				</a>
				<a href="#">
					<div class="pic bg7"></div>
					<h4>续维护费</h4>
				</a>
				<a href="#">
					<div class="pic bg8"></div>
					<h4>免费葬报名</h4>
				</a>
			</div>
		</div>
		<div class="environment shadow">
			<h2 class="tit1">
				<span class="txtb"><?=g('cp_name')?>环境</span>
			</h2>
			<div class="slider">
				<ul class="slider_main">
					<li style="display:block;"><a class="link" href=""><img src="/theme/m2/static/gls//img/banner/banner1.jpg" alt=""></a></li>
					<li><a class="link" href=""><img src="/theme/m2/static/gls//img/banner/banner2.jpg" alt=""></a></li>
					<li><a class="link" href=""><img src="/theme/m2/static/gls//img/banner/banner3.jpg" alt=""></a></li>
				</ul>
			</div>
		</div>
		<div class="pro shadow">
			<h2 class="tit1">
				<span class="txtc"><?=g('cp_name')?>产品</span>
			</h2>
			<div class="tabbox clearfix">
				<div class="items">
					<div class="bor">
						<div class="tab">
							<div class="tabtit posf">
								<span class="first active">
									传统墓位
<!--									<a href="http://www.abc.com" class="tab_more">更多</a>-->
								</span>
<!--								<span>-->
<!--									影雕-->
<!--									<a href="http://www.wlgc.com" class="tab_more">更多</a>-->
<!--								</span>-->
<!--								<span>-->
<!--									瓷像产品-->
<!--									<a href="http://www.gogogo.com" class="tab_more">更多</a>-->
<!--								</span>-->
<!--								<span>-->
<!--									改墓产品-->
<!--									<a href="http://www.what.com" class="tab_more">更多</a>-->
<!--								</span>-->
							</div>
							<div class="tabcon">
								<ul class="clearfix product_box" style="display: block;">
                                    <?php foreach ($list as $k => $v): ?>
									<li>
										<a class="tomb-avatar" href="<?=Url::toRoute(['/grave/home/default/view', 'id'=>$v['id']])?>">
                                            <img alt="<?=$v['name']?>" src="<?=$v['cover']?>">
                                        </a>
										<p>
											<span>价格：<i class="money">¥</i><?=$v['price']?></span>
											<span>位置：<?=$v['name']?></span>
											<span>状态：<?=$v['status_label']?></span>
										</p>
<!--										<div class="function-box clearfix right">-->
<!--											<a href="#"><img alt="网上预约" src="/theme/m2/static/gls//img/product/small_online_appointment.png"></a>-->
<!--											<a class="fav" href="#"><img alt="收藏" src="/theme/m2/static/gls//img/product/collection_btn.png"></a>-->
<!--											<a href="#"><img alt="购买" src="/theme/m2/static/gls//img/product/buy_small_btn.png"></a>-->
<!--										</div>-->
									</li>
                                    <?php endforeach;?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('.slider').cSwitch({
			bigImg : '.slider_main li',
			PNBtnShow : true,
			changeFade : true,
			changeTime : 3000
		});

		$('.tab').cSwitch({
			btnItems : '.tabtit span',
			bigImg : '.tabcon ul',
			PNBtnShow : false,
			changeFade : false,
			autoPlay : false
		}); 
	});
</script>