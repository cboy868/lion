<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '选择模板';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
	.thumbnail.active{
		    background: #fc9;
	}
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=Html::a($this->title, ['theme'])?>
                <small>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?=\app\core\widgets\Alert::widget();?>
		<div class="row">
			<?php foreach ($themes as $k => $v): ?>
		  <div class="col-sm-6 col-md-3">
		    <div class="thumbnail well <?php if ($current->svalue == $k): ?> active<?php endif ?>">
		      <img src="<?=$v['screenshot']?>" alt="..." style="height:200px;">
		      <div class="caption">
		        <h4><?=$k?></h4>
		        <p>一些描述</p>
		        <p class="pull-right">
		        	<a href="<?=Url::toRoute(['set-theme', 'theme'=>$k])?>" class="btn btn-primary set" role="button">启用</a>
		        	<a href="<?=Url::toRoute(['pre', 'theme' => $k])?>" class="btn btn-default" target="_blank" role="button">预览</a>
		        </p>
		        <p>&nbsp;</p>
		      </div>
		    </div>
		  </div>
		  <?php endforeach?>
		</div>
    </div><!-- /.page-content-area -->
</div>


