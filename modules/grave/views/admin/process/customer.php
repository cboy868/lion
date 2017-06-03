<?php
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
// use app\assets\JqueryuiAsset;
use app\core\widgets\Area\Select;

// JqueryuiAsset::register($this);

\app\assets\ExtAsset::register($this);


$this->title="购墓流程"
?>

<style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        border:none;
    }
    .olduser{
        list-style: none;
        color: #666;

        moz-user-select: -moz-none;
        -moz-user-select: none;
        -o-user-select:none;
        -khtml-user-select:none;
        -webkit-user-select:none;
        -ms-user-select:none;
        user-select:none;
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
                          // $agent_disabled = $tomb->agent_id ? true : false;
                          // $guide_disabled = $tomb->guide_id ? true : false;
                          // $uname_disabled = $user->id ? true : false;
                          // $customer_disabled = $model->id ? true : false;
                         ?>
                        <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-8 ui-widget">{input}{hint}{error}</div>'; ?>
                            <td><?= $form->field($tomb, 'agent_id')->dropDownList($agent,['class'=>'sel-ize'])->label('***(<font color="red">*</font>)') ?></td>
                            <td><?= $form->field($tomb, 'guide_id')->dropDownList($guide,['class'=>'sel-ize'])->label("导购员(<font color='red'>*</font>)") ?></td>
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
                                ],'class'=>'uname form-control'
                            ])->label("账号(<font color='red'>*</font>)")
                              ->hint('账号不可与系统中已有账号重复，如重复，请修改账号名')?></td>
                            <td></td>
                        </tr>
                        <tr style="display:none;">
                            <td>
                                <div class="form-group field-user-username required">
                                    <label class="control-label col-sm-2">已存在的账号</label>
                                    <ul class="col-sm-8 olduser">

                                    </ul>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <?= $form->field($user, 'id')->hiddenInput(['class'=>'uid form-control'])->label(false)?>
                        <?= $form->field($model, 'id')->hiddenInput(['class'=>'cid form-control'])->label(false)?>
                        <tr>
                            <td><?= $form->field($model, 'name')->textInput(['class'=>'cname form-control'])->label("客户名(<font color='red'>*</font>)") ?></td>
                            <td><?= $form->field($model, 'mobile')->textInput(['class'=>'cmobile form-control','maxlength' => true])->label("手机号(<font color='red'>*</font>)") ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field($model, 'email')->textInput(['class'=>'cemail form-control','maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'phone')->textInput(['class'=>'cphone form-control','maxlength' => true]) ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $form->field($model, 'second_ct')->textInput(['class'=>'csecond_ct form-control','maxlength' => true]) ?></td>
                            <td><?= $form->field($model, 'second_mobile')->textInput(['class'=>'csecond_mobile form-control','maxlength' => true]) ?></td>
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
                                <?= $form->field($model, 'addr')->textArea(['class'=>'caddr form-control','maxlength' => true, 'placeholder'=>'详细地址']) ?>
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
    var csrf = "<?=Yii::$app->getRequest()->getCsrfToken()?>";
    var user = [];

    $('.uname').blur(function(){
        var uname = $(this).val();
        //查看有无重复用户
        var url="<?=Url::toRoute(['/grave/admin/customer/user-info-by-name'])?>";
        $.post(url,{_csrf:csrf,uname:uname},function(xhr){

            if (xhr.status) {
                user = xhr.data.user;
                var u = xhr.data.user;
                var selHtml = '';
                for (i in u.customers){
                    var c = u.customers[i];
                    selHtml += '<li><label>' +
                            '<input type="radio" name="oldname" class="sel-customer" rid="'+c.id+'"> '+
                            u.username+' ('+u.mobile+')' +
                            c.name+' ('+c.mobile+')' +
                            '</label></li>';

                }
                $('.olduser').html(selHtml);
                $('.olduser').closest('tr').show();
            } else {
                $('.olduser').html('');
                $('.olduser').closest('tr').hide();
            }
            empty();

            //同步客户名称
            if (!$('.cname').val()) {
                $('.cname').val(uname);
            }
        },'json');

    });

    $('body').on('click', '.sel-customer',function(){
        var uid = user.id;
        var cid = $(this).attr('rid');
        var cname = user.customers[cid].name;
        var cmobile = user.customers[cid].mobile;

        $('.uid').val(uid);
        $('.cid').val(cid);
        //$('.uname').val(user.username);
        $('.cname').val(cname);
        $('.cmobile').val(cmobile);
        $('.cemail').val(user.customers[cid].email);
        $('.cphone').val(user.customers[cid].phone);
        $('.csecond_ct').val(user.customers[cid].second_ct);
        $('.csecond_mobile').val(user.customers[cid].second_mobile);
        $('.caddr').val(user.customers[cid].addr);
        $('.area_province').val(user.customers[cid].province);
        $('.area_province').trigger('change');
        $('.area_city').val(user.customers[cid].city);
        $('.area_city').trigger('change');
        $('.area_zone').val(user.customers[cid].zone);
    });

function empty(){
    $('.uid').val('');
    $('.cid').val('');
    //$('.uname').val('');
    $('.cname').val('');
    $('.cmobile').val('');
    $('.cemail').val('');
    $('.cphone').val('');
    $('.csecond_ct').val('');
    $('.csecond_mobile').val('');
    $('.caddr').val('');
    $('.area_province').val('');
    $('.area_province').trigger('change');
    $('.area_city').val('');
    $('.area_city').trigger('change');
    $('.area_zone').val('');
}


})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['customer'], \yii\web\View::POS_END); ?>



