<?php
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\widgets\LinkPager;
?>
<?php foreach ($dataProvider->getModels() as $k => $model): ?>
    <div class="thumbnail" style="width:100px;height:100px;float: left;">
        <a href="<?=Url::toRoute(['album-view', 'mid'=>$mid, 'id'=>$model->id])?>">
            <img src="<?=$model->getImg('380x265')?>" alt="<?=$model->title?>" style="height:65px;">
        </a>
        <div class="caption">
            <p><a href="<?=Url::toRoute(['album-view', 'mid'=>$mid, 'id'=>$model->id])?>">
                    <?=StringHelper::truncate($model->title,20)?></a></p>

            <p><a href="<?=Url::toRoute(['delete-album', 'id'=>$model->id, 'mid'=>$mid])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a>
                <a href="<?=Url::toRoute(['update', 'id'=>$model->id, 'mid'=>$mid, 'type'=>'album'])?>" class="btn btn-success modalEditButton" role="button"><i class="fa fa-pencil"></i></a></p>
        </div>
    </div>
<?php endforeach ?>
<?php
echo LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
]);
?>

<div class="hr hr-18 dotted hr-double"></div>