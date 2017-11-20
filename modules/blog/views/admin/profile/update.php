<?php

Yii::$app->params['cur_nav'] = 'blog_index';


$this->title = '修改日志内容';
$this->params['breadcrumbs'][] = ['label' => '博客列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 blog-update">
				 <?= $this->render('_form', [
				        'model' => $model,
                        'tags' => $tags
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
