<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '用户角色管理 用户名底色变化之后表示已选中';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<small>
				<?php foreach ($keys as $k => $v): ?>
					<a href="#<?=$v?>"><?=$v?></a>
				<?php endforeach ?>
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
    		<div class="col-xs-12">
    			<?php foreach($user as $k=>$v): ?>
					<h5> <a id="<?=$k?>" href="#" class="btn btn-xs pinyin" title="全选"><?=$k?></a><small class="pinyin">全选</small></h5>
					<ul class="user-list">
						<?php foreach($v as $key=>$val): ?>
					    <li rel="user-id" data-user_id="<?=$key?>" class="<?php if($val['is_sel'] == 1) echo 'selected';?> user">
					    	<?=$val['username']?>
					    </li>
					    <?php endforeach;?>
					    <div style="clear:both"></div>
					</ul>
				<?php endforeach;?>
	            <input type="hidden" name="role_name" value="<?=$role_name;?>">
			</div>
		</div>
	</div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('auth') ?>  
$(function(){
	$('.user').click(function(){
		var user_id = [];
		var is_sel = $(this).hasClass('selected');
		user_id.push($(this).data('user_id'));
		roleAssign(user_id, !is_sel);
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
	var role = $('input[name=role_name]').val();
	var url = "<?=Url::toRoute('toggle-user');?>";
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
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
