<?php 
use app\core\helpers\Html;
?>
<style type="text/css">
.page-header{padding-bottom: 76px;}
.steps>li .step,.steps>li.complete .step:before{line-height:30px;background-color:#FFF;text-align:center}
.ace-spinner .spinbox-buttons>button.btn.spinbox-up:active{top:-1px}
.ace-spinner:not(.touch-spinner) .spinbox-buttons>.btn>.ace-icon{margin-top:-1px}.ace-spinner.touch-spinner .spinbox-buttons{margin:0;font-size:0}.ace-spinner.touch-spinner .spinbox-buttons .btn-sm{width:32px;padding-left:6px;padding-right:6px}.ace-spinner.touch-spinner .spinbox-buttons .btn-xs{width:24px;padding-left:4px;padding-right:4px}.ace-spinner.touch-spinner .spinbox-buttons .btn-lg{width:40px;padding-left:8px;padding-right:8px}.ace-spinner.touch-spinner .spinbox-buttons>.btn{margin:0 1px!important}.ace-spinner.touch-spinner .spinbox-buttons>.btn-xs{padding-top:3px;padding-bottom:3px}.steps{list-style:none;display:table;width:100%;padding:0;margin:0;position:relative}.steps>li{display:table-cell;text-align:center;width:1%}.steps>li .step{border:5px solid #CED1D6;color:#546474;font-size:15px;border-radius:100%;position:relative;z-index:2;display:inline-block;width:40px;height:40px}.steps>li:before{display:block;content:"";width:100%;height:1px;font-size:0;overflow:hidden;border-top:4px solid #CED1D6;position:relative;top:21px;z-index:1}.steps>li.last-child:before{max-width:50%;width:50%}.steps>li:last-child:before{max-width:50%;width:50%}.steps>li:first-child:before{max-width:51%;left:50%}.steps>li.active .step,.steps>li.active:before,.steps>li.complete .step,.steps>li.complete:before{border-color:#5293C4}.steps>li.complete .step{cursor:default;color:#FFF;-webkit-transition:transform ease .1s;-o-transition:transform ease .1s;transition:transform ease .1s}.steps>li.complete .step:before{display:block;position:absolute;top:0;left:0;bottom:0;right:0;border-radius:100%;content:"\f00c";z-index:3;font-family:FontAwesome;font-size:17px;color:#87BA21}.step-content,.tree{position:relative}.steps>li.complete:hover .step{-moz-transform:scale(1.1);-webkit-transform:scale(1.1);-o-transform:scale(1.1);-ms-transform:scale(1.1);transform:scale(1.1);border-color:#80afd4}.steps>li.complete:hover:before{border-color:#80afd4}.steps>li .title{display:block;margin-top:4px;max-width:100%;color:#949EA7;font-size:14px;z-index:104;text-align:center;table-layout:fixed;word-wrap:break-word}.steps>li.active .title,.steps>li.complete .title{color:#2B3D53}.step-content .step-pane{display:none;min-height:200px;padding:4px 8px 12px}.step-content .step-pane.active{display:block}.wizard-actions{text-align:right}@media only screen and (max-width:767px){.steps li .step,.steps li:after,.steps li:before{border-width:3px}.steps li .step{width:30px;height:30px;line-height:24px}.steps li.complete .step:before{line-height:24px;font-size:13px}.steps li:before{top:16px}
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
<hr>
        <div class="row">
            <div class="col-xs-12 address-index">
            	<div class="customer-form">

				    <form id="w0" class="form-horizontal" action="/admin/grave/customer/create.html" method="post">
				<input type="hidden" name="_csrf" value="UWg3aS1vQmgmGGAoVxYjEQBbXjtLOXQnOil.NkQiFRt8MVhYSltvEg==">
				    <div class="form-group field-customer-tomb_id required">
				<label class="control-label col-sm-2" for="customer-tomb_id">Tomb ID</label><div class="col-sm-10"><input type="text" id="customer-tomb_id" class="form-control" name="Customer[tomb_id]"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-user_id required">
				<label class="control-label col-sm-2" for="customer-user_id">User ID</label><div class="col-sm-10"><input type="text" id="customer-user_id" class="form-control" name="Customer[user_id]"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-name">
				<label class="control-label col-sm-2" for="customer-name">客户名</label><div class="col-sm-10"><input type="text" id="customer-name" class="form-control" name="Customer[name]" maxlength="200"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-phone">
				<label class="control-label col-sm-2" for="customer-phone">家庭电话</label><div class="col-sm-10"><input type="text" id="customer-phone" class="form-control" name="Customer[phone]" maxlength="20"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-mobile">
				<label class="control-label col-sm-2" for="customer-mobile">手机号</label><div class="col-sm-10"><input type="text" id="customer-mobile" class="form-control" name="Customer[mobile]" maxlength="20"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-email">
				<label class="control-label col-sm-2" for="customer-email">邮箱</label><div class="col-sm-10"><input type="text" id="customer-email" class="form-control" name="Customer[email]" maxlength="100"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-second_ct">
				<label class="control-label col-sm-2" for="customer-second_ct">第二联系人</label><div class="col-sm-10"><input type="text" id="customer-second_ct" class="form-control" name="Customer[second_ct]" maxlength="100"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-second_mobile">
				<label class="control-label col-sm-2" for="customer-second_mobile">第二联系人电话</label><div class="col-sm-10"><input type="text" id="customer-second_mobile" class="form-control" name="Customer[second_mobile]" maxlength="20"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-units">
				<label class="control-label col-sm-2" for="customer-units">Units</label><div class="col-sm-10"><input type="text" id="customer-units" class="form-control" name="Customer[units]" maxlength="255"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-relation">
				<label class="control-label col-sm-2" for="customer-relation">关系</label><div class="col-sm-10"><input type="text" id="customer-relation" class="form-control" name="Customer[relation]" maxlength="100"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-is_vip">
				<label class="control-label col-sm-2" for="customer-is_vip">是否vip</label><div class="col-sm-10"><input type="text" id="customer-is_vip" class="form-control" name="Customer[is_vip]"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-vip_desc">
				<label class="control-label col-sm-2" for="customer-vip_desc">vip描述</label><div class="col-sm-10"><textarea id="customer-vip_desc" class="form-control" name="Customer[vip_desc]" rows="6"></textarea><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-created_at">
				<label class="control-label col-sm-2" for="customer-created_at">添加时间</label><div class="col-sm-10"><input type="text" id="customer-created_at" class="form-control" name="Customer[created_at]"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-updated_at">
				<label class="control-label col-sm-2" for="customer-updated_at">修改时间</label><div class="col-sm-10"><input type="text" id="customer-updated_at" class="form-control" name="Customer[updated_at]"><div class="help-block"></div></div>
				</div>
				    <div class="form-group field-customer-status">
				<label class="control-label col-sm-2" for="customer-status">状态</label><div class="col-sm-10"><input type="text" id="customer-status" class="form-control" name="Customer[status]"><div class="help-block"></div></div>
				</div>

					<div class="form-group">
				        <div class="col-sm-offset-2 col-sm-3">
				            <button type="submit" class="btn btn-primary btn-block">保 存</button>        </div>
				    </div>
				    
				    </form>
				</div>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>









	


	

				

