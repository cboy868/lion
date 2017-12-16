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
               aria-expanded="true"
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

        <div class="collapse in" id="collapseCustomer" >
            <div class="well">
                <div class="customer-form" style="width:90%;margin:auto;">

                    <?php $form = ActiveForm::begin([
                        'id' => 'cu-form',
                        'action' => Url::toRoute(['/grave/admin/pro/customer', 'tomb_id'=>$tomb->id])
                    ]); ?>

                    <?php
                    $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>';
                    ?>

                    <table class="table table-condensed noborder" id="userSel">
                        <tr>
                            <?php
                            // $agent_disabled = $tomb->agent_id ? true : false;
                            // $guide_disabled = $tomb->guide_id ? true : false;
                            // $uname_disabled = $user->id ? true : false;
                            // $customer_disabled = $model->id ? true : false;
                            ?>
                            <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-8 ui-widget">{input}{hint}{error}</div>'; ?>
                            <td><?= $form->field($tomb, 'agency_id')
                                    ->dropDownList(Agency::sel(),['class'=>'sel-ize', 'prompt'=>'请选择办事处'])
                                    ->label('办事处(<font color="red">*</font>)')
                                    ->hint('请选择办事处，不选择，则为市场部')
                                ?>
                            </td>
                            <td><?= $form->field($tomb, 'agent_id')
                                    ->dropDownList($agent,['class'=>'sel-ize', 'prompt'=>'请选择'])
                                    ->label('***(<font color="red">*</font>)') ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field($tomb, 'guide_id')->dropDownList($guide,['class'=>'sel-ize'])
                                    ->label("导购员(<font color='red'>*</font>)") ?></td>
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
                            <td><?= $form->field($user, 'username')->textInput(['enableAjaxValidation'=>true,
                                    'clientOptions' => [
                                        'validateOnSubmit' => true,
                                        'validateOnBlur' => true,
                                        'validateOnType' => true,
                                    ], 'class'=>'uname form-control',
                                    '@change'=>'checkUser',
                                    'v-model'=>"params.uname"
                                ])->label("账号(<font color='red'>*</font>)")
                                    ->hint('账号不可与系统中已有账号重复，如重复，请修改账号名')?></td>
                            <td>
                                <?= $form->field($user, 'id')->hiddenInput(['class'=>'uid form-control','v-model'=>"current.uid"])->label(false)?>
                                <?= $form->field($model, 'id')->hiddenInput(['class'=>'cid form-control','v-model'=>"current.cid"])->label(false)?>
                            </td>
                        </tr>
                        <tr style="" >
                            <td colspan="2">

                                <div class="form-group field-user-username required has-success" v-show="user.id">
                                    <label class="control-label col-sm-1">已存在的账号</label>
                                    <div class="col-sm-11">
                                        <p class="alert-danger">
                                            系统已存在此账号，请检查是否正确，正确请勾选以下选项，否则请修改账号
                                        </p>
                                        <p>
                                            勾选新增联系人，则为此账号增加新的联系人
                                        </p>

                                        <ul class="oldUser">

                                            <li>
                                                <span>
                                                    <label>
                                                        <span v-text="user.username"></span>
                                                        (<span v-text="user.mobile"></span>)
                                                    </label>
                                                </span>
                                                <ul>
                                                    <span><label><input type="radio" name="customer" class="sel-customer" @change="selCustomer(0)"> 新增联系人</label></span>
                                                    <span v-for="c in user.customers">
                                                        <label>
                                                            <input type="radio" name="customer" class="sel-customer" @change="selCustomer(c.id)">
                                                            <span v-text="c.name"></span> (<span v-text="c.mobile"></span>)
                                                        </label>
                                                    </span>
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td><?= $form->field($model, 'name')->textInput(['class'=>'cname form-control','v-model'=>'current.customer.name'])
                                    ->label("客户名(<font color='red'>*</font>)") ?></td>
                            <td><?= $form->field($model, 'mobile')
                                    ->textInput(['class'=>'cmobile form-control','maxlength' => true,'v-model'=>'current.customer.mobile'])
                                    ->label("手机号(<font color='red'>*</font>)") ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field($model, 'email')
                                    ->textInput(['class'=>'cemail form-control','maxlength' => true,'v-model'=>'current.customer.email']) ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'phone')
                                    ->textInput(['class'=>'cphone form-control','maxlength' => true,'v-model'=>'current.customer.phone']) ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'second_ct')
                                    ->textInput(['class'=>'csecond_ct form-control','maxlength' => true,'v-model'=>'current.customer.second_ct']) ?></td>
                            <td><?= $form->field($model, 'second_mobile')
                                    ->textInput(['class'=>'csecond_mobile form-control','maxlength' => true,'v-model'=>'current.customer.second_mobile']) ?></td>
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
                                            'zone'=>$model->zone
                                        ]);?>
                                    </div>
                                </div>
                                <?php $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
                                $form->fieldConfig['template']='{label}<div class="col-sm-10">{input}{hint}{error}</div>';
                                ?>
                                <?= $form->field($model, 'addr')
                                    ->textArea(['class'=>'caddr form-control','maxlength' => true, 'placeholder'=>'详细地址','v-model'=>'current.customer.addr']) ?>
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
})



var v = new Vue({
    el : '#userSel',
    data:{
        user:{},
        current:{uid:0,customer:{},cid:0},
        params:{uname:''},
        checkUrl:"<?=Url::toRoute(['/grave/admin/customer/user-info-by-name'])?>"
    },
    methods: {

        checkUser(){

            this.$http.get(this.checkUrl,{params:this.params}).then(function (response) {
                if (response.body.status) {
                    this.$set(this, 'user', response.body.data.user);
                } else {
                    this.$set(this, 'user', {});
                    this.$set(this.current, 'uid', 0);
                    this.$set(this.current, 'cid', 0);
                    this.$set(this.current, 'customer', {});
                }

            }).catch(function () {

            });

        },
        selCustomer(customer_id){

            this.$set(this.current, 'uid', this.user.id);
            this.$set(this.current, 'cid', customer_id);

            if (customer_id == 0) {
                this.$set(this.current, 'customer', {});
                $('.area_province').val(0);
                $('.area_city').val(0);
                $('.area_zone').val(0);
            } else {
                this.$set(this.current, 'customer', this.user.customers[customer_id]);
                $('.area_province').val(this.current.customer.province);
                $('.area_province').trigger('change');
                $('.area_city').val(this.current.customer.city);
                $('.area_city').trigger('change');
                $('.area_zone').val(this.current.customer.zone);
            }

        }

    },

});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>

