<?php 
use app\assets\RevolutionAsset;
RevolutionAsset::register($this);
?>
<div class="fullwidthbanner-container">
    <div class="fullwidthbanner">
    <!-- <div class="tp-banner revslider-initialised tp-simpleresponsive" style="max-height: 500px; height: 320px;"> -->
        <ul style="display: block;">
            <?php foreach ($focus as $v): ?>
                <li data-transition="random" data-link="#" data-slotamount="7" data-masterspeed="300" >
                    <div class="slotholder">
                        <img src="<?=$v['image']?>" class="defaultimg" style="">
                    </div>
                    <div class="tp-caption slider-text-description sft str"  data-x="20" data-y="200" data-start="1000" data-easing="easeOutBack" data-end="4500" data-endspeed="500" style="color:white;">
                        <p style="text-align:left;">
                        <?=$v['intro']?>
                        </p>
                    </div>
                    <div class="" data-x="0" data-y="0" data-linktoslide="no" data-start="0">
                        <a target="_self" href="<?=$v['link']?>">
                        <div></div>
                        </a>
                    </div>

                </li>
            <?php endforeach ?>
        </ul>
        <div class="tp-bannertimer tp-bottom" style="width: 85.0049%; overflow: hidden;"></div>
        <div class="tp-loader" style="display: none;"></div>
    </div>
</div>

<?php $this->beginBlock('slide') ?>  
$(function(){
    $('.fullwidthbanner').revolution({
        delay:10000,
        startwidth:1170,
        startheight:320,
        hideThumbs:10,
        fullWidth:"on",
        forceFullWidth:"on"
    });
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['slide'], \yii\web\View::POS_END); ?>  



