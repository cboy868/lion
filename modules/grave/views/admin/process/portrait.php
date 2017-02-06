<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        
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
            <div class="col-sm-offset-6 col-sm-5" style="text-align:right;">
                <?=  Html::submitButton('上一步', ['class' => 'btn btn-primary btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div><!-- /.page-content-area -->
</div>









	


	

				

