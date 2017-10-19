<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->params['current_menu'] = 'memorial/blog/index';

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '纪念馆文章', 'url' => ['index']];
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
			<div class="col-xs-12 blog-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
