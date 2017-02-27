<?php 
use yii\widgets\LinkPager;
?>
<div class="row">
    <?php foreach($models as $goods):?>
    <?php 

        $sku_cnt = count($goods->sku);

    ?>
    <div class="col-sm-4 goods-item" data-id="<?=$goods->id?>" data-title="<?=$goods->name?>" data-price="<?=$goods->price?>" data-img="<?=$goods->getThumb('110x110')?>" >
         <div class="media">
              <div class="media-left media-middle">
                <a href="#">
                  <img class="media-object" src="<?=$goods->getThumb('110x110')?>" alt="..." width="110" height="110">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading"><small class="text-primary"><strong><?=$goods->name?></strong></small></h4>
                <p>
                    <small>价格:<code>¥<?=$goods->price?>元</code></small>
                </p>
                <?php if ($sku_cnt > 1): ?>
                     <p>
                        <select name="sku_id" class="form-control sku" style="max-width:120px;">
                            <?php foreach ($goods->sku as $k => $sku): ?>
                                <option value="<?=$sku->id?>"><?=$sku->name?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                <?php endif ?>
                    <input name="sku_id" type="hidden" value="<?=$goods->sku[0]->id?>" class="sku_id" sku-name="<?=$goods->sku[0]->name?>"/>

                    <div class="text-left goods-sel-btn">
                        <button class="btn-sub btn btn-xs btn-default" ><span class="fa fa-minus"></span></button>
                        <input class="goods-num" style="" type="text" value="0" size="3" />
                        <button class="btn-add btn btn-xs btn-default"><span class="fa fa-plus"></span></button>
                    </div>
              </div>
            </div>
    </div>
    <?php endforeach;?>

</div>


<?php $this->beginBlock('page') ?>  
$(function(){
    $('div.goods-item').mouseover(function(e){
        $(this).css({'border-color':'#e1e1e1', 'background-color':'#FCF8E3'})
    });
    $('div.goods-item').mouseout(function(e){
        $(this).css({'border-color':'white', 'background-color':'white'})
    });

});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['page'], \yii\web\View::POS_END); ?>  

