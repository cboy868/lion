<?php

use app\core\helpers\Html;
use app\core\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Bag */

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '打包品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑【' . $model->title . '】';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<?= Html::encode($this->title) ?>
				<small>
					修改详细信息
					<?php if ($model->id): ?>
						<a href="<?=Url::toRoute(['rel', 'id'=>$model->id])?>" class="pull-right">编辑商品关联关系</a>
					<?php endif ?>
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 bag-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
