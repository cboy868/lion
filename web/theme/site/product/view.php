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
</style>


<div class="main-container col1-layout home-content-container">
    <ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
      <li><a href="#">Home</a></li>
      <li><a href="#">About Us</a></li>
      <li class="active">Data</li>
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
                                            <img id="zoom_01" src='/theme/site/static/img/rs_tn2big.jpg' data-image="/theme/site/static/img/rs_tn1big.jpg" height="350" width="425" />
                                        </div>
                                        <div id='spec-n5'>
                                            <div class=control id='spec-left'>
                                                <img src="/theme/site/static/elevatezoom/images/left.gif" />
                                            </div>
                                            <div id='spec-list'>
                                                <ul class='list-h'>
                                                    <li><img src="/theme/site/static/img/rs_tn1big.jpg" data-src="/theme/site/static/img/rs_tn1big.jpg"> </li>
                                                    <li><img src="/theme/site/static/img/rs_tn1big.jpg" data-src="./theme/site/static/img/rs_tn1big.jpg"> </li>
                                                    <li><img src="/theme/site/static/img/rs_tn2big.jpg" data-src="/theme/site/static/img/rs_tn2big.jpg"> </li>
                                                    <li><img src="/theme/site/static/img/rs_tn1big.jpg" data-src="/theme/site/static/img/rs_tn1big.jpg"> </li>
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
                                            <h1>Absolute</h1>
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
                                                <div class="short-description">
                                                    <div class="std">Rediscover the timeless beauty of limestone featured in Absolute. This new series brings the best out of sedimentary stone and fuses it with a robust modern multi-stone look. Its versatile 4 color tones are matched by the 18x36 format that allows for more dynamic installation schemes and color combinations. The beauty of absolute can be enjoyed in a commercial or residential setting on both wall and floor applications.</div>
                                                </div>
                                                <div class="add-to-box">
                                                     <div class="add-to-cart"></div>
                                                    <div class="add-to-link">
                                                            <ul class="add-to-links">
                                                                <li><a href="/wishlist/index/add/product/1842/form_key/O3Ev1u7AqQrYh5rm/" onclick="productAddToCartForm.submitLight(this, this.href); return false;" class="link-wishlist"><i class="icon-wishlist"></i></a></li>
                                                                        <li><a href="/catalog/product_compare/add/product/1842/uenc/aHR0cDovL3d3dy5lbGVnYW56YXRpbGVzLmNvbS9wcm9kdWN0LXNlcmllcy9wb3JjZWxhaW4vYWJzb2x1dGUuaHRtbA,,/form_key/O3Ev1u7AqQrYh5rm/" class="link-compare"><i class="icon-compare"></i></a></li>
                                                        
                                                        
                                                        </ul> 
                                                    </div>                                                                                                                                                      
                                                </div>
                                                <div class="nova-detail-link">
                                                    <ul>
                                                        <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=/product-series/porcelain/absolute.html&amp;images=/media/catalog/product/cache/1/small_image/310x310/9df78eab33525d08d6e5fb8d27136e95/a/b/absolute_tn_1.jpg" target="_blank" title="Share on Facebook"><i class="icon-facebook-4"></i></a></li>
                                                        <li class="twitter"><a href="https://twitter.com/share?url=/product-series/porcelain/absolute.html" target="_blank" title="Share on Twitter"><i class="icon-twitter"></i></a></li>
                                                        <li class="mail"><a href="/sendfriend/product/send/id/1842/cat_id/163/" title="Email to a Friend"><i class="icon-mail"></i></a></li>
                                                        <li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=/product-series/porcelain/absolute.html&amp;media=/media/catalog/product/cache/1/small_image/310x310/9df78eab33525d08d6e5fb8d27136e95/a/b/absolute_tn_1.jpg&amp;description=Absolute" target="_blank" title="Pin on Pinterest"><i class="icon-pinterest-3"></i></a></li>
                                                    </ul>
                                                </div>
                                                                    
                                                <div class="mainDiv">
                                                    <h3 style="padding-bottom: .8em;">Download(s):</h3>
                                                    <table>
                                                    <tbody><tr><td class="fileImageDiv" style="height:75px; padding-right: 10px;"><a href="/files/index/download/id/1465939724/" target="_Blank"><img src="/theme/site/static/img/pdf.png" alt="pdf" style="height:75px; width=90px;"></a></td><td class="fileTitleDiv" style="height:75px;"><b><a href="/files/index/download/id/1465939724/" target="_Blank">Absolute Tear Sheet</a></b></td></tr>              </tbody></table>
                                                </div>
                                          </div>

                                          <div role="tabpanel" class="tab-pane" id="profile">
                                                <table class="data-table" id="product-attribute-specs-table" style="display: block; height: 490px; overflow-y: scroll;">
                                                    <colgroup><col width="40%">
                                                    <col>
                                                    </colgroup>
                                                    <tbody>
                                                        <tr class="first odd">
                                                            <th class="label">
                                                                                                SKU                                    </th>
                                                            <td class="data last" style="vertical-align: middle;">
                                                                absolute_series                </td>
                                                        </tr>
                                                                <tr class="even">
                                                            <th class="label">
                                                                                            <img src="/theme/site/static/img/look.png" alt="Look " style="height: 18px; vertical-align: middle; padding-right:5px;">
                                                                        <span style="vertical-align: middle;">Look </span>
                                                                                </th>
                                                            <td class="data last" style="vertical-align: middle;">
                                                                Limestone                </td>
                                                        </tr>
                                                                <tr class="odd">
                                                            <th class="label">
                                                                                            <img src="/theme/site/static/img/variation.png" alt="Color Variation" style="height: 18px; vertical-align: middle; padding-right:5px;">
                                                                        <span style="vertical-align: middle;">Color Variation</span>
                                                                                </th>
                                                            <td class="data last" style="vertical-align: middle;">
                                                                2                </td>
                                                        </tr>
                                                                <tr class="even">
                                                            <th class="label">
                                                                                            <img src="/theme/site/static/img/edge.png" alt="Edge Finish" style="height: 18px; vertical-align: middle; padding-right:5px;">
                                                                        <span style="vertical-align: middle;">Edge Finish</span>
                                                                                </th>
                                                            <td class="data last" style="vertical-align: middle;">
                                                                Rectified                 </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                          </div>
                                          <div role="tabpanel" class="tab-pane" id="messages">
                                                Each installation recommendation, or method, requires a properly designed, constructed, and prepared substructure using materials and construction techniques that meet nationally recognized material and construction standards. Prior to installing any ceramic or porcelain tiles, please refer to written guidelines detailed in the current TCNA Handbook for Ceramic, Glass and Stone Tile Installation                          
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
                                    <div class="item col-md-3 nova-mg-pd">
                                        <div class="nova-product-images"> 
                                            <div class="margin-image">
                                                <a href="/catalog/product/view/id/1911/s/absolute-milk-18x36/category/163/" title="Absolute - Cenere 18x36" class="product-image">
                                                <img src="/theme/site/static/img/cenere_1.jpg" alt="Absolute - Cenere 18x36">
                                                </a>
                                            </div>
                                            <div class="descriptions-hidden">       
                                                <div class="quick-whl"> 
                                                            
                                                    <a title="Wishlist" class="add_to_wishlist_small button-ajax-wishlist-id-1911" href="/wishlist/index/add/product/1911/form_key/O3Ev1u7AqQrYh5rm/" data-id="1911"><i class="icon-wishlist"></i></a> 

                                                    <a title="Compare" class="add_to_compare_small button-ajax-compare-id-1911" href="/catalog/product_compare/add/product/1911/uenc/aHR0cDovL3d3dy5lbGVnYW56YXRpbGVzLmNvbS9wcm9kdWN0LXNlcmllcy9wb3JjZWxhaW4vYWJzb2x1dGUuaHRtbA,,/form_key/O3Ev1u7AqQrYh5rm/" data-id="1911"><i class="icon-compare"></i></a> 
                                             
                                                    <div class="quickview-box">
                                                        <a class="quickview_small" href="/ajax/index/quickview/product_id/1911/" data-id="1911"><i class="icon-search"></i></a> 
                                                    </div> 
                                                </div>  
                                            </div>
                                        </div>
                                        <h3 class="product-name">Absolute - Cenere 18x36</h3>
                                        <div style="font-size:0.9em; padding-bottom: 25px;">SKU: YI459SM3306</div>
                                    </div>        
                                    <div class="item col-md-3 nova-mg-pd">
                                        <div class="nova-product-images"> 
                                                         
                                            <div class="margin-image">
                                                <a href="/catalog/product/view/id/1910/s/absolute-milk-18x36/category/163/" title="Absolute - Nut 18x36" class="product-image">
                                                <img src="/theme/site/static/img/nut_2.jpg" alt="Absolute - Nut 18x36">
                                                </a>
                                            </div>
                                                                           

                                            <div class="descriptions-hidden">       
                                                    
                                                <div class="quick-whl"> 
                                                            
                                                <a title="Wishlist" class="add_to_wishlist_small button-ajax-wishlist-id-1910" href="/wishlist/index/add/product/1910/form_key/O3Ev1u7AqQrYh5rm/" data-id="1910"><i class="icon-wishlist"></i></a> 
                         
                                                <a title="Compare" class="add_to_compare_small button-ajax-compare-id-1910" href="/catalog/product_compare/add/product/1910/uenc/aHR0cDovL3d3dy5lbGVnYW56YXRpbGVzLmNvbS9wcm9kdWN0LXNlcmllcy9wb3JjZWxhaW4vYWJzb2x1dGUuaHRtbA,,/form_key/O3Ev1u7AqQrYh5rm/" data-id="1910"><i class="icon-compare"></i></a> 
                                                                     
                                                <div class="quickview-box">
                                                        <a class="quickview_small" href="/ajax/index/quickview/product_id/1910/" data-id="1910"><i class="icon-search"></i></a> 
                                                    </div> 
                                                </div>  
                                                                
                                            </div>
                                        </div>
                                        <h3 class="product-name">Absolute - Nut 18x36</h3>
                                        <div style="font-size:0.9em; padding-bottom: 25px;">SKU: YI459SM3305</div>
                                    </div>        
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
        $('#zoom_01').attr('src', src);
        var dsrc = $(this).data('src');
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

