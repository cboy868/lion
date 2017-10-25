<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\assets\ExtAsset;
use app\modules\grave\models\CarRecord;

ExtAsset::register($this);

use app\assets\DateTimeAsset;

DateTimeAsset::register($this);

$tomb_id = Yii::$app->getRequest()->get('tomb_id');
?>
<style type="text/css">
  .fm.table>tbody>tr>td, .fm.table>tbody>tr>th, .fm.table>tfoot>tr>td, .fm.table>tfoot>tr>th, .fm.table>thead>tr>td, .fm.table>thead>tr>th {
    line-height: 1.2;
    border-top: none;
    padding:0;
}
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

          <?php if (!empty($unpre)): ?>

            <?php 
                $form = ActiveForm::begin();
                $form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
                $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>'; 
            ?>
          <div class="row">
            <div class="col-xs-12">
              
              <div class="panel panel-info">
                  <div class="dHandler panel-heading">定安葬
                    <small class="pull-right">


                   <?php 
                   $liyi = $this->context->module->params['goods']['cate']['liyi'];
                   ?>

                      <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$liyi, 'tomb_id'=>$tomb_id])?>" class="modalAddButton btn btn-warning" data-loading-text="页面加载中, 请稍后..." onclick="return false">购买礼仪</a>
                    </small>
                  </div>
                  
                  <!-- <form id="bury-form" method="post" action="/admin/process/bury_save" class="form-horizontal" role="form"> -->

                    <h4 class="text-warning"><i class="fa fa-star"></i> 待安葬</h4>
                    <div class="well" style="overflow:hidden">
                      <div class="row">
                          <div class="col-sm-4 text-left">
                              <?php

                              $unp = [];

                              foreach ($unpre as $k => $dead) {
                                $unp[$dead->id] = $dead->dead_name;
                              }
                              ?>
                              <?= $form->field($model, "dead_id")->checkBoxList($unp)->label(false) ?>

                              <?= $form->field($nRecord, "car_type")->radioList($car_type, ['class'=>'cartype'])->label(false) ?>
                          </div>
                          <div class="col-sm-5">
                              <?= $form->field($model, "pre_bury_date")->textInput(['id'=>'dt', 'class'=>'pre_bury_date form-control'])->label('预安葬日期') ?>
                              <?= $form->field($nRecord, "addr_id")->dropDownList($car_addr, ['prompt'=>'请选择接盒地址','class'=>'addrs form-control']) ?>
                            </div>
                          </div>
                            <p class="alert alert-danger msg" style="display: none;">重要提示 <span></span></p>
                      </div>
                    

                      <div class="row" id="bury-car-contacts" style="display:none;">
                         <div class="col-sm-12">
                             <h4 class="text-warning"><i class="fa fa-star"></i> 用车联系人信息</h4>
                             <div class="well">
                              <table class="table table-noborder fm">
                                <tr>
                                  <td>
                                    <?= $form->field($nRecord, "contact_user")->textInput(['value'=>$customer->name]) ?>
                                  </td>
                                  <td>
                                    <?= $form->field($nRecord, "contact_mobile")->textInput(['value'=>$customer->mobile]) ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <?= $form->field($nRecord, "is_cremation")->radioList(['否','是']) ?>
                                  </td>
                                  <td>
                                    <?= $form->field($nRecord, "is_back")->radioList(['否','是']) ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <?= $form->field($nRecord, "addr")->textArea(['rows'=>5]) ?>
                                  </td>
                                  <td>
                                    <?= $form->field($nRecord, "note")->textArea(['rows'=>5]) ?>
                                  </td>
                                </tr>
                              </table>
                             </div>
                         </div>  
                      </div>
                  
                  <div class="hr hr-18 dotted hr-double"></div>
              </div>
              <div class="hr hr-18 dotted hr-double"></div>

          </div>
        </div><!-- /.row -->

        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

      <?php else: ?>
            <div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
              暂无安葬业务
            </div>
      <?php endif ?>

        <?php if ($pres):?>
          <?php foreach ($pres as $index => $pre): ?>
              <div class="panel panel-info">
                 <div class="panel-heading"> 
                     预葬记录          </div>
                <table class="table table-bordered table-condensed">
                  <tbody><tr>
                     <th width="100">逝者姓名：</th>
                     <td width="150" class="text-info"><?=$pre->dead_name?></td>
                     <th width="100">预葬日期：</th>
                     <td class="text-info"><?=$pre->pre_bury_date?></td>
                  </tr>

                  <?php if (isset($records[$pre->id])): ?>
                  <tr>
                      <th width="100">车辆类型：</th>
                      <?php
                      p($records[$pre->id]);
                      p($records[$pre->id]['car_type']);
                      die;
                      ?>
                      <td width="150" class="text-info"><?=CarRecord::carType($records[$pre->id]['car_type'])?></td>
                      <th width="100">车辆时间：</th>
                      <td width="150" class="text-info"><?=$records[$pre->id]['use_date']?></td>
                      <th width="100">联系人：</th>
                      <td width="150" class="text-info"><?=$records[$pre->id]['contact_user']?></td>
                  </tr>
                  <?php endif; ?>

                  <?php if ($pre->status == 1):?>
                  <tr>
                      <td colspan="6" class="text-center">
                         <a href="<?=Url::toRoute(['/grave/admin/process/del-bury', 'id'=>$pre->id])?>" class="bury-del btn btn-danger btn-xs">删除</a>
                      </td>
                  </tr>
                  <?php endif;?>
                  </tbody>
                </table>
              </div>

          <?php endforeach ?>
        <?php endif;?>

        <?php if ($bury):?>
            <?php foreach ($bury as $index => $b): ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        安葬记录          </div>
                    <table class="table table-bordered table-condensed">
                        <tbody><tr>
                            <th width="100">逝者姓名：</th>
                            <td width="150" class="text-info"><?=$b->dead_name?></td>
                            <th width="100">安葬日期：</th>
                            <td class="text-info"><?=$b->bury_date?></td>
                        </tr>
                        <tr>
                            <th width="100">车辆类型：</th>

                            <td width="150" class="text-info"><?=CarRecord::carType($records[$b->id]['car_type'])?></td>
                            <th width="100">车辆时间：</th>
                            <td width="150" class="text-info"><?=$records[$b->id]['use_date']?></td>
                            <th width="100">联系人：</th>
                            <td width="150" class="text-info"><?=$records[$b->id]['contact_user']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach ?>
        <?php endif;?>
        

        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('up') ?>  

