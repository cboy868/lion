<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\modules\shop\models\Category;


?>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 category-create">
				<div class="category-form">

				<?php 
				$category = Category::find()->asArray()->all();
				$options = [];
		        foreach ($category as $k => $v) {
		            if (!$v['is_leaf']) {
		                $options[$v['id']]['disabled'] = true;
		            }
		        }

		        $category = ArrayHelper::map($category, 'id', 'name');

				?>
				    <?php $form = ActiveForm::begin(); ?>

				    <?= $form->field($model, 'category_id')
                        ->dropDownList(Category::selTree(), ['options'=>$options])
                        ->hint('在此修改分类，如不修改，直接点击保存按扭');
                    ?>


					<div class="form-group">
				        <div class="col-sm-offset-2 col-sm-3">
				            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
				        </div>
				    </div>
				    
				    <?php ActiveForm::end(); ?>

				</div>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>