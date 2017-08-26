<?php
$this->params['current_nav'] = 'record';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/records.css');
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
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">远程祭祀记录</h2>
                <hr />
                <div id="SacrificeLogPageDIV">
                    <div class="blank"></div>
                    <!---------------内容开始----------------->
                    <div class="row">
                        <div class="jdjl-list">
                            <ul>
                                <?php $models = $dataProvider->getModels()?>
                                <?php foreach ($models as $v):?>
                                <li>
                                    <h4><?=$v->goodsSkuName?></h4>
                                    <p><img style="max-width: 100%;max-height: 100%;" alt="<?=$v->goodsSkuName?>" src="<?=$v->goods->getCover()?>"></p>
                                    <div>
                                        由
                                        <a href="#">
                                            <?=$v->user->username;?>
                                        </a>
                                        于<span><?=date('Y-m-d H:i',$v->created_at)?></span>敬献,
                                        有效时间<strong><?=$v->goods->days?></strong>天
                                    </div>
                                </li>
                                <?php endforeach;?>

                            </ul>
                        </div>
                    </div>
                    <!---------------内容结束----------------->
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
    </div>
</div>
