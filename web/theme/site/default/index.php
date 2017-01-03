<?php 
use app\web\theme\site\widgets\Slide;
use app\modules\focus\models\Focus;

$this->title = 'HOME';
?>

<?=Slide::widget(['options'=>['cate'=>1, 'limit'=>3, 'size'=>'1200x300']]) ?>


<?php 

$focus = focus(3, 6, '380x265');
?>
<div class="grid-banner">
    <div class="grid-banner-inner">
        <div class="row nova-mg-pd">

        <?php foreach ($focus as $k => $v): ?>
            <div class="col-md-4 nova-left" style="height: 360px;overflow: hidden;">
                <a title="<?=$v['title']?>" href="<?=$v['link']?>">
                    <img title="Typre32_Lea Slimtech" src="<?=$v['image']?>" alt="<?=$v['title']?>">
                </a>
                <h2><?=$v['title']?></h2>
                <span><?=$v['intro']?></span>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>


