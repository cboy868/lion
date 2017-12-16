<?php 
use app\modules\grave\models\Process;
use app\core\helpers\Url;

$step = Yii::$app->request->get('step');
$tomb_id = Yii::$app->request->get('tomb_id');
?>
<style type="text/css">
.page-header{padding-bottom: 76px;}
.steps>li .step,.steps>li.complete .step:before{line-height:30px;background-color:#FFF;text-align:center}
.ace-spinner .spinbox-buttons>button.btn.spinbox-up:active{top:-1px}
.ace-spinner:not(.touch-spinner) .spinbox-buttons>.btn>.ace-icon{margin-top:-1px}
.ace-spinner.touch-spinner .spinbox-buttons{margin:0;font-size:0}
.ace-spinner.touch-spinner .spinbox-buttons .btn-sm{width:32px;padding-left:6px;padding-right:6px}
.ace-spinner.touch-spinner .spinbox-buttons .btn-xs{width:24px;padding-left:4px;padding-right:4px}
.ace-spinner.touch-spinner .spinbox-buttons .btn-lg{width:40px;padding-left:8px;padding-right:8px}
.ace-spinner.touch-spinner .spinbox-buttons>.btn{margin:0 1px!important}
.ace-spinner.touch-spinner .spinbox-buttons>.btn-xs{padding-top:3px;padding-bottom:3px}
.steps{list-style:none;display:table;width:100%;padding:0;margin:0;position:relative}
.steps>li{display:table-cell;text-align:center;width:1%}
.steps>li .step{border:5px solid #CED1D6;color:#546474;font-size:15px;border-radius:100%;position:relative;z-index:2;display:inline-block;width:40px;height:40px}
.steps>li:before{display:block;content:"";width:100%;height:1px;font-size:0;overflow:hidden;border-top:4px solid #CED1D6;position:relative;top:21px;z-index:1}
.steps>li.last-child:before{max-width:50%;width:50%}.steps>li:last-child:before{max-width:50%;width:50%}.steps>li:first-child:before{max-width:51%;left:50%}
.steps>li.active .step,.steps>li.active:before,.steps>li.complete .step,.steps>li.complete:before{border-color:#5293C4}
.steps>li.complete .step{cursor:default;color:#FFF;-webkit-transition:transform ease .1s;-o-transition:transform ease .1s;transition:transform ease .1s}
.steps>li.complete .step:before{display:block;position:absolute;top:0;left:0;bottom:0;right:0;border-radius:100%;content:"\f00c";z-index:3;font-family:FontAwesome;font-size:17px;color:#87BA21}
.step-content,.tree{position:relative}
.steps>li.complete:hover .step{-moz-transform:scale(1.1);-webkit-transform:scale(1.1);-o-transform:scale(1.1);-ms-transform:scale(1.1);transform:scale(1.1);border-color:#80afd4}
.steps>li.complete:hover:before{border-color:#80afd4}
.steps>li .title{display:block;margin-top:4px;max-width:100%;color:#949EA7;font-size:14px;z-index:104;text-align:center;table-layout:fixed;word-wrap:break-word}
.steps>li.active .title,.steps>li.complete .title{color:#2B3D53}.step-content .step-pane{display:none;min-height:200px;padding:4px 8px 12px}
.step-content .step-pane.active{display:block}.wizard-actions{text-align:right}@media only screen and (max-width:767px){.steps li .step,.steps li:after,.steps li:before{border-width:3px}
.steps li .step{width:30px;height:30px;line-height:24px}.steps li.complete .step:before{line-height:24px;font-size:13px}.steps li:before{top:16px}
</style>
<ul class="steps col-xs-12" style="margin-left: 0">
	<?php foreach (Process::$step as $k => $v): ?>
		<li data-step="<?=$k?>" class="<?php if ($step >= $k): ?>active<?php endif ?>">
		<a href="<?=Url::toRoute(['index', 'tomb_id'=>$tomb_id, 'step'=>$k])?>">
			<span class="step"><?=$k?></span>
		</a>
		<a href="<?=Url::toRoute(['index', 'tomb_id'=>$tomb_id, 'step'=>$k])?>">
			<span class="title"><?=$v['title']?></span>
		</a>
		</li>
	<?php endforeach ?>
</ul>

