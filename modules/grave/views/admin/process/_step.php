<?php 
$step = Yii::$app->request->get('step');
?>
<ul class="steps col-xs-12" style="margin-left: 0">
	<li data-step="1" class="<?php if ($step >= 1): ?>active<?php endif ?>">
		<span class="step">1</span>
		<span class="title">Validation states</span>
	</li>

	<li data-step="2" class="<?php if ($step >= 2): ?>active<?php endif ?>">
		<span class="step">2</span>
		<span class="title">Alerts</span>
	</li>

	<li data-step="3" class="<?php if ($step >= 3): ?>active<?php endif ?>">
		<span class="step">3</span>
		<span class="title">Payment Info</span>
	</li>

	<li data-step="4" class="<?php if ($step >= 4): ?>active<?php endif ?>">
		<span class="step">4</span>
		<span class="title">Other Info</span>
	</li>
</ul>