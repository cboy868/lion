<?php


use app\core\widgets\Webup\Areaup;
use app\core\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '照片列表';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '相册管理', 'url' => ['album', 'id'=>$memorial->id]];
$this->params['breadcrumbs'][] = $this->title;
\app\assets\ColorBoxAsset::register($this);
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'album','id'=>$memorial->id])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <style>
                    .img-full {
                        max-width: 100%;
                    }
                    .r-2x {
                        border-radius: 4px;
                    }
                    .r {
                        border-radius: 2px 2px 2px 2px;
                    }
                    .wrapper-sm {
                        padding: 10px;
                    }
                    .pos-rlt {
                        position: relative;
                        text-align: center;
                    }
                    .item .bottom {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                    }
                    .badge {
                        margin-bottom: 5px;
                        margin-right: 5px;
                    }
                    a{
                        color:#333;
                    }
                    .bg-set{
                        color:#666;
                        background-color: #62A8D1;
                    }
                    .bg-del{
                        color:#f33;
                        background-color: #62A8D1;
                    }
                    .pagination {
                        margin: 10px 0;
                    }
                    .panel-footer{
                        padding:0 20px;
                    }
                </style>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo Areaup::widget(['options'=>[
                            'res_name'=>'album',
                            'auto' => false,
                            'album_id'=>$album->id,
                            'server' => Url::toRoute('album-upload')
                        ]]);
                        ?>
                    </div>
                </div>
                <div class="row masonry">
                    <?php $photos = $dataProvider->getModels();?>
                    <?php foreach ($photos as $photo):?>
                    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <?php if ($album->thumb == $photo->id):?>
                                        <a class="badge bg-set" href="javascript:;">
                                            <small>封面</small>
                                        </a>
                                    <?php else:?>
                                    <a class="badge bg-set" href="<?=Url::toRoute(['set-album-cover', 'id'=>$photo->id])?>">
                                        <small>设为封面</small>
                                    </a>
                                    <?php endif;?>
                                    <a class="badge bg-del"
                                       href="<?=Url::toRoute(['del-photo','id'=>$photo->id])?>"
                                       data-method="post"
                                       data-confirm="删除不可恢复，请再次确认？"
                                    >
                                        <small>删除 </small>
                                    </a>
                                </div>
                                <a href="<?=$photo->getThumb('690x430')?>" style="height: 200px;display: inline-block" class="artimg ">
                                    <img style="max-height: 200px;" class="r r-2x img-full image" src="<?=$photo->getThumb('690x430')?>">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <input type="text" placeholder="照片名" value="<?=$photo->title?>" style="width:100%;">
                                <textarea placeholder="照片描述" style="width:100%;height:80px;"><?=$photo->body?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>

                <footer class="panel-footer">
                    <div class="row">
                        <?php
                        echo LinkPager::widget([
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



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>
$(function(){
    $('.selize-rel').each(function(index, item){
        var $this = $(item);
        if ( !$this.data('select-init') ) {
            $this.selectize({
                create: true
            });
        }
    });

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




