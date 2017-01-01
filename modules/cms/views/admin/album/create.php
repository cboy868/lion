<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Album */

$this->title = '上传' . $modinfo->name;
$this->params['breadcrumbs'][] = ['label' => $modinfo->name, 'url' => ['index','mod'=>\Yii::$app->getRequest()->get('mod')]];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	.old{
		display: none;
	}
</style>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1 class="new">
				添加<?=$modinfo->name?>
				<small class="tog">
					<!-- <i class="ace-icon fa fa-angle-double-right"></i> -->
					<a href="#" class="tg">/ [添加到已有 <?=$modinfo->name?>]</a>
				</small>
			</h1>

			<h1 class="old">
				上传到已有<?=$modinfo->name?>
				<small class="tog">
					<!-- <i class="ace-icon fa fa-angle-double-right"></i> -->
					<a href="#" class="tg">/ [添加 <?=$modinfo->name?>]</a>
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 album-create">
				<?= $this->render('_form', [
			        'model' => $model,
			        'attach'=> $attach,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('tog') ?>  
$(function(){

	$('.old').hide();
	$('.old').closest('.form-group').hide();
	$('.new .tog').click(function(){
		$('.new').hide();
		$('.new').closest('.form-group').hide();
		$('.old').show();
		$('.old').closest('.form-group').show();
	})
	$('.old .tog').click(function(){
		$('.new').show();
		$('.new').closest('.form-group').show();
		$('.old').hide();
		$('.old').closest('.form-group').hide();
	})

})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tog'], \yii\web\View::POS_END); ?>  