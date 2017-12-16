<?php 
use app\core\helpers\Html;
?>


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









	


	

				

