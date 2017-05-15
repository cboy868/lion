<?php 
use app\core\helpers\Url;
?>
<style type="text/css">
    .task .btns{
        display: none;
        margin-right: 20px;
    }
</style>


<div class="widget-box transparent ui-sortable-handle task" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-tasks"></i> 工作任务</h4>

        <div class="widget-toolbar no-border">
            <ul class="nav nav-tabs" id="myTab2">
                <li class="active">
                    <a data-toggle="tab" href="#home2">今日</a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#profile2">明日</a>
                </li>

                <li>
                    <a data-toggle="tab" href="#info2">昨日</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <div class="tab-content padding-4">

                <div id="home2" class="tab-pane active">
                    <div class="scrollable ace-scroll scroll-active">
                        <div class="scroll-content">

                            <ul class="media-list" style="border-right: 1px solid #ccc;">
                                <?php
                                if (isset($models['tomorrow'])):
                                ?>
                                <?php foreach ($models['today'] as $k => $model): ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?=$model->id . '、' . $model->title?>
                                                <small class="btns pull-right">
                                                    <a href="<?=Url::toRoute(['/task/admin/default/finish', 'id'=>$model->id])?>" class="btn btn-xs btn-info btn-ok">完成</a>
                                                </small>
                                            </h5>
                                            <p>
                                                <?=$model->content;?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="profile2" class="tab-pane">
                    <div class="scrollable ace-scroll">
                        <div class="scroll-content">
                            <ul class="media-list" style="border-right: 1px solid #ccc;">
                                <?php
                                if (isset($models['tomorrow'])):
                                ?>
                                <?php foreach ($models['tomorrow'] as $k => $model): ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?=$model->id . '、' . $model->title?>
<!--                                                <small class="btns pull-right">-->
<!--                                                    <a href="--><?php //=Url::toRoute(['/task/admin/default/finish', 'id'=>$model->id])?><!--" class="btn btn-xs btn-info btn-ok">完成</a>-->
<!--                                                </small>-->
                                            </h5>
                                            <p>
                                                <?=$model->content;?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="info2" class="tab-pane">
                    <div class="scrollable ace-scroll" >
                        <div class="scroll-content">
                            <ul class="media-list" style="border-right: 1px solid #ccc;">
                                <?php
                                if (isset($models['yestoday'])):
                                ?>
                                <?php foreach ($models['yestoday'] as $k => $model): ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?=$model->id . '、' . $model->title?>
                                                <small class="btns pull-right">
                                                    <a href="<?=Url::toRoute(['/task/admin/default/finish', 'id'=>$model->id])?>" class="btn btn-xs btn-info btn-ok">完成</a>
                                                </small>
                                            </h5>
                                            <p>
                                                <?=$model->content;?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                <?php
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('cate') ?>
$(function(){
   $('.task li').mouseover(function(){
    $('.btns', this).show();
   });

   $('.task li').mouseleave(function(){
    $('.btns', this).hide();
   });

   $('.btn-ok').click(function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var that = this;
    $.get(url, {}, function(xhr){
      if (xhr.status) {
        $(that).closest('li.media').remove();
      }
    },'json');

   });
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  