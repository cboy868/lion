<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\assets\ExtAsset;

ExtAsset::register($this);
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
                      <a href="" class="btn btn-warning">购买礼仪</a>
                    </small>
                  </div>
                  
                  <!-- <form id="bury-form" method="post" action="/admin/process/bury_save" class="form-horizontal" role="form"> -->
                      <input type="hidden" name="tomb_id" value="{$tomb_info.id}" />
                      <input type="hidden" name="user_id" value="{$tomb_info.user_id}" />
                     
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

                                      <?= $form->field($nRecord, "car_type")->radioList($car_type)->label(false) ?>
                                  </div>
                                  <div class="col-sm-4">
                                      <?= $form->field($model, "pre_bury_date")->textInput(['dt'=>'true']) ?>
                                      <?= $form->field($nRecord, "addr_id")->dropDownList($car_addr) ?>
                                    </div>
                                      
                                  </div>
                              </div>
                      

                    

                      <div class="row" id="bury-car-contacts" style=";">
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
        <div class="col-md-12">
            <div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
              暂无要安葬的逝者
            </div>
        </div>

         <?php endif ?>

        <div class="row">

          <?php foreach ($pres as $index => $pre): ?>
                 
          <div class="col-sm-12">
              <div class="panel panel-success">
                 <div class="panel-heading"> 
                     预葬记录          </div>
                <table class="table table-bordered table-condensed">
                  <tbody><tr>
                     <th width="100">逝者姓名：</th>
                     <td width="150" class="text-info"><?=$pre->dead_name?></td>
                     <th width="100">预葬日期：</th>
                     <td class="text-info"><?=$pre->pre_bury_date?></td>
                     <th width="100">安葬日期：</th>
                     <td width="150" class="text-info"></td>
                  </tr>
                  <tr>
                      <th width="100">车辆类型：</th>
                      <td width="150" class="text-info"><?=$records[$pre->id]['car_type']?></td>
                      <th width="100">车辆时间：</th>
                      <td width="150" class="text-info"><?=$records[$pre->id]['use_date']?></td>
                      <th width="100">联系人：</th>
                      <td width="150" class="text-info"><?=$records[$pre->id]['contact_user']?></td>
                  </tr>

                  
                  <tr>
                      <td colspan="6" class="text-center">
                         <a href="/admin/process/bury_read?bury_id=14219" class="bury-read-btn btn btn-warning btn-xs">修改</a>

                         <a href="/admin/process/del_bury?id=14219" class="bury-del-btn btn btn-danger btn-xs">删除</a>   
                      </td>
                  </tr>
                           </tbody></table>
              </div>
          </div>

          <?php endforeach ?>




        </div>
        

        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>







