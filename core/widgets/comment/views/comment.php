<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\Ueditor\Ueditor;
use yii\widgets\LinkPager;
use app\core\helpers\StringHelper;






use app\assets\FormAsset;
FormAsset::register($this);
?>

<style type="text/css">
	.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
	    font-weight: 700;
	    color: #428bca;
	    background-color: transparent;
	    border-color: #e5e5e5;
	    border-left: 4px solid #428bca;
	    border-left-color: #428bca;
	}
	.list-group-item{
		padding-left: 5px;
	}
	.list-group-item .i-img{
		margin-right: 10px;
	}
</style>

<div class="page-content">

		<div class="list-group">
			<?php foreach ($dataProvider->getModels() as $k => $v): ?>
				<div href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading"><?=$v->fromUser->username?>
					    <small class="pull-right"><?=date('Y-m-d H:i', $v->created_at)?></small>
					    <a href="#" class="pull-left i-img"><img height="60" src="<?=$v->fromUser->getAvatar('60x60', '/static/images/default.png')?>" ></a>
				    
				    </h4>
				    <div class="list-group-item-text">
				    	<?=$v->content?>
				    </div>
				  </div>
			<?php endforeach ?>
			  
		</div>

		<?php 
			echo LinkPager::widget([
				    'pagination' => $dataProvider->pagination,
				]);
		 ?>
	<!-- /section:settings.box -->
	<div class="page-content-area">

		
		

		<div class="row">
			<div class="col-xs-12 comment-create">
				<div class="comment-form">
					<?php $form = ActiveForm::begin(['action'=>Url::toRoute(['comment']),  'id' => $model->formName()]); ?>
							<?= $form->field($model, 'pid')->hiddenInput(['value'=>$pid ? $pid : 0, 'class'=>'c-pid'])->label(false) ?>
					        <?= $form->field($model, 'res_name')->hiddenInput(['maxlength' => true, 'value'=>$res_name, 'class'=>'c-res_name'])->label(false) ?>
					        <?= $form->field($model, 'res_id')->hiddenInput(['value'=>$res_id,'class'=>'c-res_id'])->label(false) ?>
					        <?= $form->field($model, 'to')->hiddenInput(['value'=>$to ? $to : 0, 'class'=>'c-to'])->label(false) ?>
					        <?= $form->field($model, 'content')->widget('app\core\widgets\Ueditor\Ueditor',[
					        	'option' =>[
					        		'res_name'=>'comment', 
					        		'use'=>'comment', 
					        		'class'=>'c-content'
					        		],
					        	'jsOptions' =>[
					        		'lang' =>'en', //中文为 zh-cn

					        		'initialFrameHeight' => '200',
							        //定制菜单
							        'toolbars' => [
							            [
							                'fullscreen', 'source', 'undo', 'redo', '|',
							                'fontsize',
							                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
							                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
							                'forecolor', 'backcolor','emotion', '|',
							                'lineheight', '|',
							                'indent', '|'
							            ],
							        ]
					        	]

					        		])->label(false);?>

					        <div class="form-group">
						        <div class="col-sm-3">
						        	<?=  Html::submitButton('保 存', ['class' => 'btn btn-info btn-block comment', "data-loading-text"=>"评论提交, 请稍后..."]) ?>	
						        </div>
						    </div>
					        
					<?php ActiveForm::end(); ?>
				</div>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('form') ?>  
$(function(){

	$('#<?=$model->formName()?>').ajaxForm({
		beforeSubmit: function(){
			btn = $('.comment').button('loading');
		},
		success:function(xhr, statusText){
			if (xhr.status == true) {
				var comment = xhr.data['comment'];
				var user = xhr.data['user'];
				var html = '<div href="#" class="list-group-item active">' +
				    '<h4 class="list-group-item-heading">' + user.username +
					    '<small class="pull-right"><?=date("Y-m-d H:i")?></small>'+
					    '<a href="#" class="pull-left i-img"><img height="60" src="' + user.avatar + '" ></a>'+
				    '</h4>'+
				    '<div class="list-group-item-text">'+comment.content+'</div>' +
				  '</div>'

				$('.list-group').append(html);
				btn.button('reset');
			}
			return false;
		}
	});
})  

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['form'], \yii\web\View::POS_END); ?>