<?php 

use yii\helpers\Url;
use app\core\models\Attachment;
use yii\widgets\LinkPager;

use app\web\theme\site\widgets\GoodsList;

$this->title = 'PRODUCTS';
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

                    <?=GoodsList::widget() ?>

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