<script type="text/javascript" charset="utf-8">
$(function(){
// start        
var BuryContainer = $('#bury-container');
var address_price = $.parseJSON('{$address_price}');

BuryContainer.find('a.bury-select-goods').cPanel({
    beforeStart: function(btn){
        var $this = $(this);
        var url = btn.attr('href');
        var _content = $('<div id="_content" class="row"></div>');
        _content.load(url);
        $(this).append(_content);

    },
    afterEnd: function(){
        var datas = {
            'cate_id'    : BuryGoodsBox.data('cateId'),
            'is_bag'     : BuryGoodsBox.data('isBag'),
            'bury_id'    : BuryGoodsBox.data('buryId'),
            'goods_id'   : [],
            'goods_num'  : []
        };

        BuryGoodsBox.find('li.active').each(function(index,item){
            var $this = $(item);
            var goodsInfo = $this.find('input.buy-num');
            datas['goods_id'].push(goodsInfo.data('goodsId'));
            datas['goods_num'].push(goodsInfo.val());
        });

        $.post('/admin/process/bury_goods_save', datas, function(xhr){
            var html = $.trim(xhr);
            if ( html ) {
                window.location.reload();
            }
        },'html');
    }
});

// 选择逝者 定安葬时间 --------------------------------------------
// form
var buryForm = BuryContainer.find('#bury-form');
// 待安葬逝者列表
var preBuryDeadInput = buryForm.find('input[rel=pre_bury_dead]');
// 定安葬时间输入框
var editBuryDateBox = buryForm.find('#edit-bury-date-box');
// 定安葬时间
var editBuryDateInput = buryForm.find('input[rel=pre_bury_date]'); 
// 车辆类型框
var buryCarTypeBox = buryForm.find('#bury-car-type-box');
// 车辆类型选择
var carTypeIdInput = buryForm.find('input[rel=car_type_id]');
// 时间选择框
var buryCarTimeBox = buryForm.find('#bury-car-time-box');
// 接盒地点输入框
var buryCarAddrBox = buryForm.find('#bury-car-addr');
// 接盒地点
var buryCarAddrInput = buryForm.find('select[rel=address_id]');
// 时间列表
var carTimeListBox = buryForm.find('#car-time-list-box');
// 联系人输入框
var buryCarContacts = buryForm.find('#bury-car-contacts');
// 保存按钮
var burySaveBtn = buryForm.find('#bury-save-btn');
// 读取按钮
var buryReadBtn = BuryContainer.find('a.bury-read-btn');

preBuryDeadInput.change(function(e){
    var hasChecked = preBuryDeadInput.is(":checked");
    if ( hasChecked ) {
        editBuryDateBox.show();
    } else {
        editBuryDateInput.val('');
        editBuryDateBox.hide();
        $('#current-bury-num').text('');
    }
});

// 校验设置
var setting = {
  rules: {
    pre_bury_date: {
      required: true,
      dateISO: true
    }
  }
}

var validator = buryForm.validate(setting);
// 检验设置结束

var isDateISO = function( value ) {
    return true;
    // return /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(value);
};

// 监视安葬时间变化
var inspectBuryDate = function(evet) {
    var $this = $(this);
    var dateStr = $.trim( editBuryDateInput.val() );
    if ( dateStr.length > 0 && isDateISO(dateStr) ) {
        /*
        var buryDate = buryCarTypeBox.data('buryDate');
        console.log( buryDate );
        */

        // if ( buryDate != dateStr ) {
            // TODO 复位操作 
            if ( buryCarTypeBox.is(':hidden')) {
                buryCarTypeBox.show();
            } else {
                carTypeIdInput.removeAttr('checked');
                buryCarAddrInput.val(0);
                carTimeListBox.html(''); 
                buryCarTimeBox.hide();
                buryCarAddrBox.hide();
            } 
            
            // 显示选择日期当前安葬数量
            $.get('/admin/bury/checkdate', {'bury_date':dateStr},function(xhr){

               var is_full = false;
               var total = parseInt(xhr.data.total);
               var num = parseInt(xhr.data.num);
               if ( num >= total ) {
                   is_full = true;
               }

               if ( is_full ) {
                  var msg = '当天安葬数量已满';
               } else {
                  var msg = '当天安葬数量: ' + num;
               }
               $('#current-bury-num').text( msg ); 

               if ( is_full ) {
                   carTypeIdInput.removeAttr('checked');
                   buryCarAddrInput.val(0);
                   carTimeListBox.html(''); 
                   buryCarTimeBox.hide();
                   buryCarTypeBox.hide();
                   $this.val('');
               }
                
                
            },'json');
            

            buryCarTypeBox.data('buryDate', dateStr);
        // }
    }
};
editBuryDateInput.change( inspectBuryDate );
// editBuryDateInput.keyup( inspectBuryDate );

/**
 * ajax 获取数据
 */
var getCarList = function(param)
{
    var url = '/admin/bury/car_list';
    $.get(url, param, function(xhr) {
        carTimeListBox.html(''); 
        carTimeListBox.html(xhr);
    }, 'html');
    buryCarTimeBox.show();
}

// 监视车辆类型选择
carTypeIdInput.click(function(e){
    var $this = $(this);
    var carTypeId = $this.val();
    if ( carTypeId == 1 ) {
        buryCarAddrBox.show();
        carTimeListBox.html('');
        buryCarTimeBox.hide();
        buryCarContacts.hide();
    } else {
        buryCarAddrBox.hide();
        buryCarAddrInput.val(0);
        var datas = {
                'tomb_id' : process.tomb_id,
                'type_id' : $this.val(),
                'date'    : editBuryDateInput.val()
            };
        getCarList(datas);
        if ( buryCarContacts.is(':hidden')) {
            buryCarContacts.show();
        }
        // 发出请求
    }
});

// 监视接盒地点
buryCarAddrInput.change(function(e){
    var $this = $(this);
    var datas = {
            'tomb_id'    : process.tomb_id,
            'type_id'    : carTypeIdInput.val(),
            'date'       : editBuryDateInput.val(),
            'address_id' : $this.val()
        };
    getCarList( datas );
    buryCarContacts.show();
    var price = address_price[$this.val()] || 0;
    if ( price ) {
        $this.next('span.address_price').text('＋价: ¥' + price); 
    } else {
        $this.next('span.address_price').text(''); 
    }

});


// 校验

var validSetting = {};
buryForm.validate(validSetting);        

// 表单提交
var options = {
        dataType : 'json',
        success  : function(xhr, statusText, form) {
            if (xhr.status == 1) {
                alert('保存成功！');
                window.location.href = root_url + '#bury';
                window.location.reload();
                // burySaveBtn.button('reset');
            }
        }
    };

burySaveBtn.click(function(e){
    e.preventDefault();
    if ( buryForm.valid() ) {
        burySaveBtn.button('loading');
        buryForm.ajaxSubmit(options);
    }
});

$('a.bury-del-btn').click(function(e){
    e.preventDefault();        
    if ( confirm("您确认要删除该预葬记录?") ) {
        var url = $(this).attr('href');
        $.get(url, function(xhr){
            if (xhr.status == 1) {
                window.location.reload();
            }
        },'json');
    }
});

// 修改按钮
BuryContainer.find('a.bury-read-btn').cPanel({
    beforeStart: function(btn){
        var $this = $(this);
        var url = btn.attr('href');
        var _content = $('<div id="_content" class="row"></div>');
        _content.load(url);
        $(this).append(_content);
    },
    afterEnd: function(){

    }
});

// 删除商品
var url = '/admin/process/del_order_detail';
BuryContainer.on('click', 'a.bury-del-goods', function(e) {
    e.preventDefault();
    var $this = $(this);
    var datas = {
            'id' : $this.data('id')
        };
    $.get(url, datas, function(xhr){
        if ( xhr.status == 1 ) {
            $this.parents('li:first').hide(200,function(){
                $this.remove(); 
                window.location.reload();
            });
        }
    },'json');
});

// end
});
</script>





























	


	

				

