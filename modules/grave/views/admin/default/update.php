<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
$this->title = '修改墓区【'.$model->name.'】内容';
$this->params['breadcrumbs'][] = ['label' => '墓区管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </div><!-- /.page-header -->
		<div class="row">
			<div class="col-xs-10 grave-update">
				 <?= $this->render('_form', [
				        'model' => $model,
                        'imgs' => $imgs
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
