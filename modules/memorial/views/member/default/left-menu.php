<?php
use yii\helpers\Url;

$id = $model->id;
Yii::$app->params['cur_nav'] = 'memorial_index';
?>
<div class="col-xs-2">
    <div>
        <h3><?=$model->title?></h3>
        <img width="100%" src="<?=$model->getThumbImg('400x400')?>" alt="">
    </div>
    <div class="list-group no-radius no-border no-bg ">
        <a href="<?=Url::toRoute(['update', 'id'=>$id])?>" class="list-group-item <?php if($cur=='base')echo'active';?>">基本信息</a>
        <a href="<?=Url::toRoute(['deads', 'id'=>$id])?>" class="list-group-item <?php if($cur=='dead')echo'active';?>">逝者资料</a>
        <a href="<?=Url::toRoute(['archive', 'id'=>$id])?>" class="list-group-item <?php if($cur=='archive')echo'active';?>">档案资料</a>
        <!--                    <a href="#" class="list-group-item">模板设置</a>-->
        <a href="<?=Url::toRoute(['miss', 'id'=>$id])?>" class="list-group-item <?php if($cur=='miss')echo'active';?>">追思文章</a>
        <a href="<?=Url::toRoute(['album', 'id'=>$id])?>" class="list-group-item <?php if($cur=='album')echo'active';?>">回忆相册</a>
        <a href="<?=Url::toRoute(['msg', 'id'=>$id])?>" class="list-group-item <?php if($cur=='msg')echo'active';?>">祝福管理</a>
    </div>
</div>