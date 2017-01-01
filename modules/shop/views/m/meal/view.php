	
<link type="text/css" rel="stylesheet" href="/static/libs/meal/css/xiangqing.css" />  <!--本页css-->

<div class="sp3">
	<a href="index.html"><img class="sc4" src="/static/libs/meal/img/bac.png"/></a>
	<div class="sp4"><?=$meal['name']?></div>
	<div class="clear"></div>
</div>
<div class="xx1">
	<div class="xx2"><img class="xx3" src="<?=$meal['thumb']?>"/></div>
	<div class="xx4">
		<div class="xx5"><span style="letter-spacing:2px;">发表于</span> <?=date('Y-m-d H:i:s', $meal['created_at'])?></div>
		<div class="xx6">主料</div>

		<?php if (isset($rel[0])): ?>
			<?php foreach ($rel[0] as $k => $v): ?>
				<div class="xx7">
					<div class="xx8"><?=$v['mix_name']?></div>
					<div class="xx9"><?=$v['measure']?></div>
					<div class="clear"></div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
		
		
		<div class="xx6">辅料</div>
		<?php if (isset($rel[1])): ?>
			<?php foreach ($rel[1] as $k => $v): ?>
				<div class="xx7">
					<div class="xx8"><?=$v['mix_name']?></div>
					<div class="xx9"><?=$v['measure']?></div>
					<div class="clear"></div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
		
		<?php foreach ($process as $k => $v): ?>
			<div class="xx10">步骤<?=$v['step']?></div>
			<div class="xx11"><img class="xx12" src="<?=$v['thumb']?>"/></div>
			<div class="xx13"><?=$v['intro']?></div>
		<?php endforeach ?>
		
		<div class="xx14">烹饪技巧</div>
		<div class="xx15"><?=$meal['skill']?></div>
	</div>
</div>
