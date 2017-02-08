<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
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
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>'; 
        ?>
        <div class="row">
            

            <?php foreach ($models as $index => $model): ?>
                
            

                <div class="col-xs-12 address-index">
                    <div class="panel panel-info">
                        <div class="dHandler panel-heading">瓷像信息 
                            <button type="button" class="delit close" style="display:none;">
                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                               <span class="sr-only">Close</span>
                            </button> 
                        </div>
                        
                        <table class="table table-condensed">
                            <tr>
                                <td><?= $form->field($model, "[$index]goods_id")->textInput(['maxlength' => true]) ?></td>
                            </tr>
                        </table>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            <?php endforeach ?>
        </div><!-- /.row -->
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div><!-- /.page-content-area -->
</div>









	


	

				

