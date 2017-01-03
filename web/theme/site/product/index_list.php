<?php 

use yii\helpers\Url;
use app\core\models\Attachment;
use yii\widgets\LinkPager;

?>

<style type="text/css">
    .limiter ul a{
        display: inline-block;
        width: 100%;
    }
    .limiter ul a:hover{
        background-color: #ddd;
    }
</style>

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
                            <?php foreach ($attrs as $attr): ?>
                                <dt id="filterlabel<?=$attr['id']?>" class="odd"><?=$attr['name']?></dt>
                                 <dd class="odd" style="display: none;">
                                    <ol>
                                    <?php foreach ($attr['child'] as $val): ?>
                                        <li style="margin-top:4px;line-height:22px;"><a href="<?=url(['index', 'avid'=>$val['id']])?>" vid="<?=$val['id']?>"><?=$val['val']?> (<?=$val['num']?>)</a></li>
                                    <?php endforeach ?>
                                    </ol>
                                </dd>
                            <?php endforeach ?>
                        </dl>
                    </div>
                </div>
                                        
                <!-- <div class="block block-list block-compare">
                    <div class="block-title active" id="block-compare">
                        <strong><span>Compare Products                    </span></strong>
                    </div>
                    <div class="block-content">
                            <p class="empty">You have no items to compare.</p>
                        </div>
                </div> -->
            </div>
            <div class="col-main col-md-9 nova-mg-pd">
                <ol class="breadcrumb" style="margin-bottom:0;text-align:left;padding:8px 5px 8px 0px;margin:0;border-bottom: 1px solid #ccc;background-color: #fff;border-radius:0">
                  <li><a href="<?=url(['/'])?>">HOME</a></li>
                  <li class="active">PRODUCTS</li>
                </ol>
               <!--  <div class="page-title category-title">
                    <h1>Products</h1>
                </div>
                <p></p>  --> 
                <div class="category-products">
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


                    <ol id="products-list" class="products-list nova-mg-pd">

                        <?php foreach ($models as $goods): ?>
                        <li class="item odd">
                            <div class="col-md-4 nova-mg-pd">
                                <div class="products-list-inner">
                                    <div class="nova-product-images">            
                                        <a href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="product-image">
                                            <img src="<?=Attachment::getById($goods['thumb'], '310x310')?>" alt="<?=$goods['name']?>">
                                        </a>   
                                    </div>          
                                </div>
                            </div>
                            <div class="col-md-8 nova-mg-pd">
                                <div class="product-shop" style="margin-left:0">
                                    <div class="f-fix">
                                        <h2 class="product-name"><a href="<?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>"><?=$goods['name']?></a></h2>
                                        <div class="price-box">
                                            <p class="minimal-price">
                                                <span class="price-label">Starting at:</span>
                                                <span class="price" id="product-minimal-price-1490">$<?=$goods['price']?></span>
                                            </p>
                                        </div>
                                        <div class="desc std">
                                        <?=$goods['intro']?>
                                            <a href="?=Url::toRoute(['product/view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="link-learn">Learn More</a>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach ?>
                    </ol>

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

<?php $this->beginBlock('slide') ?>  
jQuery(document).ready(function() {
    $('#narrow-by-list dt').click(function(){
        if ($(this).hasClass('active')) {
            jQuery(this).removeClass('active').next().slideUp(200);
        } else {
            jQuery(this).addClass('active').next().slideDown(200);
        }
    });


    $('.limiter .current').click(function(){
        $(this).siblings('ul').show();
    });

    $('.limiter').mouseleave(function(){
        $(this).find('ul').slideUp();
    });

});  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['slide'], \yii\web\View::POS_END); ?>  





