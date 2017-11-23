<table class="table table-bordered table-striped">
    <caption>
        <?=$menus[0]->menu->name?>
    </caption>
    <tr>
        <th>点单人</th>
        <th>数量</th>
    </tr>
    <?php foreach ($menus as $menu):?>
    <tr>
        <td><?=$menu->user->username?></td>
        <td><?=$menu->num?></td>
    </tr>
    <?php endforeach;?>
</table>