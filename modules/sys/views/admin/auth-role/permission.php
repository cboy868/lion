<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '为【'.$role->real_title.'】分配权限 底色变深表示已选中';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
    		<div class="col-xs-12">
				<ul class="user-list">
					<?php foreach($permission as $key=>$val): ?>
				    <li rel="user-id" data-permission_id="<?=$val['name']?>" class="<?php if($val['is_sel'] == 1) echo 'selected';?> permission">
				    	<?=$val['real_title']?>
				    </li>
				    <?php endforeach;?>
				    <div style="clear:both"></div>
				</ul>
            <input type="hidden" name="role_name" value="<?=$role->name;?>">
		</div>
</div>

<style type="text/css">
ul.user-list {
	margin: 0px;
	padding: 0px;
	list-style: none;
	font-size: 14px;
	padding: 10px 20px;
	border: 1px #ccc dashed;
}
ul.user-list li {
	float: left;
	width: 5em;
	border: 1px solid white;
	margin: 5px;
	padding: 3px;
	cursor: pointer;
}
ul.user-list li.selected {
	background-color: #E0DF95;
}
.pinyin{cursor: pointer;}
ul, ol, li {
	list-style: none;
}
</style>
	</div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('per') ?>  
$(function(){
	$('.permission').click(function(){
		var is_sel = $(this).hasClass('selected');
		var permission_group = $(this).data('permission_id');
		var role_name = $('input[name=role_name]').val();
		var data = {is_sel:!is_sel, role_name:role_name, permission_group:permission_group};
		var url = $('.permission-toggle').attr('href');
		var url = "<?=Url::toRoute('toggle-permission')?>";
		var _this = this;

		$.post(url, data, function(xhr){
			if (xhr.status) {
				if (is_sel) {
					$(_this).removeClass('selected');
				} else {
					$(_this).addClass('selected');
				};
			};
		},'json');


	});

	$('.pinyin').click(function(e){
		e.preventDefault();
		var user_ids = [];
		$(this).parent().next('.user-list').find('.user:not(.selected)').each(function(e){
			user_ids.push($(this).data('user_id'));
		});
		if (user_ids.length) {
			roleAssign(user_ids, true);
		};
	});
});
function roleAssign(user_id, is_sel)
{
	
	var url = $('.role-assign').attr('href');
	var csrf = $('meta[name=csrf-token]').attr('content');
	$.post(url, {role:role,user_id:user_id,_csrf:csrf,is_sel:is_sel},function(xhr){
		$('input[name=csrf]').val(xhr.csrf);
		if (xhr.status) {
			if (isNaN(user_id)) {
				for (u in user_id) {
					$('li[data-user_id='+user_id[u]+']').addClass('selected');
				}
			} else {
				$('li[data-user_id='+user_id+']').toggleClass('selected');
			}
		};
	}, 'json');
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>  