$(function(){
    $('.addrs, .pre_bury_date, .cartype input').change(function(){
hasFreeCar();
    });

    $('input[name="CarRecord[car_type]"]').change(function(){
      var val = $(this).val();

      if (val == 1 || val == 2) {
        $('#bury-car-contacts').show();
      } else {
        $('#bury-car-contacts').hide();
      }

    });

    $(".bury-del").click(function(e){
      e.preventDefault();

      if (!confirm("您确定要删除此项预葬信息吗")) {
        return ;
      }

      var url = $(this).attr('href');

      $.post(url, null, function(xhr){
        if (xhr.status) {
          location.reload();
        } else {
          alert(xhr.info);
        }
      },'json');
    });

    $.datetimepicker.setLocale('ch');
    $('#dt').datetimepicker({
      timepicker:true, 
      format:"Y-m-d H:i",
      step:30,
      weeks:true,
    })

})
function hasFreeCar(){
    var car_type = $('.cartype input:checked').val();
    var pre_bury = $('.pre_bury_date').val();
    var addr = $('.addrs').val();

    if (!car_type || !pre_bury || !addr || car_type ==3) {
        return ;
    }

    var url = "<?=Url::toRoute(['/grave/admin/car-record/has-free-car'])?>";
    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
    var data = {type:car_type,pre_bury_date:pre_bury,addr:addr,_csrf:csrf};

    $.post(url, data, function(xhr){
        if (!xhr.status){
            $('.msg span').text(xhr.info).closest('.msg').show();
        } else {
            $('.msg span').text(xhr.info).closest('.msg').hide();
        }
    }, 'json');
}


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 




















	


	

				

