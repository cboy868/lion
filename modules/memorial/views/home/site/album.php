<?php
use yii\helpers\Url;

$this->params['current_nav'] = 'album';
?>
<div class="container">
    <div class="waheaven-banner">
        <img alt="" src="" width="1300">

        <div class="info">
            <h2 class="text-center">时光流影 生命相册</h2>
            <p>
                留住最美的瞬间，写下真心的话语，记录美好的回忆，寄托思念的天堂。
                真正做到让爱与思念没有距离、生命的故事永久流传。
            </p>
            <div class="blank"></div>
        </div>
    </div>
    <div class="blank"></div>
    <div class="row times-list">
        <?php
        $models = $dataProvider->getModels();
        foreach ($models as $model):
        ?>
        <div class="col-md-3" data-type="img">
            <dl>
                <dt style="">
                    <a target="_blank"href="">
                        <img src="<?=$model->getCover('260x250')?>">
                    </a>
                </dt>
                <dd style="border-color:silver">
                    <ul>
                        <li><img src="<?=$model->user->getAvatar('36x36')?>"></li>
                        <li class="con">
                            <p><a href="#"> <?=$model->title?> </a></p>
                            <p class="from">来自 <a href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->memorial->id])?>"> <?=$model->memorial->title?> </a></p>
                        </li>
                    </ul>
                    <div style="height:25px" class="dd-footer">
                        <span style="float:left"><?=date('Y-m-d', $model->created_at)?></span>

                    </div>
                </dd>
            </dl>
        </div>
        <?php endforeach;?>
    </div>
    <div class="blank"></div>

    <div class="memorials-pager">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',
            'lastPageLabel' => '尾页',
            'firstPageLabel' => '首页',
            'options' => [
                'class' => 'pull-right pagination'
            ]
        ]);
        ?>
    </div>
</div>