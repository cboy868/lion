<?php
use yii\helpers\Url;

$this->params['current_nav'] = 'album';
?>
<div class="container main-container">
    <div class="waheaven-banner">
        <img src="/static/images/memorial/memorial_album.png" width="100%">

        <div class="info">
            <h2 class="text-center">音容笑貌 时光记忆</h2>
            <p>
                最美的曾经，瞬间便是永远，记录美好的回忆，寄托深深的思念。
                爱与思在时光中永恒，生命故事永久流传。
            </p>
            <div class="blank"></div>
        </div>
    </div>
    <div class="blank"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="sort-inner">
                <ul>
                    <li class="pull-right">
                        <form method="get" >
                            <input name="AlbumSearch[title]" value="<?=$searchModel->title?>" placeholder="相册名称">
                            <button>搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
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