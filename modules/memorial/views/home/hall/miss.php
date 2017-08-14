<?php
$this->params['current_nav'] = 'miss';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/relist.css');
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
        </div>
        <!---------------左边结束----------------->
        <!---------------右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">追忆文章</h2>
                <div class="blank"></div>
                <div id="ArticlePage">

                    <div class="blank"></div>
                    <div class="line"></div>
                    <div class="blank"></div>
                    <!---------------内容开始----------------->
                    <div class="news-list">
                        <?php $archives = $dataProvider->getModels() ?>
                        <ul>
                            <?php foreach ($archives as $archive):?>
                                <li>
                                    <h4><a href="#"><?=$archive->title?></a></h4>
                                    <div class="new-cont">
                                        <?=\app\core\helpers\Html::cutstr_html($archive->body, 200)?>
                                    </div>
                                    <div class="new-data">
                                    <span>
                                        发布人：
                                        <a href="javascript:void(0)">
                                            <?=$archive->user->username?>
                                        </a>
                                    </span>
                                        <span>阅读（<?=$archive->view_all?>次）</span>
                                        <span>评论（<?=$archive->com_all?>次）</span>
                                        <span>发布时间: <?=date('Y-m-d H:i', $archive->created_at)?></span>
                                    </div>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <!---------------内容结束----------------->
                    <div class="page">
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
                        ])
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>

