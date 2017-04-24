<?php 
use yii\widgets\LinkPager;


?>
<style type="text/css">
    .pagination{
        margin: 0;
    }
</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>商品名</th>
            <th>类别</th>
            <th>首拼</th>
            <th>规格</th>
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
                        <td><?=$sv->name?>(<?=$sv->num?>)</td>
                    </tr>
                <?php endforeach ?>
                </table>
            <?php else: ?>

            <?php endif ?>
            </td>
            <td><?=$v->num?></td>
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
