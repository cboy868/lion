<?php 
use yii\widgets\LinkPager;


?>
<style type="text/css">
    .pagination{
        margin: 0;
    }
</style>
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>商品名</th>
            <th>类别</th>
            <th>首拼</th>
            <th>库存</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $k => $v): ?>
        
        <tr>
            <td><?=$v->name?></td>
            <td><?=$v->category->name?></td>
            <td><?=$v->pinyin?></td>
            <td>
            <?php if (count($v->sku)>1): ?>
                <table class="table table-condensed">
                <?php foreach ($v->sku as $sv): ?>
                    <tr>
                        <td>
                        <?=$sv->name?>(<?=$sv->num?>)
                        <a href="#" class="btn btn-primary btn-sm pull-right instor" 
                            data-sku_id="<?=$sv->id?>" 
                            data-gid="<?=$v->id?>"
                            data-unit="<?=$v->unit?>"
                            data-name="<?=$v->name . $sv->name?>">入库此规格</a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </table>
            <?php else: ?>
                <?=$v->sku[0]->name?>(<?=$v->num?>)
                <a href="#" class="btn btn-primary pull-right instor btn-sm" 
                    data-sku_id="<?=$v->sku[0]->id?>" 
                    data-gid="<?=$v->id?>"
                    data-unit="<?=$v->unit?>"
                    data-name="<?=$v->name?>">入库此商品</a>
            <?php endif ?>
            </td>
        </tr>
        
    <?php endforeach ?>
        
        
        <tr>
            <td colspan="5" style="text-align: right;">
<?php 
echo LinkPager::widget([
    'pagination' => $pagination,
]);
 ?>
            </td>
        </tr>
    </tbody>
</table>
