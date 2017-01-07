<?php 
use app\assets\ZoomAsset;
ZoomAsset::register($this);

?>
<style type="text/css">
.jqzoom{ width:450px; height:350px; position:relative;}
.list-h li{ float:left;}
#spec-n5{width:450px; height:56px; padding-top:6px; overflow:hidden;}
#spec-left{width:10px; height:45px; float:left; cursor:pointer; margin-top:5px;}
#spec-right{width:10px; height:45px; float:left;cursor:pointer; margin-top:5px;}
#spec-list{ width:400px; float:left; overflow:hidden; margin-left:2px; display:inline;margin-right:6px;}
#spec-list ul li{ float:left; margin-right:0px; display:inline; width:62px;}
#spec-list ul li img{ padding:2px ; border:1px solid #ccc; width:50px; height:50px;}
ul.nav-tabs>li>a{
    font-size: 16px;
}
ul.nav-tabs>li.active>a{
    color: #E28903;
}
#gal1 .zoomGalleryActive{
    border:1px solid #999;
}
#gal1 a{
    display: block;
    float: left;
    height: 50px;
    margin-left: 2px;
    border: 1px solid #ccc;
}
</style>

<div class="product-image" id="preview">
    <div class='jqzoom' id='spec-n1'>
        <img id="zoom_01" src='<?=$imgs[0]['path'] . '/425x350@' . $imgs[0]['name']?>' data-zoom-image="<?=$imgs[0]['path'] . '/850x700@' . $imgs[0]['name']?>" />
    </div>
    <div id='spec-n5'>
        <div class=control id='spec-left'>
            <img src="/theme/site/static/elevatezoom/images/left.gif" />
        </div>
        <div id='spec-list'>
            <ul class='list-h' id="gal1">
                <?php foreach ($imgs as $img): ?>

                    <a href="#" class="elevatezoom-gallery" data-image="<?=$img['path'] . '/425x350@' . $img['name']?>" data-zoom-image="<?=$img['path'] . '/850x700@' . $img['name']?>">
                    <img id="" src="<?=$img['path'] . '/50x50@' . $img['name']?>" >
                    </a>
                <?php endforeach ?>
            </ul>
        </div>
        <div class=control id='spec-right'>
            <img src="/theme/site/static/elevatezoom/images/right.gif" />
        </div>
    </div>
</div>

<?php $this->beginBlock('zoom') ?>  
jQuery(document).ready(function() {

    zoom();
    
    jQuery().UItoTop({ easingType: 'easeOutQuart' });    
});  


var zoom = function(){
    $('#zoom_01').elevateZoom({
    zoomType: "inner",
    cursor: "crosshair",
    gallery             : "gal1",
    zoomWindowFadeIn: 500,
    zoomWindowFadeOut: 750
   }); 

}

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['zoom'], \yii\web\View::POS_END); ?>  
