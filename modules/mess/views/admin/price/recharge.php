<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 mess-user-recharge-create">
				<?= $this->render('_form_recharge', [
			        'model' => $model,
                    'user' => $user,
                    'price'=> $price
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>