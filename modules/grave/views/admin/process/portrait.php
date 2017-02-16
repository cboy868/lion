<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;

use app\assets\ExtAsset;
ExtAsset::register($this);
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        

         <div class="col-xs-12">
            <?php if (Yii::$app->session->has('success')): ?>
                <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>恭喜!</strong> <?=Yii::$app->session->getFlash('success')?>
                </div>
            <?php endif ?>

            <?php if (Yii::$app->session->has('error')): ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>提示!</strong> <?=Yii::$app->session->getFlash('error')?>
                </div>
            <?php endif ?>
        </div>
        
        <?php 
            $form = ActiveForm::begin();
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-2';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'; 
        ?>
        <div class="row">
            
                <div class="col-xs-12 address-index">
                    <div class="panel panel-info">
                        <div class="dHandler panel-heading">瓷像信息
                            <button type="button" class="delit close" style="display:none;">
                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                               <span class="sr-only">Close</span>
                            </button> 
                        </div>
                        <div class="row">
                            
                        
                        <?php foreach ($models as $index => $model): ?>
                            <div class=" col-md-6">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    <p>
                                      瓷像名: 单人瓷像111
                                      瓷像属性: 120cmx120cm
                                      价格:120
                                    </p>
                                    <div class="row">
                                        <div class="col-md-4">
                                          <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                          <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                        <div class="col-md-8">
                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/static/images/up.png">
                                                <div> 原始照片 </div>
                                            </div>

                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                                <div> ps照片 </div>
                                            </div>

                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/static/images/up.png">
                                                <div> 确认照片 </div>
                                            </div>
                                            <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12">
                                            <?= $form->field($model, "[$index]use_at")->textInput(['style'=>'width:150px;', 'dt'=>'true']) ?>
                                            <?= $form->field($model, "[$index]note")->textArea() ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    <p>
                                      瓷像名: 单人瓷像111
                                      瓷像属性: 120cmx120cm
                                      价格:120
                                    </p>
                                    <div class="row">
                                        <div class="col-md-4">
                                          <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                          <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                        <div class="col-md-8">
                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                                <div> 原始照片 </div>
                                            </div>

                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                                <div> ps照片 </div>
                                            </div>

                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="max-height: 100px;max-width: 100px;" src="/upload/image/20170216/1487224575399.jpeg">
                                                <div> 确认照片 </div>
                                            </div>
                                            
                                            <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12">
                                            <?= $form->field($model, "[$index]use_at")->textInput(['style'=>'width:150px;', 'dt'=>'true']) ?>
                                            <?= $form->field($model, "[$index]note")->textArea() ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        </div>

                        <div class="hr hr-18 dotted hr-double"></div>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            
        </div><!-- /.row -->
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>









	


	

				

