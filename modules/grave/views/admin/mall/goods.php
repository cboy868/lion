<?php 
use yii\widgets\LinkPager;
?>

<table class="table table-condensed" id="">
        <tbody>
            <?php 
                foreach($models as $goods):
                $sku_cnt = count($goods->sku);
            ?>
            <tr width="50%" 
                data-id="<?=$goods->id?>" 
                data-title="<?=$goods->name?>" 
                data-price="<?=$goods->price?>" 
                data-img="<?=$goods->getThumb('110x110')?>"
                class="g<?=$goods->id?>"
                >
                <td>
                    <a href="#">
                      <img class="media-object" src="<?=$goods->getThumb('50x50')?>" alt="..." width="50" height="50">
                    </a>
                </td>
                <td>
                    <?=$goods->name?><br>
                    <?php if ($sku_cnt > 1): ?>
                         <p>
                            <select name="sku_id" class="form-control sku sku_id" style="max-width:120px;">
                                <?php foreach ($goods->sku as $k => $sku): ?>
                                    <option value="<?=$sku->id?>"><?=$sku->name?> <?=$sku->price?></option>
                                <?php endforeach ?>
                            </select>
                        </p>
                    <?php else: ?>
                        <?=$goods->sku[0]->name?> <?=$goods->sku[0]->price?>
                        <input name="sku_id" type="hidden" value="<?=$goods->sku[0]->id?>" class="sku_id" sku-name="<?=$goods->sku[0]->name?>"/>
                    <?php endif ?>
                </td>
                <td width="120">
                    <div class="text-right goods-sel-btn">

                        <div class="input-group">
                            <span class="input-group-btn">
                            <button class="btn btn-default btn-sub" type="button"><span class="fa fa-minus"></span></button>
                          </span>
                          <input type="text" class="form-control gnum" value="0">
                          <span class="input-group-btn">
                            <button class="btn btn-default btn-add" type="button"><span class="fa fa-plus"></span></button>
                          </span>
                        </div><!-- /input-group -->

                       <!--  <button class="btn-sub btn btn-xs btn-default" ><span class="fa fa-minus"></span></button>
                        <input class="goods-num" style="" type="text" value="0" size="3" />
                        <button class="btn-add btn btn-xs btn-default"><span class="fa fa-plus"></span></button> -->
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
</table>


<div class="row">
    <div class="col-sm-12" style="text-align: right;">
<?php 
echo LinkPager::widget([
    'pagination' => $pagination,
]);
 ?>
    </div>
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

