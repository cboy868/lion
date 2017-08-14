<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'album';
$this->registerCssFile('/static/site/blog.css');


\app\assets\ColorBoxAsset::register($this);
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>$album->memorial_id])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>$album->memorial_id])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
        </div>
        <!---------------左边结束----------------->
        <!---------------分组右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">相册</h2>
                <div class="blank"></div>
                <div class="line"></div>
                <div class="blank"></div>

                <div class="row masonry">
                    <?php $photos = $dataProvider->getModels()?>
                    <?php foreach ($photos as $k => $photo):?>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                            <div class="item panel panel-default wrapper-sm">
                                <div class="pos-rlt">
                                    <a href="<?=$photo->getThumb('690x430')?>" style="height: 150px;display: inline-block" class="artimg ">
                                        <img style="max-height: 200px;" class="r r-2x img-full image" src="<?=$photo->getThumb('690x430')?>">
                                    </a>
                                </div>
                                <div class="padder-h text-center">
                                    <h4 class="h4 m-b-sm"><?=$photo->title?></h4>
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
        <!---------------分组右边结束----------------->
    </div>
</div>
<?php $this->beginBlock('cate') ?>
    $(function(){

        $(".image").click(function(e) {
            e.preventDefault();
            var title = $(this).attr('title');
            $(".artimg").colorbox({
                rel: 'artimg',
                maxWidth:'600px',
                maxHeight:'700px',
                next:'',
                previous:'',
                close:'',
                current:""
            });
        });

    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>


