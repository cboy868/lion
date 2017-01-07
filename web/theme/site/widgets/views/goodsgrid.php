<?php 

use yii\helpers\Url;
use app\core\models\Attachment;
use yii\widgets\LinkPager;
?>

<div class="toolbar">
    <div class="sorter">
        <!-- <div class="sort-by">
            <span class="current"><span>Name</span></span>
            <ul>
              <li><a href="#">Position</a></li>
              <li><a class="active" href="#">Name</a></li>
            </ul>        
        </div>   --> 
        <!-- <div class="direction">
            <a href="#" title="Set Descending Direction"><img src="/theme/site/static/img/i_asc_arrow.png" alt="Set Descending Direction" class="v-middle"></a>
        </div> -->           
        <p class="view-mode">

            <?php if ($get['mode'] == 'list'): ?>
                <a href="<?=Url::current(['mode'=>'grid'])?>" title="Grid" class="grid">Grid</a>&nbsp;
                <strong title="List" class="list">List</strong>&nbsp;
            <?php else: ?>
                <strong title="Grid" class="grid">Grid</strong>&nbsp;
                <a href="<?=Url::current(['mode'=>'list'])?>" title="List" class="list">List</a>&nbsp;
            <?php endif ?>
            
        </p>


        <div class="limiter">Show<span class="current"><span><?=$get['psize']?></span></span>
            <ul>
                <li><a class="<?php if ($get['psize'] == 8): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>8])?>">8</a></li>
                <li><a class="<?php if ($get['psize'] == 12): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>12])?>">12</a></li>
                <li><a class="<?php if ($get['psize'] == 16): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>16])?>">16</a></li>
                <li><a class="<?php if ($get['psize'] == 20): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>20])?>">20</a></li>
                <li><a class="<?php if ($get['psize'] == 24): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>24])?>">24</a></li>
            </ul> per page        
        </div>

        <div class="pages">
            <ol>
                <li class="current"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a class="next i-next" href="#" title="Next">Next<i class="icon-right-open-3"></i></a></li>
            </ol>
        </div>
    </div>
</div>
<div class="products-grid row list-2col-4 nova-mg-pd">
    <?php foreach ($models as $goods): ?>
        <div class="item col-md-3 nova-mg-pd">
            <div class="nova-product-images"> 
                <a href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="product-image">
                    <div class="margin-image"><img src="<?=Attachment::getById($goods['thumb'], '310x310')?>" alt="<?=$goods['name']?>"></div>
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