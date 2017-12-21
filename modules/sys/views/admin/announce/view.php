<div class="page-content">
    <!-- /section:settings.box -->
    <table class="table noborder">
        <tr>
            <th>
                <h4 style="text-align: center">
                    <?=$model->title?>
                </h4>
            </th>
        </tr>
        <tr>
            <td class="author">
                <span>发布人:<?=$model->author?></span>
                <span>发布时间:<?=date('Y-m-d H:i', $model->created_at)?></span>
                <span>展示时间 <?=$model->start?> - <?=$model->end?></span>
            </td>
        </tr>
        <tr>
            <td class="content"><?=$model->content?></td>
        </tr>
    </table>

</div>