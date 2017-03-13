<?php 
use app\assets\ZoomAsset;
use app\core\models\Attachment;
ZoomAsset::register($this);

?>
<style type="text/css">
    a.thumbnail{
        border-bottom: 1px solid #eee;
        margin-bottom: 0;
        border-radius: 0;
    }
    .caption{
        position: relative;
        overflow: hidden;

        background-color: #fff;
        width: 100%;
        text-align: right;
        filter: alpha(opacity=70);
        -moz-opacity: 0.7;
        opacity: 0.7;
        overflow: hidden;
        border: 1px solid #ccc;
        border-top: 0;
    }
    .caption ul{
        margin:0px 5px;
        padding: 3px 0;
    }
    .caption ul img{
        margin:1px;
    }
    .caption ul img{
        border:1px solid #ccc;
    }
    .caption .imgpre,.caption .imgnext{
        position: absolute;
        top: 0;
        cursor: pointer;
    }

    .caption .imgpre{
        left: 0;
    }

    .caption .imgnext{
        right: 0;
    }
    #gal a{
        display: inline-block;
        border:#fff 1px solid;
    }
    #gal a.active{
        border:#ccc 1px solid;
    }

    
</style>

<?php 

$a = Attachment::getById($imgs[0]['id'], '50x50');

 ?>
<div class="col-xs-12 col-md-5">
    <a href="#" class="thumbnail" >
      <img id="zoom" src='<?=Attachment::getById($imgs[0]['id'], '450x450')?>' data-zoom-image="<?=Attachment::getById($imgs[0]['id'], '800x800')?>" />
    </a>
    <div class="caption ">
        <ul id="gal">
            <?php foreach ($imgs as $img): ?>
                <a href="#" class="elevatezoom-gallery" data-image="<?=Attachment::getById($img['id'], '450x450')?>" data-zoom-image="<?=Attachment::getById($img['id'], '800x800')?>">
                <img src="<?=Attachment::getById($img['id'], '50x50')?>" >
                </a>
            <?php endforeach ?>
            <div style="clear:both;"></div>
        </ul>
    <div style="clear:both;"></div>

    </div>
</div>


<?php $this->beginBlock('zoom') ?>  

$(function(){
    zoom();
    jQuery().UItoTop({ easingType: 'easeOutQuart' });   
})


var zoom = function(){
    $('#zoom').elevateZoom({
    //zoomType: "inner",
    cursor: "crosshair",
    gallery             : "gal",
    zoomWindowFadeIn: 500,
    zoomWindowFadeOut: 750,
    zoomWindowWidth: 200,
    zoomWindowHeight: 200,
    galleryActiveClass:'active',
    borderSize:0,
   }); 

}

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['zoom'], \yii\web\View::POS_END); ?>  
