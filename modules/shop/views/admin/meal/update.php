<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model shop\models\Goods */

$this->title = '修改菜品';
$this->params['breadcrumbs'][] = ['label' => '返回菜品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . '<font color="red">【'.$model->name.'】</font>';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-10 goods-create">
				<?= $this->render('_form', [
				'model'=>$model, 
				'attrs'=>$attrs, 
				'specs' => $specs,
				'tables' => $tables,
				'attr_sels' => $attr_sels,
				'skus' => $skus,
				'av' => []
				]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>