<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 blog-update">
				 <?= $this->render('_form', [
				        'model' => $model,
                        'memorials' => $memorials,
                        'tags' => $tags
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
