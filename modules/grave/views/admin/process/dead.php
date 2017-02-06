<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Dead;
?>

<style type="text/css">
    .help-block{
        margin:0;
    }
</style>

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

                <div class="col-xs-5 address-index">
                    <div class="panel panel-info" style="height:530px;">
                        <div class="dHandler panel-heading">使用人信息 
                            <button type="button" class="delit close" style="display:none;">
                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                               <span class="sr-only">Close</span>
                            </button> 
                        </div>
                        
                        <table class="table table-condensed">
                            <tr>
                                <td><?= $form->field($model, "[$index]dead_name")->textInput(['maxlength' => true]) ?></td>
                            </tr>
                           <!--  <tr>
                                <td><?= $form->field($model, "[$index]second_name")->textInput(['maxlength' => true]) ?></td>
                            </tr> -->
                            <tr>
                                <td><?= $form->field($model, "[$index]dead_title")->dropDownList($dead_title,['style'=>'width:50%']) ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]gender")->radioList([1=>'男', 2=>'女']) ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]birth")->textInput(['style'=>'width:70%']) ?></td>
                            </tr>
                            
                            <tr>
                                <td><?= $form->field($model, "[$index]is_alive")->radioList(Dead::alive())->label('是否健在') ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]fete")->textInput(['style'=>'width:70%']) ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]is_ins")->radioList(Dead::ins())->label('是否立碑') ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]bone_type")->radioList($bone_type) ?></td>
                            </tr>
                            <tr>
                                <td><?= $form->field($model, "[$index]bone_box")->radioList($bone_box) ?></td>
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









	


	

				

