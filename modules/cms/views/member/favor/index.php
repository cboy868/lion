<?php 
use app\core\helpers\Url;

$this->title = 'Favorites';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
	.list-group li, .list-link a{
		padding: 0;
	}
	.list-group, .list-link{
		border:none;
	}
</style>

<div class="tab">

<?php if (Yii::$app->getSession()->hasFlash('success')): ?>
     <p class="bg-main" style="padding:15px 20px">
        Success: <?=Yii::$app->getSession()->getFlash('success')?>
    </p>
<?php endif ?>
<?php if (Yii::$app->getSession()->hasFlash('error')): ?>
     <p class="bg-dot" style="padding:15px 20px">
        Error: <?=Yii::$app->getSession()->getFlash('error')?>
    </p>
<?php endif ?>
	<div class="tab-head">
		<strong>My Favorites</strong> <span class="tab-more"></span>
		<ul class="tab-nav">
		<?php foreach ($res as $k=>$v): ?>
			<li class="<?php if ($params['res'] == $k): ?>active<?php endif ?>">
				<a href="<?=Url::toRoute(['index', 'res'=>$k])?>"><?=Yii::t('app/member', $v)?></a> 
			</li>
		<?php endforeach ?>
		</ul>
	</div>
	<div class="tab-body">
		<div class="tab-panel active" id="tab-start">
			<div class="table-responsive">
				<table class="table table-hover">
					<?php $i=0;foreach ($dataProvider->getModels() as $k => $v): ?>
					<tr>
						<td class="list-link">
							<a href="<?=$v['res_url']?>"   target="_blank"><?=$v['title']?></a>
						</td>
						<td width="40">
							<a href="<?=Url::toRoute(['delete', 'id'=>$v['id']])?>" class="float-right badge bg-main del" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
							<span class="glyphicon glyphicon-trash"></span>Delete
							</a> 
						</td>
					</tr>
					<?php $i++;endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>

