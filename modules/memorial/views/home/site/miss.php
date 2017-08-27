<?php
use yii\helpers\Url;
use app\core\helpers\Html;

$this->params['current_nav'] = 'miss';
?>
<div class="container">
    <div class="waheaven-banner">
        <img src="/resource/images/index/img320(3).jpg">
        <div class="info">
            <h2 class="text-center">专属网络思念空间</h2>
            <p>个人纪念馆，能让往生者的一生故事得以完整的留存，给后人留下宝贵的精神遗产。使家属无论随时随地都可以通过网络来祭拜往生者，传递思念之情，真正做到让爱与思念没有距离、生命的故事永久流传。</p>
            <div class="blank"></div>
            <p class="text-center"><a href="/MemberCenter/Memorial/Add"><button class="btn btn-warning btn-lg">免费创建纪念馆</button></a></p>
        </div>
    </div>
    <div class="blank"></div>
    <div class="sort-inner">
        <ul>
            <li class="pull-right">
                <form method="get" action="/Article">
                    <input name="keyword" placeholder="深情感文标题"><button>搜索</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="blank"></div>
    <div class="article-list" style="position: relative;">
        <?php
        $models = $dataProvider->getModels();
        foreach ($models as $model):
        ?>
        <dl>
            <dt>
                <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/miss-view','id'=>$model->memorial_id,'bid'=>$model->id])?>">
                    <h4><?=$model->title?></h4>
                </a>
            </dt>
            <dd>
                <div class="article-body">
                    <?=Html::cutstr_html($model->body, 100)?>
                </div>
                <div class="article-footer">
                    <div class="pull-left">
                        <a href="#">
                            <img src="<?=$model->user->getAvatar('36x36')?>">
                        </a> 来自
                        <a href="#">
                            <?=$model->user->username?>
                        </a>
                        <span><?=date('Y-m-d H:i', $model->created_at)?></span>
                    </div>
                </div>
            </dd>
        </dl>
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