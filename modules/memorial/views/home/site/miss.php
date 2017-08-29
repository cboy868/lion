<?php
use yii\helpers\Url;
use app\core\helpers\Html;

$this->params['current_nav'] = 'miss';
\app\modules\memorial\assets\MansoryAsset::register($this);
?>
<div class="container main-container">
    <div class="waheaven-banner">
        <img src="/static/images/memorial/memorial_miss.png" width="100%">
        <div class="info">
            <h2 class="text-center">当思念化为文字，我们不再遥远</h2>
            <p>文字留存，传递思念之情，让爱与思念永恒传递，生命故事永久流传。</p>
        </div>
    </div>
    <div class="blank"></div>
    <div class="sort-inner">
        <ul>
            <li class="pull-right">
                <form method="get"">
                    <input name="BlogSearch[res]" value="<?=\app\modules\blog\models\Blog::RES_MISS?>" type="hidden">
                    <input name="BlogSearch[title]" value="<?=$searchModel->title?>" placeholder="深情感文标题">
                    <button>搜索</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="blank"></div>
    <div class="article-list" style="position: relative;" id="masonry">
        <?php
        $models = $dataProvider->getModels();
        foreach ($models as $model):
        ?>
        <dl class="man-box">
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



<?php $this->beginBlock('cate') ?>
$(function(){
    $("#masonry").mpmansory(
        {
            childrenClass: 'man-box', // default is a div
            columnClasses: '', //add classes to items
            breakpoints:{
                lg: 4,
                md: 6,
                sm: 6,
                xs: 12
            },
            distributeBy: { order: false, height: false, attr: 'data-order', attrOrder: 'asc' },
            onload: function (items) {
                //make somthing with items
            }
        }
    );
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

