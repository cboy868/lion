<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Goods */

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<?= Html::encode($this->title) ?>
				<small>
					修改详细信息
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 goods-update">
				 <?= $this->render('_form', [
				        'model' => $model,
						'attrs'=>$attrs, 
						'specs' => $specs,
						'tables' => $tables,
						'attr_sels' => $attr_sels,
						'skus' => $skus,
						'tags' => $tags,
						'imgs' => $imgs,
						'av' => []
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
