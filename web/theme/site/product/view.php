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

</style>


<div class="main-container col1-layout home-content-container">
    <ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
      <li><a href="<?=url(['/'])?>">Home</a></li>
      <li><a href="<?=url(['/home/product'])?>">products</a></li>
      <li class="active"><?=$data['name']?></li>
    </ol>
    <div class="main home-content">
        <div class="row columns-layout nova-mg-pd">
            <div class="col-main col-md-12 nova-mg-pd">
                <div id="messages_product_view"></div>
                <div class="product-view">
                    <div class="product-essential">
                        <form action="" method="post" id="product_addtocart_form">
                            <div class="no-display">
                                <input type="hidden" name="product" value="1842">
                                <input type="hidden" name="related_product" id="related-products-field" value="">
                            </div>  
                              
                            <div class="row nova-mg-pd">
                                <div class="product-img-box col-md-5 nova-mg-pd">

                                    <div class="product-image" id="preview">
                                            <div class='jqzoom' id='spec-n1'>
                                                <img id="zoom_01" src='<?=$imgs[0]['path'] . '/600x730@' . $imgs[0]['name']?>' data-image="<?=$imgs[0]['path'] . '/600x730@' . $imgs[0]['name']?>" height="350" width="425" />
                                            </div>
                                            <div id='spec-n5'>
                                                <div class=control id='spec-left'>
                                                    <img src="/theme/site/static/elevatezoom/images/left.gif" />
                                                </div>
                                                <div id='spec-list'>
                                                    <ul class='list-h'>
                                                        <?php foreach ($imgs as $img): ?>
                                                            <li><img src="<?=$img['path'] . '/600x730@' . $img['name']?>" data-src="<?=$img['path'] . '/600x730@' . $img['name']?>"> </li>
                                                        <?php endforeach ?>

                                                       <!--  <li><img src="/theme/site/static/img/rs_tn1big.jpg" data-src="./theme/site/static/img/rs_tn1big.jpg"> </li>
                                                        <li><img src="/theme/site/static/img/rs_tn2big.jpg" data-src="/theme/site/static/img/rs_tn2big.jpg"> </li>
                                                        <li><img src="/theme/site/static/img/rs_tn1big.jpg" data-src="/theme/site/static/img/rs_tn1big.jpg"> </li> -->
                                                    </ul>
                                                </div>
                                                <div class=control id='spec-right'>
                                                    <img src="/theme/site/static/elevatezoom/images/right.gif" />
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="product-shop col-md-7 nova-mg-pd">
                                    <div class="row nova-mg-pd">
                                        <div class="col-md-8 nova-pd-right">
                                            <div class="product-name">
                                                <h1><?=$data['name']?></h1>
                                            </div>
                                            
                                               <!-- <p class="email-friend"><a href="/sendfriend/product/send/id/1842/cat_id/163/">Email to a Friend</a></p>-->
                                            <div style="height:20px; width:1px;"></div>      

                                            <ul class="nav nav-tabs" role="tablist">
                                              <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">Description</a></li>
                                              <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">Specifications</a></li>
                                              <li role="presentation"><a href="#messages" role="tab" data-toggle="tab">Installations + Maintenance</a></li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                              <div role="tabpanel" class="tab-pane active" id="home">
                                                    <div class="short-description" style="border-bottom:none;padding:10px">
                                                        <div class="std">
                                                        <?=$data['intro']?>
                                                        </div>
                                                    </div>
                                              </div>

                                              <div role="tabpanel" class="tab-pane" id="profile" style="padding:10px;">
                                                    <table class="data-table" id="product-attribute-specs-table" style="display: block; height: 490px; overflow-y: scroll;">
                                                        <colgroup><col width="40%">
                                                        <col>
                                                        </colgroup>
                                                        <tbody>
                                                            <?php foreach ($attr as $k => $v): ?>
                                                                <tr class="first odd">
                                                                    <th class="label"><?=$v['attr_name']?></th>
                                                                    <td class="data last" style="vertical-align: middle;"><?=$v['attr_val']?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                              </div>
                                              <div role="tabpanel" class="tab-pane" id="messages">
                                                <div class="short-description" style="border-bottom:none;padding:10px">
                                                    <?=$data['skill']?>
                                                </div>
                                              </div>
                                            </div>
                                                                        
                                        </div>                
                                    </div>
                                </div>
                            </div>
                            
                        </form>

                    </div>

        
                    <div class="product-collateral row nova-mg-pd">
                  
                        <h2 style="border-bottom: 3px solid #DFDFDF; margin-bottom: 25px;">Products of the Series</h2>    
                        <div>
                            <div class="series-products">
                                <div class="products-grid row list-3col-4 nova-mg-pd" style="padding-bottom: 10px;">

                                <?php foreach ($series as $v): ?>
                                    <div class="item col-md-3 nova-mg-pd">
                                        <div class="nova-product-images"> 
                                            <div class="margin-image">
                                                <a href="<?=url(['/home/product/view', 'id'=>$v['id']])?>" title="<?=$v['name']?>" class="product-image">
                                                <img src="<?=$v['img']?>" alt="<?=$v['name']?>">
                                                </a>
                                            </div>
                                        </div>
                                        <h3 class="product-name"><?=$v['name']?></h3>
                                    </div> 
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
    </div>
</div>

<?php $this->beginBlock('zoom') ?>  
jQuery(document).ready(function() {

    zoom();
    $('.list-h img').mouseover(function(){
        var src = $(this).attr('src');
        var dsrc = $(this).data('src');

        $('#zoom_01').attr('src', src);
        $('#zoom_01').attr('data-image', dsrc);
        zoom();

    });

    jQuery().UItoTop({ easingType: 'easeOutQuart' });    

});  


var zoom = function(){
    $('#zoom_01').elevateZoom({
    zoomType: "inner",
    cursor: "crosshair",
    zoomWindowFadeIn: 500,
    zoomWindowFadeOut: 750
   }); 
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['zoom'], \yii\web\View::POS_END); ?>  

