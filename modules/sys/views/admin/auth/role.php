<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '角色管理 添加删除角色';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<small>
					<a href="<?=Url::toRoute(['create-role'])?>" title="添加角色" class="btn btn-info btn-xs remoteform">添加角色</a>
					<a href="<?=Url::to(['child'])?>" class='btn btn-info btn-xs'>子角色管理</a>
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="row">
					<div class="col-xs-12">
						<table id="sample-table-1" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>角色名</th>
									<th>注释</th>
									<th class="hidden-480">规则名</th>
									<th>
										<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
										数据
									</th>
									<th class="hidden-480">添加时间</th>
									<th width="25%" class="hidden-480"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($roles as $v):?>
								<tr>
									<td class="hidden-480"><?=$v->description?></td>
									<td><?=$v->real_title?></td>
									<td><?=$v->ruleName?></td>
									<td class="hidden-480">
										<span class="label label-sm label-warning"><?=$v->data?></span>
									</td>
									<td><?=date('Y/m/d',$v->createdAt)?></td>
									<td class="hidden-480">
										<div class="hidden-sm hidden-xs btn-group">
											<a href="<?=Url::to(['edit-role', 'role_name'=>$v->name]);?>" title="添加角色" role="button" class="btn btn-xs btn-info remoteform">
												<i class="ace-icon fa fa-pencil bigger-120"></i>编辑
											</a>

											<a class="btn btn-xs btn-danger del" href="<?=Url::to(['del-role','role_name'=>$v->name]);?>">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>删除
											</a>
											<a href="<?=Url::to(['role-user', 'role_name' => $v->name])?>" class='btn btn-info btn-xs'>选择用户</a>
											<a href="<?=Url::to(['role-auth', 'role_name' => $v->name])?>" class='btn btn-info btn-xs'>分配权限</a>
											
										</div>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.span -->
				</div><!-- /.row -->
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('auth') ?>  
$(function(){
	$('.del').click(function(e){
		e.preventDefault();
		if (!confirm('确定要删除此角色吗?')) {
			return false;
		};
		var url = $(this).attr('href');
		$.get(url,null,function(xhr){
			if (xhr.status) {
				location.reload();
			};
		},'json');
	});
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
