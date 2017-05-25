<?php
use app\modules\wechat\models\Menu;
use yii\helpers\Url;
?>
<table class="table table-hover">
    <tbody>
    <tr>
        <th>菜单名称</th>
        <th>类别</th>
        <th>URL/编辑</th>
        <th width="100">操作</th>
    </tr>
    <?php foreach ($menus as $menu): ?>
        <tr style="background:#eee;">
            <?php if (!isset($menu['child'])):?>
            <td>
                <?=$menu['name']?>
            </td>
            <td>
                <?=$typemap[$menu['type']]?>
            </td>
            <td>
                <?php if ($menu['type'] == Menu::TYPE_URL): ?>
                    <?=$menu['url']?>
                <?php else: ?>
                    <a class="" href="">
                        <i class="fa fa-edit"></i>
                        <span class="blue">编辑响应内容<span></span></span>
                    </a>
                <?php endif ?>
            </td>
                <?php else:?>
            <td colspan="3"><?=$menu['name']?></td>
            <?php endif;?>
            <td>
                <a href="<?=Url::toRoute(['update-menu', 'id'=>$menu['id']])?>" title="编辑" class='modalEditButton' data-loading-text="页面加载中, 请稍后..." onclick="return false">
                    <span class="glyphicon glyphicon-pencil"></span>编辑
                </a>
                <a href="<?=Url::toRoute(['delete', 'id'=>$menu['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        <?php if (isset($menu['child'])): ?>
            <?php foreach ($menu['child'] as $v): ?>
                <tr>
                    <td style="padding-left:3em;"><?=$v['name']?></td>
                    <td>
                        <?=$typemap[$v['type']]?>
                    </td>
                    <td>
                        <?php if ($v['type'] == Menu::TYPE_URL): ?>
                            <?=$v['url']?>
                        <?php else: ?>
                            <a class="" href="">
                                <i class="fa fa-edit"></i>
                                <span class="blue">响应内容<span></span></span>
                            </a>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?=Url::toRoute(['update-menu', 'id'=>$v['id']])?>" title="编辑" class='modalEditButton' data-loading-text="页面加载中, 请稍后..." onclick="return false">
                            <span class="glyphicon glyphicon-pencil"></span>编辑
                        </a>
                        <a href="<?=Url::toRoute(['delete', 'id'=>$v['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>

                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    <?php endforeach ?>

    </tbody>
</table>

