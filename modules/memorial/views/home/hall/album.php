<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'album';
$this->registerCssFile('/static/site/blog.css');
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'miss','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'archive','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
        </div>
        <!---------------左边结束----------------->

        <!---------------右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">相册</h2>
                <div class="blank"></div>
                <div class="line"></div>
                <div class="blank"></div>

                <div class="row masonry">
                    <?php $albums = $dataProvider->getModels()?>
                    <?php foreach ($albums as $k => $album):?>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                            <div class="item panel panel-default wrapper-sm">
                                <div class="pos-rlt">
                                    <div class="bottom">
                                        <span class="pull-right badge bg-white"><small><?=$album->num?></small></span>
                                    </div>
                                    <a style="height: 150px;display: inline-block" href="<?=Url::toRoute(['photos', 'album_id'=>$album->id, 'id'=>$album->memorial_id])?>">
                                        <img class="album-img" alt="" src="<?=$album->getCover('690x430')?>">
                                    </a>
                                </div>
                                <div class="padder-h text-center">
                                    <h4 class="h4 m-b-sm"><?=$album->title?> </h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>

            </div>

            <footer class="panel-footer">
                <div class="row">
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
            </footer>
        </div>
        <!---------------右边结束----------------->
    </div>
</div>
