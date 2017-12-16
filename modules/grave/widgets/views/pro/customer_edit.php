<?php
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;

use app\modules\agency\models\Agency;
use app\core\widgets\Area\Select;

\app\assets\ExtAsset::register($this);
\app\assets\VueAsset::register($this);

$this->title="购墓流程"
?>
    <!--客户信息-->
<div class="widget-box transparent ui-sortable-handle">
    <div class="widget-header">
        <h4 class="widget-title lighter">2、办理人信息</h4>

        <div class="widget-toolbar no-border">

            <a href="#collapseCustomer"
               data-toggle="collapse"
               aria-expanded="false"
               aria-controls="collapseCustomer">
                <i class="ace-icon fa fa-chevron-down"></i>
                编辑
            </a>

        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main padding-6 no-padding-left no-padding-right">
            <p>
                办事员:沈河 李小丰，导购员:小张三
            </p>
            <p>
                客户：李四先生(18588887777)
            </p>
        </div>

        <div class="collapse" id="collapseCustomer">
            <div class="well">
                <div class="customer-form" style="width:90%;margin:auto;">

                    <?php $form = ActiveForm::begin([
                        'id' => 'cu-form',
                        'action' => Url::toRoute(['/grave/admin/pro/customer', 'tomb_id'=>$tomb->id])
                    ]); ?>

                    <?php //echo $form->field($tomb, 'tomb_no')->hiddenInput()->label(false) ?>
                    <?php
                    $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                    ?>

                    <table class="table table-condensed noborder">
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
                            <?=  Html::submitButton('保 存', [
                                'class' => 'btn btn-warning btn-lg saveCustomer',
                                'style'=>'padding: 10px 36px',
                                'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> 保存中，请稍后"
                            ]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->beginBlock('customer') ?>

$(function(){
    jQuery('form#cu-form').on('beforeSubmit', function (e) {
        var $form = $(this);
        var btn = $(this).find('.saveCustomer').button('loading');

        $.post($form.attr('action'),$form.serialize(),function(xhr){
            if (xhr.status) {
                btn.button('reset');
            }
        },'json');

        return false;
    })
    $('.uname').blur(function(){
        if (!$('.cname').val()) {
            $('.cname').val($(this).val());
        }
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>