<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '新闻资讯管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
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
			<div class="col-xs-12 news-update">
				<?php 
					$fm = '_' . $type . 'form';
				 ?>
				 <?= $this->render($fm, [
				        'model' => $model,
				        'imgs' => isset($imgs) ? $imgs :''
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>