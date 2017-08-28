<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'memorial';
?>
<div class="container bannerAndLogin">
    <a href="#" >
        <img src="/static/images/memorial/memorial_banner.png" width="100%">
    </a>
</div>

<div class="blank"></div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="sort-inner">
                <ul>
                    <li class="pull-right">
                        <form method="get" >
                            <input name="MemorialSearch[title]" value="<?=$searchModel->title?>" placeholder="纪念馆名称"><button>搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="blank"></div>

    <div class="row memorials-list">
        <?php
        $models = $dataProvider->getModels();
        foreach ($models as $model):
        ?>
        <div class="col-md-4">
            <div class="media">
                <div class="media-left">
                    <div class="tab-content">
                        <div class="tab-pane active  ml_0_0">
                            <a href="<?=Url::toRoute(['/memorial/home/hall/index','id'=>$model->id])?>" target="_blank">
                                <img src="<?=$model->getThumbImg('174x210')?>">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/index','id'=>$model->id])?>">
                        <h4 class="media-heading ellipsis"><?=$model->title?></h4>
                    </a>
                    <div class="tab-content">
                        <?php foreach ($model->deads as $v):?>
                        <div class="tab-pane active ml_0_0">
                            <a target="_blank" href="#">
                                <p class="ellipsis"><?=$v->dead_name?></p>
                            </a>
                            <em><?=$v->birth?>-<?=$v->fete?></em>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <p class="ellipsis">建馆人：<?=$model->user->username?></p>
                    <small>建馆时间：<?=date('Y-m-d', $model->created_at)?></small><br>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
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