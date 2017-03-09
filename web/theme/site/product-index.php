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
    .left-categories-container ul li a{
        width: 80%;
        display: inline-block;
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
                                <?php if (isset($cate['child'])): ?>
                                    <li class="down">
                                        <a href="#"><?=$cate['name']?></a> 
                                        <span style="float:right;padding-right: 5px;padding-top: 2px;" class="fa fa-caret-up fa-2x"></span>
                                         <ul style="display:block;">
                                            <?php foreach ($cate['child'] as $ct): ?>
                                            <li class="leaf"><a href="<?=$ct['url']?>"><?=$ct['name']?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li class="leaf"><a href="<?=$cate['url']?>"><?=$cate['name']?></a></li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>

                <div class="block block-layered-nav">
                    <div class="block-title active" id="block-layered-nav">
                        <strong><span>
                            <a href="<?=Url::toRoute(['product'])?>"> Products Filter By</a>
                       </span>
                        </strong>
                    </div>
                    <div class="block-content">
                        <dl id="narrow-by-list">
                        <?php 
                            $avid = Yii::$app->request->get('avid');
                            if (strstr($avid, ',')) {
                                $avids = explode(',', $avid);
                            } else {
                                $avids = [$avid];
                            }
                         ?>
                            <?php foreach ($attrs as $attr): ?>
                                <dt id="filterlabel<?=$attr['id']?>" class="odd active"><?=$attr['name']?></dt>
                                 <dd class="odd" style="display: block;">
                                    <ol>
                                    
                                    <?php foreach ($attr['child'] as $val): ?>
                                        <li style="margin-top:4px;line-height:22px;">

                                        <?php 

                                        $tmp = $avids;

                                        foreach ($tmp as $k => $v) {
                                            if (array_key_exists($v, $attr['child'])) {
                                                unset($tmp[$k]);
                                            }
                                        }
                                        array_push($tmp, $val['id']);
                                        $str = trim(implode(',', $tmp), ',');


                                         ?>

                                        <a href="<?=url(['product', 'avid'=>$str])?>" vid="<?=$val['id']?>"><?=$val['val']?> (<?=$val['num']?>)</a>
                                        </li>
                                    <?php endforeach ?>
                                    </ol>
                                </dd>
                            <?php endforeach ?>
                        </dl>
                    </div>
                </div>
                                        
            </div>
            <div class="col-main col-md-9 nova-mg-pd">
                <ol class="breadcrumb" style="margin-bottom:0;text-align:left;padding:8px 5px 8px 0px;margin:0;border-bottom: 1px solid #ccc;background-color: #fff;border-radius:0">
                  <li><a href="<?=url(['/'])?>">HOME</a></li>
                  <li class="active">PRODUCTS</li>
                </ol>
                <div class="category-products">

                    <?=GoodsList::widget() ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('slide') ?>  
jQuery(document).ready(function() {


    $('.left-categories-container ul li.leaf').mouseover(function(){
        $(this).css('background-color', '#fed');
    });
    $('.left-categories-container ul li.leaf').mouseleave(function(){
        $(this).css('background-color', 'white');
    });

    $('#narrow-by-list dt').click(function(){
        if ($(this).hasClass('active')) {
            jQuery(this).removeClass('active').next().slideUp(200);
        } else {
            jQuery(this).addClass('active').next().slideDown(200);
        }
    });


    $('.limiter1 .current').mouseover(function(){
        $(this).siblings('ul').show();
    });

    $('.limiter1').mouseleave(function(){
        $(this).find('ul').slideUp();
        console.log('leave');
    });

    $('.down').click(function(e){
        if (e.target.tagName == 'A' && $(e.target).attr('href')!='#'){
            return ;
        }
        e.preventDefault();
        if ($(this).find('span').hasClass('fa-caret-up')) {
            $(this).find('ul').slideUp();
            $(this).find('span').removeClass('fa-caret-up').addClass('fa-caret-down');
        } else {
            $(this).find('ul').slideDown();
            $(this).find('span').removeClass('fa-caret-down').addClass('fa-caret-up');
        }
        
    });

});  

function displaySubMenu(li) { 
var subMenu = li.getElementsByTagName("ul")[0]; 
subMenu.style.display = "block"; 
} 
function hideSubMenu(li) { 
var subMenu = li.getElementsByTagName("ul")[0]; 
subMenu.style.display = "none"; 
} 
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['slide'], \yii\web\View::POS_END); ?>  





