<?php
use yii\helpers\Url;

$id = $model->id;
Yii::$app->params['cur_nav'] = 'tomb_index';
?>
<div class="col-xs-2">
    <div>
        <h3 style="font-weight: 700;color:#666"><?=$model->tomb_no?></h3>
        <img width="100%" src="<?=$model->getCover('400x400')?>" alt="">
    </div>
    <div class="list-group no-radius no-border no-bg ">
        <a href="<?=Url::toRoute(['tomb', 'id'=>$id])?>" class="list-group-item <?php if($cur=='tomb')echo'active';?>">墓位信息</a>
        <a href="<?=Url::toRoute(['deads', 'id'=>$id])?>" class="list-group-item <?php if($cur=='deads')echo'active';?>">逝者资料</a>
        <a href="<?=Url::toRoute(['ins', 'id'=>$id])?>" class="list-group-item <?php if($cur=='ins')echo'active';?>">碑文</a>
        <a href="<?=Url::toRoute(['portrait', 'id'=>$id])?>" class="list-group-item <?php if($cur=='portrait')echo'active';?>">瓷像</a>
        <a href="<?=Url::toRoute(['goods', 'id'=>$id])?>" class="list-group-item <?php if($cur=='goods')echo'active';?>">已购商品</a>
        <!--
        <a href="<?=Url::toRoute(['bury', 'id'=>$id])?>" class="list-group-item <?php if($cur=='bury')echo'active';?>">安葬</a>
        -->
    </div>
</div>