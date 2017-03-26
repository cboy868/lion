<?php
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
?>
<div class="col-xs-12">
<div class="item table-responsive" id="ins" loc="loc3">
<div class="table-header">
    <i class="icon-credit-card"></i> <span class="title_info">碑文信息 </span>
    <a class="" target="_blank" href="<?=Url::toRoute(['/grave/admin/ins/view', 'id'=>$ins->id])?>">查看碑文详情</a>
    </div>
    <table class="table table-bordered table-condensed table-striped">
        <tbody>
            <tr>
                
                <th width="100">字体</th>
                <td><?=$ins->fontStyle?></td>
                <td rowspan ="3">
                    <a href="<?=$ins->getImg('front')?>" class="artimg">
                        <img class="image" width="210" alt="碑前文" src="<?=$ins->getImg('front')?>">
                    </a>
                    <a href="<?=$ins->getImg('back')?>" class="artimg">
                        <img class="image" width="210" alt="碑后文" src="<?=$ins->getImg('back')?>">
                    </a>
                </td>
                
            </tr>
             <tr>
                <th width="100">字数</th>
                <td><?=$ins->font_num?></td>
            </tr>
             <tr>
                <th width="100">状态</th>
                <td><?=Ins::getIsConfirm($ins->is_confirm)?></td>
            </tr>
     
        </tbody>
    </table>
</div>
</div>