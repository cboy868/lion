<table class="table table-bordered table-condensed">
    <caption class="red text-left"><strong>今 日 订 餐 [ <?=$date?> ]</strong></caption>
    <thead>
    <tr>
        <th>食堂</th>
        <th>类型</th>
        <th>菜品</th>
        <th>数量</th>
        <th>单价</th>
        <th>合计</th>
    </tr>
    </thead>
    <tbody>
    <div class="order-list">
        <?php $total=0;foreach ($self_menus as $m):?>
            <tr class="<?=$m->id?>">
                <td><?=$m->mess->name?></td>
                <td><?=$types[$m->type]?></td>
                <td class="blue"><?=$m->menu->name?></td>
                <td class="green"><?=$m->num?></td>
                <td class="red"><?=$m->real_price?></td>
                <td><?php echo $m->num * $m->real_price?></td>
            </tr>

            <?php $total+=$m->num*$m->real_price;endforeach;?>
    </div>
    <tr>
        <td colspan="5">合 计</td>
        <td><code>¥<?=$total?></code></td>
    </tr>
    </tbody>
</table>