<?php 

use yii\helpers\Url;
use app\core\models\Attachment;
use yii\widgets\LinkPager;

use app\assets\TooltipAsset;

TooltipAsset::register($this);
?>
<style type="text/css"> 
* { 
padding:0; 
margin:0; 
} 
body { 
font-family:verdana, sans-serif; 
font-size:small; 
} 
#navigation, #navigation li ul { 
list-style-type:none; 
} 
#navigation { 
margin:20px; 
} 
#navigation li { 
float:left; 
text-align:center; 
position:relative; 
} 
#navigation li a:link, #navigation li a:visited { 
display:block; 
text-decoration:none; 
color:#000; 
width:120px; 
height:40px; 
line-height:40px; 
border:1px solid #fff; 
border-width:1px 1px 0 0; 
background:#c5dbf2; 
padding-left:10px; 
} 
#navigation li a:hover { 
color:#fff; 
background:#2687eb; 
} 
#navigation li ul li a:hover { 
color:#fff; 
background:#6b839c; 
} 
#navigation li ul { 
display:none; 
position:absolute; 
top:40px; 
left:0; 
margin-top:1px; 
width:120px; 
} 
#navigation li ul li ul { 
display:none; 
position:absolute; 
top:0px; 
left:130px; 
margin-top:0; 
margin-left:1px; 
width:120px; 
} 
</style> 
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


        <ul class="navigation">

            <li onmouseover="displaySubMenu(this)" onmouseout="hideSubMenu(this)"> 
                <a href="#">栏目1</a> 
                <ul> 
                <li><a href="#">栏目1->菜单1</a></li> 
                <li><a href="#">栏目1->菜单2</a></li> 
                <li><a href="#">栏目1->菜单3</a></li> 
                <li><a href="#">栏目1->菜单4</a></li> 
                </ul> 
            </li> 



        <li class="limiter">Show<span class="current"><span><?=$get['psize']?></span></span>
            <ul>
                <li><a class="<?php if ($get['psize'] == 8): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>8])?>">8</a></li>
                <li><a class="<?php if ($get['psize'] == 12): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>12])?>">12</a></li>
                <li><a class="<?php if ($get['psize'] == 16): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>16])?>">16</a></li>
                <li><a class="<?php if ($get['psize'] == 20): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>20])?>">20</a></li>
                <li><a class="<?php if ($get['psize'] == 24): ?>active<?php endif ?>" href="<?=Url::current(['psize'=>24])?>">24</a></li>
            </ul> per page        
        </li>
        </ul>

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
                    <a href="<?=Url::toRoute(['product-view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="product-image">
                        <img src="<?=Attachment::getById($goods['thumb'], '310x310')?>" alt="<?=$goods['name']?>">
                    </a>   
                </div>          
            </div>
        </div>
        <div class="col-md-8 nova-mg-pd">
            <div class="product-shop" style="margin-left:0">
                <div class="f-fix">
                    <h2 class="product-name"><a href="<?=Url::toRoute(['product-view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>"><?=$goods['name']?></a></h2>
                    <div class="price-box">
                        <p class="minimal-price">
                            <span class="price-label">Starting at:</span>
                            <span class="price">$<?=$goods['price']?></span>
                        </p>
                    </div>
                    <div class="desc std">
                    <?=$goods['intro']?>
                        <!-- <a href="?=Url::toRoute(['product-view', 'id'=>$goods['id']])?>" title="<?=$goods['name']?>" class="link-learn">Learn More</a> -->
                    </div>                                      
                </div>
            </div>

            <div class="act-box">                   
                <ul class="add-to-links">
                    <li>
                    <!-- <a href="<?=Url::toRoute(['product-view', 'id'=>$goods['id']])?>" class="link-wishlist add_to_wishlist_small fav" data-res="goods" data-id="<?=$goods['id']?>" title="<?=$goods['name']?>"><i class="fa fa-heart"></i></a> -->
                    <a href="<?=Url::toRoute(['product-msg','id'=>$goods['id']])?>" style="font-size: 20px;background: #eee;padding: 10px 5px;" target="_blank">留言咨询</a>
                    </li>
            </ul>
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



<?php $this->beginBlock('fav') ?> 




$(function(){
    $('.fav').click(function(e){
        e.preventDefault();

        var res_name = $(this).data('res');
        var res_id = $(this).data('id');
        var title = $(this).attr('title');
        var res_url = $(this).attr('href');
        var _csrf = $('meta[name=csrf-token]').attr('content');
        var url = "<?php echo Url::toRoute(['/member/default/favor'])?>";

        var favObj = $(this);
        var data = {res_name:res_name,res_id:res_id,title:title,res_url:res_url,_csrf:_csrf};

        $.post(url, data, function(xhr){
            if (xhr.status) {
                favObj.tooltipster({})
                .tooltipster('content', xhr.info)
                .tooltipster('open');

            } else {
                favObj.tooltipster({})
                .tooltipster('content', xhr.info)
                .tooltipster('open');
            }
        },'json');


    });
})  



<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['fav'], \yii\web\View::POS_END); ?>  