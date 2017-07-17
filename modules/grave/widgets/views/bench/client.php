<?php 
use app\core\helpers\Url;
use yii\bootstrap\Modal;

?>

<?php 
    Modal::begin([
        'header' => '业务办理',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal-lg'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>
<style type="text/css">
    .client .btns{
        display: none;
        margin-right: 20px;
        position: absolute;
        top: 1px;
        right: 5px;
    }
</style>

<div class="widget-box transparent ui-sortable-handle client" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-user"></i> 我的客户</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">

            <ul class="media-list" style="border-right: 1px solid #ccc;">
                <?php foreach ($models as $k => $model): ?>
                    <li class="media" style="position:relative;">
                        <div class="media-body">
                            <h4 class="media-heading"><?=$model->name?>
                                <small>
                                    <?=$model->mobile?> <?=date('Y-m-d H:i', $model->created_at)?>
                                </small>
                                <small class="btns pull-right">
                                    <a href="<?=Url::toRoute(['/client/admin/recep/index', 'id'=>$model->id])?>" class="btn btn-xs btn-info" target="_blank">接待记录</a>
                                    <a href="<?=Url::toRoute(['/grave/admin/tomb/search', 'client_id'=>$model->id])?>" class="btn btn-xs btn-info modalAddButton" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">办业务</a>
                                </small>
                            </h4>

                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>


<?php $this->beginBlock('cate') ?>  
$(function(){
   $('.client li').mouseover(function(){
    $('.btns', this).show();
   });

   $('.client li').mouseleave(function(){
    $('.btns', this).hide();
   });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  