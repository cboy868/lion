<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
use app\modules\agency\models\Agency;
// use app\assets\JqueryuiAsset;
use app\core\widgets\Area\Select;

// JqueryuiAsset::register($this);

use app\assets\ExtAsset;

ExtAsset::register($this);


$this->title="购墓流程"
?>

<style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        border:none;
    }
  </style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

        <?=\app\core\widgets\Alert::widget();?>
        
        <div class="row">
            <div class="col-xs-12 address-index">
                    <div class="panel panel-info">
                    <div class="dHandler panel-heading">购买人信息 
                        <button type="button" class="delit close" style="display:none;">
                           <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                           <span class="sr-only">Close</span>
                        </button> 
                    </div>
				<div class="customer-form" style="width:90%;margin:auto;">

                    <?php $form = ActiveForm::begin([
                            'id' => 'cu-form',
                        ]); ?>

                    <?php //echo $form->field($tomb, 'tomb_no')->hiddenInput()->label(false) ?>
                    <?php 
                        $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                     ?>

                    <table class="table table-condensed">
                        <tr>
                        <?php
                          $agency_disabled = $tomb->agency_id ? true : false;
                          $agent_disabled = $tomb->agent_id ? true : false;
                          $guide_disabled = $tomb->guide_id ? true : false;
                          $uname_disabled = $user->id ? true : false;
                          $customer_disabled = $model->id ? true : false;
                         ?>
                        <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-8 ui-widget">{input}{hint}{error}</div>'; ?>
                            <td><?= $form->field($tomb, 'agency_id')
                                    ->dropDownList(Agency::sel(),['class'=>'sel-ize','disabled'=>$agency_disabled, 'prompt'=>'请选择办事处'])
                                    ->label('办事处(<font color="red">*</font>)')
                                    ->hint('请选择办事处，不选择，则为市场部')
                                ?>
                            </td>
                            <td><?= $form->field($tomb, 'agent_id')
                                    ->dropDownList($agent,['class'=>'sel-ize','disabled'=>$agent_disabled,'prompt'=>'请选择'])
                                    ->label('***(<font color="red">*</font>)') ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $form->field($tomb, 'guide_id')
                                    ->dropDownList($guide,['class'=>'sel-ize','disabled'=>$guide_disabled])
                                    ->label("导购员(<font color='red'>*</font>)") ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <?php 
                            $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                         ?>
                        <tr>
                            <td><?= $form->field($user, 'username')->textInput(['disabled'=>$uname_disabled, 'enableAjaxValidation'=>true,
                                'clientOptions' => [
                                    'validateOnSubmit' => true,
                                    'validateOnBlur' => true,
                                    'validateOnType' => true,
                                ],'class'=>'uname form-control'
                            ])->label("账号(<font color='red'>*</font>)") ?></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'name')->textInput(['disabled'=>$uname_disabled,'class'=>'cname form-control'])->label("客户名(<font color='red'>*</font>)") ?></td>
                            <td><?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label("手机号(<font color='red'>*</font>)") ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'second_ct')->textInput(['maxlength' => true]) ?></td>
                            <td><?= $form->field($model, 'second_mobile')->textInput(['maxlength' => true]) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2">

                              <div class="form-group">
                                <label class="control-label col-sm-1" for="customer-addr"></label>
                                <div class="col-sm-10">
                                  <?= Select::widget([
                                    'pro_name' => 'Customer[province]',
                                    'city_name' => 'Customer[city]',
                                    'zone_name' => 'Customer[zone]',
                                    'pro'=>$model->province,
                                    'city'=>$model->city,
                                    'zone'=>$model->zone,
                                  ]);?>
                                </div>
                              </div>
                                <?php $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
                                      $form->fieldConfig['template']='{label}<div class="col-sm-10">{input}{hint}{error}</div>';
                                 ?>
                                <?= $form->field($model, 'addr')->textArea(['maxlength' => true, 'placeholder'=>'详细地址']) ?>
                            </td>
                        </tr>
                    </table>

                    <div class="form-group">
                        <div class="col-sm-12" style="text-align:center;">
                            <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                            <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>

                </div>


                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
            </div>
        </div><!-- /.row -->
        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('customer') ?>  

$(function(){
    $('.uname').blur(function(){
        if (!$('.cname').val()) {
            $('.cname').val($(this).val());
        }
    });
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?> 



