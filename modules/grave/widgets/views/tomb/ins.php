<?php
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
\app\assets\ColorBoxAsset::register($this);
?>

<?php if ($ins): ?>
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
                           <!--  <a href="<?=$ins->getImg('plate')?>" class="artimg">
                                <img class="image" width="210" alt="盖板" src="<?=$ins->getImg('plate')?>">
                            </a> -->
                        </td>
                        
                    </tr>
                     <tr>
                        <th width="100">字数</th>
                        <td><?=$ins->big_num + $ins->small_num?></td>
                    </tr>
                     <tr>
                        <th width="100">状态</th>
                        <td><?=Ins::getIsConfirm($ins->is_confirm)?></td>
                    </tr>
             
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>
<?php $this->beginBlock('up') ?>  
$(".image").click(function(e) {
     e.preventDefault();
     var title = $(this).attr('title');
     $(".artimg").colorbox({
         rel: 'artimg',
         maxWidth:'600px',
         maxHeight:'700px',
         next:'',
         previous:'',
         close:'',
         current:""
     });
 });
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 

