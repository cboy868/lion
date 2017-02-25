<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
use app\assets\PluploaduiAssets;
use app\core\models\Attachment;
use app\core\widgets\Ueditor\Ueditor;
use app\modules\grave\models\Tomb;

PluploaduiAssets::register($this);
ExtAsset::register($this);
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
        	<div class="col-xs-12">
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
	        </div>
        <!-- Nav tabs -->


		<ul class="nav nav-tabs col-xs-6" role="tablist" id="tabs">
			<li role="presentation" class="<?php if ($model->type == 0): ?>active <?php endif ?> sel-type" rel="3">
			  	<a href="#img-ins-boxs" role="tab" data-toggle="tab">上传图片</a>
			</li>
		  <li role="presentation" class="<?php if ($model->type == 1): ?>active <?php endif ?> sel-type" rel="1">
		  	<a href="#auto-ins-boxs" role="tab" data-toggle="tab">自动碑文</a>
		  </li>
		  
		</ul>

		<!-- Tab panes -->
			<div class="row" role="">
				<?php $form = ActiveForm::begin(['id'=>'auto-ins-form', 'options'=>['class'=> 'tab-content form-horizontal']]); ?>
				<!-- <form role="form" id='auto-ins-form' method='post' action='' class="tab-content"> -->
					<div id="auto-ins-boxs" class="tab-pane <?php if ($model->type == 1): ?>active <?php endif ?>" role="tabpanel">
						<div class="col-xs-12">
							<div id="select-ins" class="collapse">

		                        <div class="row-fluid ">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">&nbsp;
		                                    碑前文 <span style="font-size:11px;color:red;">此功能只适用于常规碑文，如果碑文排版过于特殊，请使用图片上传方式保存碑文</span>
		                                </div>
		                                <div class="panel-body front_images">
		                                <?php foreach ($cases['front_cases'] as $case): ?>
		                                	<div style="float:left;" class="ins_image">
	                                            <img cfg_id="<?=$case['cfg_id']?>" case_id="<?=$case['id']?>" class="img-thumbnail sel <?php if ($case['id'] == $cases['front_current_case_id']): ?>front_selected<?php endif ?>" alt="140x140" src="<?=$case['img']?>" style="width: 140px; height: 140px;" rel="front">
	                                            <div class="caption">
	                                                <h5><?=$case['note']?>
									        	<span class="sel_style">

									        	<?php if ($case['id'] == $cases['front_current_case_id']): ?>
									        		(<i class="red fa fa-check fa-2"></i>)
									        	<?php endif ?>
									        	</span>
	                                                </h5>
	                                            </div>
	                                        </div>
		                                <?php endforeach ?>
		                                </div>
		                            </div>
		                        </div><!-- PAGE CONTENT ENDS -->

		                        <div class="row-fluid">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">&nbsp;
		                                    碑后文
		                                </div>
		                                <div class="panel-body back_images">
		                                	 <?php foreach ($cases['back_cases'] as $case): ?>
		                                        <div style="float:left;">
		                                            <img cfg_id="<?=$case['cfg_id']?>" case_id="<?=$case['id']?>" class="img-thumbnail sel <?php if ($case['id'] == $cases['back_current_case_id']): ?>back_selected<?php endif ?>" alt="140x140" src="<?=$case['img']?>" rel="back" style="width: 140px; height: 140px;">
		                                            <div class="caption">
		                                                <h5><?=$case['note']?>
										        	<span class="sel_style">
											        	<?php if ($case['id'] == $cases['back_current_case_id']): ?>
											        		(<i class="red fa fa-check fa-2"></i>)
											        	<?php endif ?>
											        </span>
		                                                </h5>
		                                            </div>
		                                        </div>
		                                    <?php endforeach ?>

		                                </div>

		                            </div>
		                        </div><!-- PAGE CONTENT ENDS -->

		                         <!-- <div class="row-fluid">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">&nbsp;
		                                    盖板
		                                </div>
		                                <div class="panel-body back_images">
		                                	 <?php foreach ($cases['cover_cases'] as $case): ?>
		                                        <div style="float:left;">
		                                            <img cfg_id="<?=$case['cfg_id']?>" case_id="<?=$case['id']?>" class="img-thumbnail sel <?php if ($case['id'] == $cases['cover_current_case_id']): ?>back_selected<?php endif ?>" alt="140x140" src="<?=$case['img']?>" rel="back" style="width: 140px; height: 140px;">
		                                            <div class="caption">
		                                                <h5><?=$case['note']?>
										        	<span class="sel_style">
											        	<?php if ($case['id'] == $cases['cover_current_case_id']): ?>
											        		(<i class="red fa fa-check fa-2"></i>)
											        	<?php endif ?>
											        </span>
		                                                </h5>
		                                            </div>
		                                        </div>
		                                    <?php endforeach ?>

		                                </div>

		                            </div>
		                        </div> -->
		                        <!-- PAGE CONTENT ENDS -->
							<!-- PAGE CONTENT ENDS -->
							</div>
						</div>
						<div class="clearfix"></div>

						<div class="col-xs-12">
							<div class="panel panel-default ">
					          <div class="panel-heading">&nbsp;
					          	<span>
					          		<a  href="javascript:;" class="" data-toggle="collapse" data-target="#select-ins">
		                              选择碑文样式
		                            </a>
					          	</span>
		                          <?php if(!$model['is_stand']):?>
		                            <span class="pull-right">繁体简体
		                                <select name="is_tc" id="is_tc">
		                                    <option value="0" <?php if ($model->is_tc == 0): ?>selected<?php endif ?>>简体</option>
		                                    <option value="1" <?php if ($model->is_tc == 1): ?>selected<?php endif ?>>繁体</option>
		                                </select>
		                            </span>

		                            <span class="pull-right">字体
		                                <select name="font_style" id="font_style">
		                                    <option value="0" <?php if ($model->font == 0): ?>selected<?php endif ?>>华文新魏</option>
		                                    <option value="2" <?php if ($model->font == 2): ?>selected<?php endif ?>>方正隶书</option>
		                                    <option value="3" <?php if ($model->font == 3): ?>selected<?php endif ?>>宋 体</option>
		                                </select>
		                            </span>
		                          <?php else:?>
			                          <input type="hidden" name="is_tc" value="<?=$model->is_tc?>"/>
			                          <input type="hidden" name="font" value="<?=$model->font?>"/>
		                          <?php endif;?>
					        	
					            <span class="pull-right">碑后文字&nbsp;
						            <select name="text" id="selectback">
						                <option>点此更换碑后文</option>
						                <?php foreach ($back_word as $v): ?>
						                	<option value="<?=$v?>"><?=$v?></option>
						                <?php endforeach ?>
						            </select>
					            </span>
					          </div>

					        <div id="front_prices" style="display:none;"></div>
			                <div id="back_prices" style="display:none;"></div>

					          <div class="panel-body">
							    <div class="row">
									<div class="col-xs-2">
										<div class="panel panel-default">
										  <div class="panel-heading">修改碑文内容</div>
										  <div class="panel-body btn-group-vertical">
										    <button type="button" class="btn btn-default" id="edit_front" data-toggle="modal" data-target="#ins_front">
											  修改正面
											</button>
											<button type="button" class="btn btn-default" id="edit_back" data-toggle="modal" data-target="#ins_back">
											  修改背面
											</button>
											
										  </div>
										</div>
									</div>
									<div class="col-xs-10">
										<div class="row">
											<div class="col-sm-6 col-md-5">
											    <div class="thumbnail">
		                                            <a href="<?=$model->getImg('front')?>" class="artimg ">
		                                              <img class="front_img image" src="<?=$model->getImg('front')?>" alt="...">
		                                              <input type="hidden" name="front_img" />
		                                            </a>
											      <div class="caption">
											        <h3>碑前文</h3>
											        <p> 大字<i class='front_big_count'>0</i> 小字<i class='front_small_count'>0</i>&nbsp;
		                                                <span class="label_kezi">
								                       刻字费<i class='front_letter_price'>0</i>元&nbsp;
								                       颜料费<i class='front_paint_price'>0</i>元&nbsp;
		                                                </span>
		                                            </p>
											      </div>
											    </div>
											</div>
											<div class="col-sm-6 col-md-5">
											    <div class="thumbnail">
											    	<a href="<?=$model->getImg('back')?>" class="artimg">
												      <img class="back_img image" src="<?=$model->getImg('back')?>" alt="...">
												      <input type="hidden" name="back_img" />
												  </a>
											      <div class="caption">
											        <h3>碑后文</h3>
											        <p> 大字<i class='back_big_count'>0</i> 小字<i class='back_small_count'>0</i>&nbsp;
		                                                <span class="label_kezi">
								                       刻字费<i class='back_letter_price'>0</i>元&nbsp;
								                       颜料费<i class='back_paint_price'>0</i>元&nbsp;
		                                                </span>
		                                            </p>

											        
											      </div>
											    </div>
											</div>
											
										</div>
									</div>
								</div>
							  </div>
					        </div>
						</div> 
					</div> <!--form 里第一个 div auto-->

					<!-- 手动上传图片 -->





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
							                         <a href="javascript:;" id="filePicker-<?=$k?>" class="thumbnail filelist-<?=$k?> filePicker" style="max-width:380px;max-height:280px;">
							                              <img src="<?=$model->getImg($k)?>">
							                              <input name="Ins[img][<?=$k?>]" class="ins-img" type="hidden" value="<?=$imgs->$k?>" />
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
					  		<div class="panel-heading">明细</div>
				  			<div class="panel-body  form-horizontal row" role="form">
				  			<?php 
				  			$form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
            				$form->fieldConfig['template'] = '{label}<div class="col-sm-9">{input}{hint}{error}</div>'; 

				  			 ?>
				  				<div class="col-xs-6">
				  					<?= $form->field($model, 'paint')->dropDownList(Ins::getPaint(), ['style'=>'width:70%']) ?>
				  					<?php //echo $form->field($model, 'new_font_num')->textInput(['style'=>'width:70%', 'id'=>'letter_num'])->label('总字数') ?>
				  					<?= $form->field($model, 'big_new')->textInput(['style'=>'width:70%', 'id'=>'big_new'])->label('大字') ?>
				  					<?= $form->field($model, 'small_new')->textInput(['style'=>'width:70%', 'id'=>'small_new'])->label('小字') ?>
                                    <?= $form->field($model, 'paint_price')->textInput(['style'=>'width:70%', 'id'=>'paint_price']) ?>
                                    <?= $form->field($model, 'letter_price')->textInput(['style'=>'width:70%', 'id'=>'letter_price']) ?>
                                    <?= $form->field($model, 'tc_price')->textInput(['style'=>'width:70%', 'id'=>'tc_price']) ?>

                                    <?= $form->field($model, 'pre_finish')->textInput([
                                        'style'=>'width:70%', 
                                        'dt'=>'true', 
                                        'y-chante' => 'true',
                                        'm-change' =>'true',
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
				<div class="modal fade" id="ins_front" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="myModalLabel">修改碑正文</h4>
				      </div>
				      <div class="modal-body">
				        	<div class="panel panel-default">
							  <div class="panel-heading">公共部分</div>
							  <div class="panel-body">
							  	<table class="table">
							  		<tr>
							  			<td>标签一</td>
							  			<td><input type="text" name="front[born][content]" class="form-control input-sm" value="<?=$front['born'][0]['content']?>"></td>
							  		</tr>

		                            <tr>
		                                <td>标签二</td>
		                                <td><input type="text" name="front[die][content]" class="form-control input-sm" value="<?=$front['die'][0]['content']?>"></td>
		                            </tr>


							  		<tr>
							  			<td>尊称</td>
							  			<td><input type="text" name="front[honorific][content]" class="form-control input-sm" value="<?=$front['honorific'][0]['content']?>"></td>
							  		</tr>

		                            <tr>
		                                <td>之墓</td>
		                                <td><input name="front[tail][content]" type="text" class="form-control input-sm" value="<?=$front['tail'][0]['content']?>"></td>
		                            </tr>

							  		<tr>
							  			<td>落款</td><td><input type="text" name="front[inscribe][content]" class="form-control input-sm" value="<?= $front['inscribe'][0]['content'] ?>"></td>
							  		</tr>
		                            <tr>
		                                <td>落款时间</td><td><input type="text" name="front[inscribe_date][content]"  class="form-control input-sm" value="<?=$front['inscribe_date'][0]['content']?>"></td>
		                            </tr>

		                            <tr>
		                                <td>享年标签</td><td><input type="text" name="front[agelabel1][content]" class="form-control input-sm" value="<?=$front['agelabel1'][0]['content']?>"></td>
		                                <td>享年尾标签</td><td><input type="text" name="front[agelabel2][content]"  class="form-control input-sm" value="<?=$front['agelabel2'][0]['content']?>"></td>
		                            </tr>

		                            <tr>
		                                <td>享年标签</td><td><input type="text" name="front[agelabel1][content]" class="form-control input-sm" value="<?=$front['agelabel1'][0]['content']?>"></td>
		                                <td>享年尾标签</td><td><input type="text" name="front[agelabel2][content]"  class="form-control input-sm" value="<?=$front['agelabel2'][0]['content']?>"></td>
		                            </tr>
		                            <tr>
		                                <?php if($is_god):?>
		                                <td>圣名标签</td>
		                                <td><input type="text" name="front[second_name_label][content]" class="form-control input-sm" value="<?=$front['second_name_label'][0]['content']?>"></td>
		                                <?php endif;?>
		                            </tr>
							  	</table>
								</div>
							  </div>
				        	<div class="panel panel-default">

				        		<?php foreach ($front['dead'] as $key=>$vo): ?>

				       				<?php if($dead_list[$key]['is_ins']==0):?>
				       				<?php else:?>
							  			<div class="panel-heading">
		                                    <a class="btn btn-info btn-dis btn-xs" href="#" rel="detail-<?=$key?>">
		                                        <?=$vo['title']['content']?> <?=$vo['name']['content']?>
		                                    </a>
		                                </div>
									  	<div class="panel-body">
									  	<table class="table table-noborder detail detail-<?=$key?>">
		                                    <input type="hidden" name="dead[<?=$key?>][name][is_die]"  value="<?=$vo['name']['is_die']?>" />
									  		<tr>
									  			<td>称谓</td>
									  			<td><input type="text" name="dead[<?=$key?>][title][content]" class="form-control input-sm" value="<?=$vo['title']['content']?>" /></td>
									  			<td>姓名</td>
									  			<td><input type="text" name="dead[<?=$key?>][name][content]" class="form-control input-sm" value="<?=$vo['name']['content']?>" /></td>
									  		</tr>

									  		<tr>
									  			<td>生日</td>
									  			<td><input name="dead[<?=$key?>][birth][content]" value="<?=$vo['birth']['content']?>"  type="text" class="form-control input-sm"></td>
									  			<td>携子</td>
									  			<td><input name="dead[<?=$key?>][follow][content]" value="<?=$vo['follow']['content']?>" type="text" class="form-control input-sm"></td>
									  		</tr>
									  		
									  		<?php if($dead_list[$key]['is_alive']==0):?>
										  		<tr>
										  			<td>祭日</td><td><input name="dead[<?=$key?>][fete][content]" value="<?=$vo['fete']['content']?>"  type="text" class="form-control input-sm"></td>
										  			<td>享年</td><td><input name="dead[<?=$key?>][age][content]" value="<?=$vo['age']['content']?>" type="text" class="form-control input-sm"></td>
										  		</tr>
										  	<?php endif;?>
										  	<notempty name="is_god">
										  	<tr>
									  			<td>圣名</td>
									  			<td><input  name="dead[<?=$key?>][second_name][content]" value="<?=$vo['second_name']['content']?>" type="text" class="form-control input-sm"></td>
									  		</tr>
									  		</notempty>
									  	</table>
									  </div>
									<?php endif;?>
				    			<?php endforeach ?>
							</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
				        <button type="button" class="btn btn-primary front-edit-save"> 保 存 </button>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="modal fade" id="ins_back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="myModalLabel">修改碑后文</h4>
				      </div>
				      <div class="modal-body">
				        	<table class="table table-noborder back-line">
						  		<tr>
						  			<td>落款</td>
						  			<td><input name="back[inscribe][content]" value="<?=$back['inscribe']['content']?>" type="text" class="form-control input-sm"></td>
		                            <!--
		                            <td><input name="back[inscribe][content]" value="<?=$back['inscribe']['content']?>" type="text" class="form-control input-sm"></td>
		                          <td>落款时间</td>
		                            <td><input name="back[inscribe_date][content]" dt='true' value="<?=$back['inscribe_date']['content']?>" type="text" class="form-control input-sm"></td>
		                         -->
		                        </tr>

		                        <?php foreach ($back['main']['content'] as $key => $bk): ?>
		                        	<tr class="main-line">
						            	<td>正文</td>
						            	<td><input name="back[main][content][]" value="<?=$bk?>" type="text" class="form-control input-sm"></td>
							  			<td  colspan="2">
							  				<eq name="key" value="0">
							  					<button type="button" class="btn btn-default add-line"> 添 加 </button>
							                </eq>
							  				
							  				<neq name="key" value="0">
							  					<button type="button" class="btn btn-default del-line"> 删 除 </button>
							                </neq>
							  			</td>
						            </tr>
		                        <?php endforeach ?>
						  	</table>
		                  <!-- <a href="#" target="_blank">碑文范例</a> -->
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
				        <button type="button" class="btn btn-primary back-edit-save"> 保 存 </button>
				      </div>
				    </div>
				  </div>
				</div>


				<input type="hidden" name="tomb_id" value="<?=$model->tomb_id?>" />
				<input type="hidden" name="type" value="<?=$model->type?>" />

				<input type="hidden" name="font_num" value="0" />

				<input type="hidden" name="front_case" value="" />
				<input type="hidden" name="back_case" value="" />
				<input type="hidden" name="cover_case" value="" />

				<input type="hidden" class="per_price"/>

				<input type="hidden" class="is_second" value="<?=$is_second?>"/>

				<div class="cache"></div>

		        <div class="text-center cols-md-12">

		         <div class="form-group">
		            <div class="col-sm-12" style="text-align:center;">   
		                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
		                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
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
            <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$ins, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank">
                购买墓碑
            </a>
         </small>
		</div>
    <?php endif ?>

		<?=$this->render('_order', ['order'=>$order]) ?>
		
</div>
<!-- 碑后文的每一行 -->
<table id="backclone" style="display:none;">
	<tr class="main-line">
	    <td>正文</td>
    	<td><input name="back[main][content][]" class="form-control input-sm input"></td>
		<td  colspan="2">
				<button type="button" class="btn btn-default add-line"> 添 加 </button>
				<button type="button" class="btn btn-default del-line"> 删 除 </button>
		</td>
	</tr>
</table>
<!-- 
<link href="/static/assets/js/colorbox/colorbox.css" rel="stylesheet" type="text/css">
<script src="/static/assets/js/colorbox/jquery.colorbox-min.js"></script> -->

<?php $this->beginBlock('up') ?>  
$(function(){
	var changed = "{$inscription_info.changed}";
	var insContainer = $('#ins-container');
	var insForm = insContainer.find('#auto-ins-form');
	var insSaveBtn = insContainer.find('.save-ins');
	var selIns = insContainer.find('.sel');

	upinit();

    $('.btn-dis').click(function(e){
        e.preventDefault();
        var rel = $(this).attr('rel');
        $('.'+rel).toggle();
    });

    $('.modifyNote').click(function(){
        var url = '{:U("record/addnote")}';
        var res_id   = $(this).attr('rel');
        var id = $(this).attr('rid');
        var type = 'inscription';
        var con = $(this).siblings('.con').val();
        bootbox.dialog({
            title: "编辑备注",
            message: '<textarea name="" id="add_note" style="height:100px;width:400px;">'+con+'</textarea>',
            buttons:
            {
                "success" :
                {
                    "label" : "<i class='icon-ok'></i> 修改",
                    "className" : "btn-sm btn-success",
                    "callback": function() {
                        var con = $('#add_note').val();
                        var data = {res_name:type,res_id:res_id,content:con,id:id};
                        $.post(url, data, function(json){
                            if (json.status == 1) {
                                window.location.reload();
                            } else {
                                alert(json.msg);
                            }
                        },'json');
                    }
                }
            }
        })

        return false;
    });

    $('.dt_pre_finished').datepicker({
        minDate:'%y-%M-%d'
    });

//    $('.date').datepicker({dateFormat:'yy.mm.dd'});
//    $('.date').datepicker();
	//图片碑文

	var ins_type = $('input[name=type]',insContainer).val();

	if (ins_type==1) {
		auto(insContainer, changed);
	};

	if (ins_type==0) {
		//img(insContainer);
	};

    $('.is_created').change(function(){
        var is_created = $(this).val();
        var url = '/admin/ins/changecreated';
        var tomb_id = $('input[name=tomb_id]').val();
        $.get(url, {tomb_id:tomb_id},function(xhr){
            if(xhr.status) {
                alert('修改成功');
            } else {
                alert('修改失败, 可能碑文尚未生成');
            }
        },'json');

    });

	$('#tabs a', insContainer).click(function (e){
		e.preventDefault();
		var type = $(this).parent().attr('rel');
		$('input[name=type]').val(type);
		if (type==1) {
			auto(insContainer, changed);
		} else {
			//img(insContainer);
		};
	});

	
	selIns.click(function(e){
	    e.preventDefault();
	    var driect = $(this).attr('rel');
	    var cla = driect + '_selected';
	    //调整样式
	    $(this).parents('.panel-body').find('.sel_style').html('');
	    $(this).parent().find('.sel_style').html('(<i class="red fa fa-check fa-2"></i>)');

	    //选择标识
	    $(this).closest('.' + driect + '_images').find('img').removeClass(cla);
	    $(this).addClass(cla);
	    
	    searchCaseId();
	    getImage(cla);
        getPrice(driect);

	});


    $('.paint', insContainer).change(function(){
        getPrice('front');
        getPrice('back');
        if ($(this).val() == 4) {
            $('.label_kezi').hide();
        } else {
            $('.label_kezi').show();
        };
	});

    $('.front-edit-save', insContainer).click(function(){
    	getImage('front_selected');
	    getPrice('front');
	    $('#ins_front').modal('hide');
    });

    $('.back-edit-save', insContainer).click(function(){
    	getImage('back_selected');
	    getPrice('back');
	    $('#ins_back').modal('hide');
    });

    $('#selectback', insContainer).change(function(){
        var str = $(this).val();
        var arr = str.split(',');
        $('.back-line .main-line').remove();
        for(k in arr){
            var tr = $('#backclone tr').clone();
            tr.find('input').val(arr[k]);
            if (k==0) {
            	tr.find('button.del-line').hide();
            } else {
            	tr.find('button.add-line').hide();
            };
            $('.back-line').append(tr);
        }
        getImage('back_selected');
        getPrice('back');
    });

    $('#font_style', insContainer).change(function(){
    	getImage('front_selected');
        getPrice('front');
    	getImage('back_selected');
        getPrice('back');
    });
	
	// 简繁体切换
	$('#is_tc', insContainer).change(function() {
		getImage('front_selected');
		getImage('back_selected');
		getPrice('front');
		getPrice('back');
	});

	$('#insprocess-paint').change(function(){
		getPrice('front');
		getPrice('back');
	});

	$('body').on('click','.add-line',function(){
		var obj = $(this).parents('tr');
		var line_obj = obj.clone();
		line_obj.find('button').removeClass('add-line').addClass('del-line').html('删 除');
		line_obj.find('input').val('');
		$('.back-line').append(line_obj);
	});
	$('body').on('click','.del-line',function(){
		$(this).parents('tr').remove();
	})

	// 表单验证规则
    var validSetting = {
        rules : {
            'ins[dt_pre_finished]' : { required : true}
        },
        messages : {
            'ins[dt_pre_finished]' : { required: '刻碑日期必填'}
        }
    };
    //insForm.validate(validSetting);  

	insSaveBtn.click(function(e){
        e.preventDefault();
        if (insForm.valid()) {
            if($('.dt_pre_finished').val()<"{:date('Y-m-d')}"){
                alert('刻碑日期不可小于今天');
                return ;
            }

        	insSaveBtn.button('loading');
	        insForm.ajaxSubmit({
	        	dataType : 'json',
	        	success  : function(xhr, statusText, form) {
	                if (!xhr.status) {
	                   alert(xhr.info); 
	                } else {
                        alert('保存成功');
                        location.reload();
                    }

	                insSaveBtn.button('reset');
	            }
	        });
        };
        
    });

    $('input[name="ins[dt_pre_finished]"]').change(function(){
        var ur = "{$urgent}";
        if (ur == 1) return false;
    	urgent();
    });

    $(".image").click(function(e) {
    	 e.preventDefault();
         var title = $(this).attr('title');
         $(".artimg").colorbox({
             rel: 'artimg',
             maxWidth:'600px',
             maxHeight:'700px',
             next:'',
             previous:'',
             close:'',
             current:""
         });
     });

    $('#letter_num').change(function(){
       // getChangePrice();
    });

    $('#big_new, #small_new').change(function(){
    	reCal();
    });
})

function uploadSuc(file, serverData) {
		var progress = new FileProgress(file,  this.customSettings.upload_target);
        serverData = eval('('+serverData+')');
		if (serverData.status === 200) {
            var id = serverData.data.container_id;
            $('#'+id+' img').attr('src',serverData.data.path);
            $('#'+id+' input').val(serverData.data.id);
			progress.setStatus("Thumbnail Created.");
			progress.toggleCancel(false);
        }
}
	

function getImage(cla){
	var case_id = $('.'+cla).attr('case_id');
    var driect = $('.'+cla).attr('rel');
    var tomb_id = $('input[name=tomb_id]').val();
    var data = $('#auto-ins-form').serialize();
    var url = "<?=Url::toRoute(['/grave/home/process/sel', 'tomb_id'=>$get['tomb_id']])?>";

    if (url.indexOf('?') >= 0) {
    	url += '&case_id=' + case_id;
    } else {
    	url += '?case_id=' + case_id;
    }
    if(isNaN(case_id)) return ;
    $.post(url, data, function(xhr){
        if(xhr.status){
        	var time = new Date().getTime();
            $('.' + driect + '_img').attr('src', xhr.data+'?time='+time)
                    				.parent('a')
                    				.attr('href', xhr.data+'?time='+time)
                    				.find('input[name='+driect+'_img]')
                    				.val(xhr.data + '?time=' + time);
        } else {
            
        }
    },'json');
}

//取价格
function getPrice($type){

    if ($type=='back') {
        var case_id = $('.back_selected').attr('case_id');
    } else if ($type=='front') {
        var case_id = $('.front_selected').attr('case_id');
    } else {
    	var case_id = $('.cover_selected').attr('case_id');
    }
    var url = "<?=Url::toRoute(['/grave/home/process/price', 'tomb_id'=>$get['tomb_id']])?>";
    var data = $('#auto-ins-form').serialize();
    var date = +new Date();
	

	var cache = $('.cache');

    $.post(
    	url + '?timstr=' + date + '&case_id='+case_id,
        data,
        function(json) {
            if(json.status) {
                var data = json.data;

                if (data.is_front == 1){

                	$('.front_big_count').html(data.big);
                	$('.front_small_count').html(data.small);
                	$('.front_letter_price').html(data.letter_big_price + data.letter_small_price);
                	$('.front_paint_price').html(data.paint_big_price + data.paint_small_price);
                    $('#tc_price').val(data.tc_fee);

                    cache.data('front_letter_count', (data.big + data.small));
                    cache.data('front_letter_price', (data.letter_big_price + data.letter_small_price));
                    cache.data('tc_price', (data.paint_big_price + data.paint_small_price));
                    cache.data('front_big_new', data.big);
                    cache.data('front_small_new', data.small);

                    cache.data('per.big_letter', data.per.big_letter);
                    cache.data('per.small_letter', data.per.small_letter);
                    cache.data('per.big_paint', data.per.big_paint);
                    cache.data('per.small_paint', data.per.small_paint);
                    
                } else if(data.is_front == 0){
                	
                	$('.back_big_count').html(data.big);
                	$('.back_small_count').html(data.small);
                	$('.back_letter_price').html(data.letter_big_price + data.letter_small_price);
                	$('.back_paint_price').html(data.paint_big_price + data.paint_small_price);

                	cache.data('back_letter_count', (data.big + data.small));
                    cache.data('back_letter_price', (data.letter_big_price+ data.letter_small_price));
                    cache.data('back_paint_price', (data.paint_big_price + data.paint_small_price));
                    cache.data('back_big_new', data.big);
                    cache.data('back_small_new', data.small);

                }

                calPrice()//服务计算
            }
            
        },'json');
}


function calPrice()
{
	var cache = $('.cache');

	var front_letter_count = cache.data('front_letter_count') || 0;
	var back_letter_count = cache.data('back_letter_count') || 0;

	var front_letter_price = cache.data('front_letter_price') || 0;
	var front_paint_price = cache.data('front_paint_price') || 0;

	var back_letter_price = cache.data('back_letter_price') || 0;
	var back_paint_price = cache.data('back_paint_price') || 0;

	var front_big_count = cache.data('front_big_new') || 0;
	var back_big_count = cache.data('back_big_new') || 0;

	var front_small_count = cache.data('front_small_new') || 0;
	var back_small_count = cache.data('back_small_new') || 0;


	//$('#letter_num').val(front_letter_count + back_letter_count);
	$('#letter_price').val(front_letter_price + back_letter_price);
	$('#paint_price').val(front_paint_price + back_paint_price);
	$('#big_new').val(front_big_count + back_big_count);
	$('#small_new').val(front_small_count + back_small_count);

}

function reCal()
{

	var cache = $('.cache');
	var big_letter = cache.data('per.big_letter');
    var small_letter = cache.data('per.small_letter');
    var big_paint = cache.data('per.big_paint');
    var small_paint = cache.data('per.small_paint');


    var big_num = $('#big_new').val() || 0;
    var small_num = $('#small_new').val() || 0;


    //var front_big_count = cache.data('front_big_new') || 0;
	//var back_big_count = cache.data('back_big_new') || 0;

	//var front_small_count = cache.data('front_small_new') || 0;
	//var back_small_count = cache.data('back_small_new') || 0;

	$('#big_new').val(front_big_count + back_big_count);
	$('#small_new').val(front_small_count + back_small_count);

    $paint = (parseInt(big_num) * big_paint) + (parseInt(small_num) * small_paint);
    $letter = (parseInt(big_num) * big_letter) + (parseInt(small_num) * small_letter);

    $('#letter_price').val($letter);
	$('#paint_price').val($paint);

}

function searchCaseId(){
	$('input[name=front_case]').val($('.front_selected').attr('case_id'));
	$('input[name=back_case]').val($('.back_selected').attr('case_id'));
	$('input[name=cover_case]').val($('.cover_selected').attr('case_id'));
}

function urgent(){
    var curVal = new Date($('input[name="ins[dt_pre_finished]"]').val());
    var curTime = Date.parse(curVal);
    var dt_tmp = new Date();
    var dt = new Date(dt_tmp.getTime()+60*60*24*3*1000);
    var dt_str = dt.toLocaleDateString();
    var is_second = $('.is_second').val();
    if(is_second) return ;
    if (curTime < dt_tmp.getTime()+60*60*24*2*1000) {
        $('.remind').html(dt_str);
        $('.mnMsg').show();
    } else {
        $('.mnMsg').hide();
    }
}

function auto(insContainer, changed){
		
		searchCaseId();

		if (changed == 1) {
			getImage('front_selected');
			getImage('back_selected');
			getImage('cover_selected');
		} else {
			//如果没有图片，就取新图片
		    if ($('.front_img', insContainer).attr('src') == '#'){
		        getImage('front_selected');
		    }
		    if ($('.back_img', insContainer).attr('src') == '#'){
		        getImage('back_selected');
		    }
		    if ($('.cover_img', insContainer).attr('src') == '#'){
		        getImage('cover_selected');
		    }
		}

		//如果还没取价格，则新取
		if ($('#front_prices', insContainer).attr('flag') != 1){
			getPrice('front');
		}
		if ($('#back_prices', insContainer).attr('flag') != 1){
	        getPrice('back');
	    }
	    if ($('#cover_prices', insContainer).attr('flag') != 1){
	        getPrice('cover');
	    }
}



function getChangePrice()
{
    var font_num = $('#letter_num').val();
    var paint = $('.paint').val();
    var tomb_id = "{$tomb_id}";
    var url = '/ins/fontprice';
//    if(paint==4) return ;
    if(font_num == 0) {
        return $('#letter_price').val(0);
    }

    $.get(url, {font_num:font_num, paint:paint, tomb_id:tomb_id}, function(xhr){
        if(xhr.status) {
            $('#letter_price').val(xhr.data.price);
        } else {
            alert(xhr.info);
        }
    }, 'json');
}

function upinit() {
    $('.filePicker').each(function(i){
        var imgNum = $(this).attr('num');
        imgNum = imgNum ? imgNum : 'false';
        var that = this;
        var index = parseInt(i) +1;
        var uploader = [];
        btn = $(this).attr('id');
        var use = $(this).attr('use');
        var bt;
        $(this).removeClass('filePicker'); //去除 此class 防止再次each时，多次循还

        uploader[index] = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : btn, // you can pass an id...
            url : '<?=Url::toRoute(["pl-upload"])?>',
            flash_swf_url : '/static/libs/plupload-2.1.9/js/Moxie.swf',
            silverlight_xap_url : '/static/libs/plupload-2.1.9/js//Moxie.xap',
            file_data_name:'file',
            multi_selection: eval(imgNum),
            filters : {
                max_file_size : '10mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ],
                prevent_duplicates: true//不允许选择重复文件
            },
            multipart_params:{
                res_name : 'ins',
                'use' : use
            },

            init: {
                PostInit: function() {},
                FilesAdded: function(up, files) {



                bt = $('#myButton').button('loading');


                    if (files.length > imgNum) {
                        alert('最多只能上传'+imgNum+'张图片哦');
                        uploader[index].splice(imgNum, files.length-imgNum);
                    } 

                    plupload.each(files, function(file, i) {
                        if (!file || !/image\//.test(file.type)) return; //确保文件是图片
                            if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                                var fr = new mOxie.FileReader();
                                fr.onload = function () {
                                    if (imgNum > 1) {
                                        $('.filelist-patch').find('img').eq(i).attr('src', fr.result);
                                    }
                                    $(that).find('img').eq(i).attr('src', fr.result);
                                    fr.destroy();
                                    fr = null;
                                }
                                fr.readAsDataURL(file.getSource());
                            } else {
                                var preloader = new mOxie.Image();
                                preloader.onload = function () {
                                    preloader.downsize(404, 486);//先压缩一下要预览的图片,宽300，高300
                                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                                    if (imgNum > 1) {
                                        $('.filelist-patch').find('img').eq(i).attr('src', imgsrc);
                                    } else {
                                        $(that).find('img').eq(i).attr('src', imgsrc);
                                    }
                                    
                                    preloader.destroy();
                                    preloader = null;
                                };
                                preloader.load(file.getSource());
                            }
                       
                    });

                    uploader[index].start();
                },

                UploadProgress: function(up, file) {
                    //document.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                },

                FileUploaded: function(up, file, info) {
                    res = $.parseJSON(info.response);

                    if (imgNum > 1) {
                        var files = uploader[index].files;
                        i = 0;
                        for ( f in files) {
                            if (files[f] == file) {
                                i = f;
                            }
                        }

                        $(".filelist-patch").find('input').eq(i).val(res.mid);
                    } else {

                        $(that).find('input').val(res.mid);
                    }
                },
                UploadComplete:function(up,file){
                    bt.button('reset')
                },

                Error: function(up, err) {
                    //document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                }
             }//init
        });//uploader

        uploader[index].init();
    });//each
}


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 



