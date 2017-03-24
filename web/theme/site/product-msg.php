<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;

use app\assets\ExtAsset;
ExtAsset::register($this);


$this->title = $goods->name . '留言';

?>
<style type="text/css">
    .form-group {
    margin-bottom: 0;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
     padding: 1px; 
    line-height: 1.42857143;
    vertical-align: top;
     border-top: none; 
}
</style>

<div class="main-container col1-layout home-content-container">
<ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
  <li><a href="<?=url(['/'])?>">HOME</a></li>
  <li class="active">PRODUCT MESSAGE</li>
</ol>
<div class="main home-content">
    <div class="row columns-layout nova-mg-pd">


    <div class="message-form">

                    <?php $form = ActiveForm::begin(); ?>
                    <?php 

                         $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
                         $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'; 
                     ?>
                     <?= $form->field($model, 'goods_id')->hiddenInput()->label(false) ?>
                    <table class="table">
                        <tr>
                            <td colspan="2">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Subject<font color="red">(*)</font>') ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group field-message-title">
                                    <label class="control-label col-sm-1" for="message-title"></label>
                                    <div class="col-sm-10">
                                    <?php 
                                        echo Html::dropDownList('a', null, $shortmsg, ['prompt'=>'Please select the problem', 'onchange'=>"if(this.value)$('.intro').val($('.intro').val() + this.value+'\\n');"]);
                                     ?>
                                        (shortcut)
                                    </div>
                                </div>

                                <?= $form->field($model, 'intro')->textarea(['rows' => 6, 'class'=>'intro form-control'])->label('Content') ?>
                            </td>
                        </tr>

                        <?php 

                             $form->fieldConfig['labelOptions']['class']='control-label col-sm-2';
                             $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>'; 
                         ?>
                        <tr>
                            <td width="50%"><?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Name<font color="red">(*)</font>') ?></td>
                            <td><?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label('Tel') ?></td>
                            
                        </tr>
                        <tr>
                            <td>
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email<font color="red">(*)</font>') ?>
                            </td>
                            <td width="">
                                <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="">
                            <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>
                            </td>
                            
                            <td>
                                <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>

                        <tr>
                            <td>

                                <?php $a = Captcha::widget(['name'=>'captchaimg','captchaAction'=>'/member/default/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'Refresh', 'alt'=>'Refresh', 'style'=>'cursor:pointer;'],'template'=>'{image}']); 
                                $form->fieldConfig['template'] = '{label}<div class="col-sm-6">{input}{hint}{error}</div><div class="col-sm-2">'.$a.'</div>'; 
                                ?>

                                <?= $form->field($model, 'verifyCode')->textInput()->label('Verification Code') ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>

                    </table>


                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-3">
                            <?=  Html::submitButton('Save', ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>

                </div>




        </div>
    </div>
</div>