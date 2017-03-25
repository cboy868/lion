<?php 
use app\core\helpers\Url;
?>
<style type="text/css">
    .task .btns{
        display: none;
        margin-right: 20px;
    }
</style>
<div class="col-md-6 task" >
    <div class="page-header">
        <h4><i class="fa fa-cubes"></i> 今日工作</h4>
    </div>
    <ul class="media-list" style="height:400px;overflow-y:auto;border-right: 1px solid #ccc;">

    <?php foreach ($models as $k => $model): ?>
      <li class="media">
        <div class="media-body">
          <h5 class="media-heading"><?=$model->id . '、' . $model->title?>
            <small class="btns pull-right">
              <a href="<?=Url::toRoute(['/task/admin/default/finish', 'id'=>$model->id])?>" class="btn btn-xs btn-info btn-ok">完成</a>
              <!-- <a href="#" class="btn btn-xs btn-del btn-danger">del</a> -->
            </small>
          </h5>
          <p>
            <?=$model->content;?>
          </p>
        </div>
      </li>
    <?php endforeach ?>
    </ul>
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