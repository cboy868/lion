<?php
use yii\helpers\Url;
\app\assets\SwiperAsset::register($this);
?>
<div class="box">
    <div class="side-title">
        <a class="tit" href="<?=Url::toRoute(['album', 'id'=>$memorial_id])?>">音容笑貌</a>
        <a class="more" href="<?=Url::toRoute(['album', 'id'=>$memorial_id])?>">更多&gt;&gt;</a>
    </div>
    <div class="photo">
        <div class="swiper-container" style="max-height: 230px;">
            <div class="swiper-wrapper">
                <?php foreach ($models as $photo):?>
                    <div class="swiper-slide">
                        <img style="width:100%;" src="<?=$photo->getThumb('470x470')?>" alt="">
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('memorial') ?>
$(function(){
    var mySwiper = new Swiper ('.swiper-container', {
        autoplay: 1000,
        autoHeight:true,
        direction: 'vertical',
        loop: true,
    })
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>


