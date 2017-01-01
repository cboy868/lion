<?php 

use yii\helpers\Url;
use app\core\models\Attachment;
use yii\widgets\LinkPager;

?>
<div class="main-container col2-left-layout">
    <div class="main">
        <div class="row columns-layout nova-mg-pd">
            <div class="col-left sidebar col-md-3 nova-mg-pd">
                <div class="block left-categories">
                    <div class="block-title"><span>Products</span></div>
                    <div class="block-content left-categories-container">
                    <ul>
                        <?php foreach ($cates as $cate): ?>
                            <li><a href="<?=$cate['url']?>"><?=$cate['name']?></a></li>
                        <?php endforeach ?>
                    </ul>
                    </div>
                </div>


                <div class="block block-layered-nav">
                    <div class="block-title active" id="block-layered-nav">
                        <strong><span>Products Filter By</span></strong>
                    </div>
                    <div class="block-content">
                        <dl id="narrow-by-list">
                            <dt id="filterlabel2" class="odd">Area</dt>
                             <dd class="odd" style="display: none;">
                                <ol>
                                    <li><a href="#">pending</a>(1)</li>
                                    <li><a href="#">Indoor</a>(89)</li>
                                            
                                </ol>
                            </dd>
                                                                                  
                            <dt id="filterlabel3" class="even">Build Type</dt>
                            <dd class="even" style="display: none;">
                                <ol>
                                    <li><a href="#">Commercial (Wall Only)</a>(5)</li>
                                    <li><a href="#">pending</a>(1)</li>
                                </ol>
                            </dd>
                        </dl>
                    </div>
                </div>
                                        
                <div class="block block-list block-compare">
                    <div class="block-title active" id="block-compare">
                        <strong><span>Compare Products                    </span></strong>
                    </div>
                    <div class="block-content">
                            <p class="empty">You have no items to compare.</p>
                        </div>
                </div>
            </div>
            <div class="col-main col-md-9 nova-mg-pd">
                <ol class="breadcrumb" style="margin-bottom:0;text-align:left;padding:8px 5px 8px 0px;margin:0;border-bottom: 1px solid #ccc;background-color: #fff;border-radius:0">
                  <li><a href="<?=url(['/'])?>">Home</a></li>
                  <li class="active">products</li>
                </ol>
               <!--  <div class="page-title category-title">
                    <h1>Products</h1>
                </div>
                <p></p>  --> 
                <div class="category-products">
                    <!-- <div class="toolbar">
                        <div class="sorter"> -->
                           <!--  <div class="sort-by">
                                <span class="current"><span>Name</span></span>
                                <ul>
                                  <li><a href="#">Position</a></li>
                                  <li><a class="active" href="#">Name</a></li>
                                </ul>        
                            </div>   --> 
                           <!--  <div class="direction">
                                <a href="#" title="Set Descending Direction"><img src="/theme/site/static/img/i_asc_arrow.png" alt="Set Descending Direction" class="v-middle"></a>
                            </div>           
                            <p class="view-mode">
                                <strong title="Grid" class="grid">Grid</strong>&nbsp;
                                <a href="#" title="List" class="list">List</a>&nbsp;
                            </p> -->

                            




                           <!--  <div class="limiter">Show<span class="current"><span>8</span></span>
                                <ul>
                                    <li><a class="active" href="#">8</a></li>
                                    <li><a href="#">12</a></li>
                                    <li><a href="#">16</a></li>
                                    <li><a href="#">20</a></li>
                                    <li><a href="#">24</a></li>
                                </ul> per page        
                            </div> -->
                
                           <!--  <div class="pages">
                                <ol>
                                    <li class="current"><span>1</span></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a class="next i-next" href="#" title="Next">Next<i class="icon-right-open-3"></i></a></li>
                                </ol>
                            </div> -->
                        <!-- </div>
                    </div> -->


                    <div class="products-grid row list-2col-4 nova-mg-pd">

                    <?php foreach ($models as $goods): ?>
                        <div class="item col-md-3 nova-mg-pd">
                            <div class="nova-product-images"> 
                                <a href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="product-image">
                                    <div class="margin-image"><img src="<?=Attachment::getById($goods['thumb'], '186x186')?>" alt="<?=$goods['name']?>"></div>
                                </a>
                                <div class="descriptions-hidden">       
                                    <div class="quick-whl"> 
                                        <a title="Wishlist" class="add_to_wishlist_small " href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" data-id="<?=$goods['id']?>"><i class="icon-wishlist"></i></a> 
                                        <a title="Compare" class="add_to_compare_small" href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" data-id="<?=$goods['id']?>"><i class="icon-compare"></i></a> 
                                        <div class="quickview-box">
                                        <a class="quickview_small" href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" data-id="<?=$goods['id']?>"><i class="icon-search"></i></a> 
                                        </div> 
                                    </div>  
                                </div>
                            </div>
                            <h3 class="product-name"><a href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>"><?=$goods['name']?></a></h3>

                            <div class="price-box">
                                <p class="minimal-price">
                                    <span class="price-label">Starting at:</span>
                                    <span class="price" id="product-minimal-price-<?=$goods['id']?>">$<?=$goods['price']?></span>
                                </p>
                            </div>
                             <div class="rating-product-box"></div>
                        </div>
                    <?php endforeach ?>
                    </div>


                <div class="toolbar-bottom">
                    <div class="toolbar">
                        <div class="sorter">
                            <div class="pages">
                            <?php 
                                echo LinkPager::widget([
                                    'pagination' => $page,
                                ]);     
                             ?>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>






