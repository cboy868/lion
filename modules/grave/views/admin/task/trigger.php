<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\helpers\Url;

use app\core\widgets\ActiveForm;
use app\modules\shop\models\Goods as ShopGoods;
use app\modules\task\models\Goods;
use app\core\helpers\ArrayHelper;
use app\modules\shop\models\Category;


/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Info */

$this->title = '配置任务的触发条件';
$this->params['breadcrumbs'][] = ['label' => '任务分类信息', 'url' => ['info']];
$this->params['breadcrumbs'][] = '配置任务的触发条件';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 info-update">

				<div class="goods-form">

			    	<?php $form = ActiveForm::begin(); ?>



			    	<?php 
			    	$form->fieldConfig = [
			            'template' => '{label}{input}{hint}{error}',
			            'labelOptions' => [
			                'class' => 'control-label'
			            ],
			        ];

			    	 ?>

			    	 <?php 
			    	 	$cates = Category::find()->where(['status'=>Category::STATUS_NORMAL])->all()
			    	  ?>

				    <div class="panel panel-info">
					  <div class="panel-heading">按分类触发</div>
					  <div class="panel-body">
					    <?php foreach ($cates as $cate): ?>
							<label><input type="checkbox" name="category" value="<?=$cate->id?>" <?php if (in_array($cate->id, $model->res_id['category'])): ?>
								checked="checked"
							<?php endif ?>> <?=$cate->name?></label>
						<?php endforeach ?>
					  </div>
					</div>
				    <hr>
					

				    <div class="panel panel-info">
				    	<div class="panel-heading">按特定商品触发</div>
				    	<div class="panel-body">
				    	<?php foreach ($cates as $cate): ?>
				    		<h5>分类 <font color="green"> 【<?=$cate->name?>】</font> 下的商品</h5>
				    		<?php foreach ($cate->goods as $goods): ?>
				    			<label><input type="checkbox" name="goods" value="<?=$goods->id?>" <?php if (in_array($goods->id, $model->res_id['goods'])): ?>checked="checked"<?php endif ?>> <?=$goods->name?></label>
				    		<?php endforeach ?>
				    		<br>
				    	<?php endforeach ?>
				    	</div>
				    </div>
				    
				    <?php ActiveForm::end(); ?>

			</div>

				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('tag') ?>  

$(function () {
    $('input').change(function(){
    	var name = $(this).attr('name');
    	var rid = $(this).val();
    	var csrf = $('meta[name=csrf-token]').attr('content');
    	var checked = $(this).is(':checked') ? 1 : 0;
    	var data = {name:name, rid:rid, _csrf:csrf,checked:checked}

    	$.post("<?=Url::toRoute(['tri', 'info_id'=>Yii::$app->request->get('id')])?>", data, function(xhr){
    		if (!xhr.status) {
    			alert(xhr.info);
    		}
    	},'json');
    })
});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tag'], \yii\web\View::POS_END); ?> 