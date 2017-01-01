<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '选择模板';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=Html::a($this->title, ['theme'])?>
                <small>
                </small>
            </h1>
        </div><!-- /.page-header -->
		<div class="row">
			<?php foreach ($themes as $k => $v): ?>
		  <div class="col-sm-6 col-md-3">
		    <div class="thumbnail well">
		      <img src="<?=$v['screenshot']?>" alt="..." style="height:200px;">
		      <div class="caption">
		        <h4><?=$k?></h4>
		        <p>一些描述</p>
		        <p class="pull-right">
		        	<a href="#" class="btn btn-primary set" rel="<?=$k?>" role="button">启用</a>
		        	<a href="<?=Url::toRoute(['pre', 'theme' => $k])?>" class="btn btn-default" target="_blank" role="button">预览</a>
		        </p>
		        <p>&nbsp;</p>
		      </div>
		    </div>
		  </div>
		  <?php endforeach?>
		</div>
    </div><!-- /.page-content-area -->
    <input type="hidden" class="set-theme" value="<?=Url::toRoute('set-theme')?>">
</div>


<?php $this->beginBlock('per') ?>  
$(function(){
	$('.set').click(function(e){
		e.preventDefault();
		var url = $('.set-theme').val();
		var theme = $(this).attr('rel');
		$.get(url, {theme:theme}, function(xhr){
			if (xhr.status) {
				alert('成功');
			} else {
				alert('失败');
			}
		},'json');
	});
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>  
