<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model shop\models\Goods */

$this->title = '的烹饪方法';
$this->params['breadcrumbs'][] = ['label' => '菜品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<font color="red">【'.$model->name.'】</font>' . $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-10 goods-create">
				<?= $this->render('_mform', [
				'model'=>$model, 
				'mixs'=>$mixs,
				'mixrel' => $mixrel,
				'process' => $process,
				'pics' => $pics
				]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>