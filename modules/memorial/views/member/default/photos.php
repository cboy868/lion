<?php


use app\core\widgets\Webup\Areaup;
use app\core\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '照片列表';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '相册管理', 'url' => ['album', 'id'=>$memorial->id]];
$this->params['breadcrumbs'][] = $this->title;
\app\assets\ColorBoxAsset::register($this);
$this->registerCssFile('/static/site/blog.css');
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'album', 'model'=>$memorial])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
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
                            <div class="padder-h text-center dbox" rel="<?=$photo->id?>">
                                <input class="title" type="text" placeholder="照片名" value="<?=$photo->title?>" style="width:100%;">
                                <textarea class="desc" placeholder="照片描述" style="width:100%;height:80px;"><?=$photo->body?></textarea>
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

    $('.title, .desc').change(function(e){
        e.preventDefault();
        var box = $(this).closest('.dbox');

        var title = box.find('.title').val();
        var desc = box.find('.desc').val();
        var id = box.attr('rel');
        var csrf="<?=Yii::$app->request->csrfToken?>";
        $.post("<?=Url::toRoute(['tit-des'])?>", {title:title, desc:desc, id:id, _csrf:csrf}, function(xhr){
            if (xhr.status) {
                box.popover({ placement:'top', content:'修改成功'}).popover('toggle');
            } else {
                box.popover({ placement:'top', content:'修改失败，请重试'}).popover('toggle');
            }
        }, 'json');

    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>




