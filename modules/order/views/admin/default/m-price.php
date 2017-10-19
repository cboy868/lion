<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\ActiveForm;

?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
	<div class="row">
	  <div class="col-lg-12">

	  	<?php $form = ActiveForm::begin(); ?>
	    <div class="input-group">
	      <input type="text" class="form-control" name="OrderRel[price]" value="<?=$model->price?>">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="submit">修改</button>
	      </span>
	    </div><!-- /input-group -->
	    <?php ActiveForm::end(); ?>

	  </div><!-- /.col-lg-6 -->
	</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
