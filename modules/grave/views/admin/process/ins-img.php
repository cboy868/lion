<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
// use app\assets\PluploaduiAssets;
use app\core\models\Attachment;
use app\core\widgets\Ueditor\Ueditor;
use app\modules\grave\models\Tomb;
use app\assets\PluploadAssets;
// PluploaduiAssets::register($this);
ExtAsset::register($this);
PluploadAssets::register($this);

?>

<style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        line-height: 1.4;
        border: none;
    }
    .help-block {
        margin-bottom: 0;
        margin-top: 0;
    }
    .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td
    {
        padding: 2px;
    }
    .detail{display: none;}
    .insnote img{max-width: 100px;}
</style>


<div class="page-content" id="ins-container">
    <!-- /section:settings.box -->
    <div class="page-content-area">
    	<div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

        <?=\app\core\widgets\Alert::widget();?>


        <?php 
        	$tomb = Tomb::findOne(Yii::$app->request->get('tomb_id'));
         ?>
        <?php if ($tomb->hasIns()): ?>
            <div class="panel panel-default">
              <div class="panel-body">
                <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="<?=$goods->getThumb('100x100')?>">

                <div style="display:inline-block;float:left;margin-left:20px;">
                    碑名: <?=$goods->name?> <br>
                    碑属性:

                    <?php foreach ($goods->getAv()['attr'] as $k => $av): ?>
                        <?=$av['attr_name'] ?> : <?=$av['attr_val']?$av['attr_val']:$av['value']?>,
                    <?php endforeach ?>
                </div>
              </div>
            </div>
        <!-- Nav tabs -->


            <?php if (!$model->is_confirm):?>
                <ul class="nav nav-tabs col-xs-6" role="tablist" id="tabs">
                    <li role="presentation" class="active sel-type" rel="3">
                        <a href="<?=Url::current(['type'=>0])?>">上传图片</a>
                    </li>
                  <li role="presentation" class="sel-type" rel="1">
                        <a href="<?=Url::current(['type'=>1])?>">自动碑文</a>
                  </li>
                    <li class="sel-type" rel="1">
                        <a href="<?=Url::current(['type'=>2])?>">手写碑文</a>
                    </li>

                </ul>
            <?php endif;?>

		<!-- Tab panes -->
			<div class="row" role="">
				<?php $form = ActiveForm::begin(['id'=>'img-ins-form', 'options'=>['class'=> 'form-horizontal']]); ?>

					<div id="img-ins-boxs" class=" tab-pane <?php if ($model->type == 0): ?>active <?php endif ?>" role="tabpanel">
						<div class="col-xs-12">
							<div class="panel panel-default">
					  			<div class="panel-body  form-horizontal" role="form">
					  				<div class="row">

					  					<?php foreach ($pos as $k => $v): ?>
							                <div class="col-xs-4 address-index">
							                    <div class="panel panel-info">
							                        <div class="dHandler panel-heading"><?=$pos[$k]?>信息
							                            <button type="button" class="delit close" style="display:none;">
							                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
							                               <span class="sr-only">Close</span>
							                            </button> 
							                        </div>

							                         <a href="javascript:;" id="filePicker-<?=$k?>" class="thumbnail filelist-<?=$k?> filePicker" 
							                         		style="max-width:90%;max-height:90%;"
									                        data-url="<?=Url::toRoute(["pl-upload"])?>" 
									                        data-res_name="tomb"
									                        data-use="thumb"
							                         		>
							                              <img src="<?=$model->getImg($k, '/static/images/up.png')?>" style="max-width:90%;max-height:90%;">
							                              <input name="Ins[img][<?=$k?>]" class="ins-img" type="hidden" value="<?=isset($imgs->$k)? $imgs->$k : ''?>" />
							                        </a>
							                    </div>
							                    <div class="hr hr-18 dotted hr-double"></div>
							                </div><!-- /.col -->
							            <?php endforeach ?>
					  				</div>
								</div>
							</div>
						</div>
					</div>
					<!--form 里第二个 div img-->

					<div class="col-xs-12">
						<div class="panel panel-default">
					  		<div class="panel-heading">明细( <font color="green">以下内容为新增字数及费用，如有误，直接修改即可</font>)</div>
				  			<div class="panel-body  form-horizontal row" role="form">
				  			<?php 
				  			$form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
            				$form->fieldConfig['template'] = '{label}<div class="col-sm-9">{input}{hint}{error}</div>'; 
				  			 ?>
				  				<div class="col-xs-6">
				  					<?= $form->field($model, 'paint')->dropDownList(Ins::paint(), ['style'=>'width:70%', 'class'=>'paint form-control']) ?>
				  					<?php //echo $form->field($model, 'new_font_num')->textInput(['style'=>'width:70%', 'id'=>'letter_num'])->label('总字数') ?>
				  					<?= $form->field($model, 'new_big_num')->textInput(['style'=>'width:70%', 'id'=>'big_new'])->label('大字') ?>
				  					<?= $form->field($model, 'new_small_num')->textInput(['style'=>'width:70%', 'id'=>'small_new'])->label('小字') ?>
                                    <?= $form->field($model, 'paint_price')->textInput(['style'=>'width:70%', 'id'=>'paint_price']) ?>
                                    <?= $form->field($model, 'letter_price')->textInput(['style'=>'width:70%', 'id'=>'letter_price']) ?>
                                    <?= $form->field($model, 'tc_price')->textInput(['style'=>'width:70%', 'id'=>'tc_price']) ?>

                                    <?= $form->field($model, 'pre_finish')->textInput([
                                        'style'=>'width:70%', 
                                        'dt'=>'true', 
                                        'dt-year' => 'true',
                                        'dt-month' =>'true',
                                        'class'=>'dt_pre_finished'
                                        ])->hint('立碑日期在三天内，需收加急费') ?>
				  				</div>
								<div class="col-xs-5">

								<?php 
								$form->fieldConfig['labelOptions']['class']='control-label';
								$form->fieldConfig['template'] = '{label}{input}{hint}{error}'; 
								 ?>
								<?= $form->field($model, 'note')->textArea(['rows'=>5])->label('碑文备注') ?>
		                        
								</div>
							<?php if(!empty($insdes)):?>
		                        <div class="col-xs-12">
		                            <h3>碑文备注</h3>
		                            <table class="table insnote">
		                            <?php foreach ($insdes as $de): ?>
		                            	<tr>
		                                <td style='width:80px;'>
		                                    <?=$de['username']?><br/>
		                                    <textarea  style="display: none" class="con"><?=$de['content']?></textarea>
		                                    <a class="modifyNote" title="修改" rid="<?=$de['id']?>" href="#" rel="<?=$de['res_id']?>" style="margin-left:8px;">
		                                        <i class="icon-edit bigger-230"></i>修改备注
		                                    </a>
		                                </td>
		                                <td>添加时间：<?=$de['add_time']?><br/><?=$de['content']?></td>
		                                </tr>
		                            <?php endforeach ?>
		                            </table>
		                        </div>
		                        <?php endif;?>
							</div>
						</div>
					</div>
				<!-- Button trigger modal -->
				<!-- Modal -->

				<input type="hidden" name="tomb_id" value="<?=$model->tomb_id?>" />


		        <div class="text-center cols-md-12">
		         <div class="form-group">
		            <div class="col-sm-12" style="text-align:center;">   
		                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                        <?php if ($model->is_confirm): ?>
                            <span class="btn btn-default btn-lg" type="button">碑文已确认，不可修改</span>
                        <?php else:?>
                            <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                        <?php endif;?>
		                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
		            </div>
		        </div>
				<!-- </form> -->
				<?php ActiveForm::end(); ?>
				<hr />
			</div><!--auto row-->
		</div>

	<?php else: ?>

		<?php 
		 $goods = $this->context->module->params['goods'];
         $ins = $goods['cate']['ins'];
		 ?>
		<div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
		请
		<small>
            <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$ins, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                购买墓碑
            </a>
         </small>
		</div>
    <?php endif ?>

		<?=$this->render('_order', ['order'=>$order]) ?>
		
</div>


<?php $this->beginBlock('up') ?>
var fee = eval('(' + '<?=json_encode($fee)?>'+ ')');
function calFee()
{
	var big = $('#big_new').val();
	var small = $('#small_new').val();
	var paint = $('.paint').val();

	var letter = parseInt(big) * fee.letter.big[paint] + parseInt(small) * fee.letter.small[paint];
	var paint = parseInt(big) * fee.paint.big[paint] + parseInt(small) * fee.paint.small[paint];

	if (!isNaN(letter) && !isNaN(paint)) {
		$('#letter_price').val(letter);
		$('#paint_price').val(paint);
	}
	
}

$(function(){
	calFee();

	$('#big_new, #small_new, .paint').change(function(){
		calFee();
	});
})


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 



