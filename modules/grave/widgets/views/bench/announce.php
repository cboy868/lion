<?php 
use app\core\helpers\Url;
use yii\bootstrap\Modal;

?>
<style>
    .adetail{
        font-size: 16px;
        color:#666;
    }

</style>
<div class="widget-box transparent ui-sortable-handle tb" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-bell-o"></i> 最新公告</h4>
        <?php if (Yii::$app->user->can('sys/admin/announce/create')):?>
        <div class="widget-toolbar no-border">
            <a href="<?=Url::to(['/sys/admin/announce/create', 'type'=>\app\modules\sys\models\Announce::TYPE_SYS])?>"
               class='btn btn-warning modalEditButton'
               title="发布系统公告"
               data-title = '发布公告'
               data-loading-text="页面加载中, 请稍后..."
               onclick="return false">发布系统公告</a>
        </div>
        <?php endif;?>
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">

            <table class="table noborder" style="border: none">
                <?php foreach ($models as $k => $model): ?>
                    <tr>
                        <td>
                            <a href="<?=Url::toRoute(['/sys/admin/announce/view', 'id'=>$model->id])?>"
                               class='modalEditButton adetail'
                               title="公告详情"
                               data-title = '公告详情'
                               data-loading-text="页面加载中, 请稍后..."
                               onclick="return false"
                            ><?=$model->title?> </a>
                            <span style="float: right;"><?=date('Y-m-d H', $model->created_at)?> <?=$model->author?></span>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
   $('.tb li').mouseover(function(){
    $('.btns', this).show();
   });

   $('.tb li').mouseleave(function(){
    $('.btns', this).hide();
   });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  