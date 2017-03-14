<?php 
use app\core\helpers\Url;
use yii\bootstrap\Modal;

?>

<?php 
    Modal::begin([
        'header' => '业务办理',
        'id' => 'modalAdd',
        // 'size' => 'modal-lg'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>
<style type="text/css">
    .client .btns{
        display: none;
        /*margin-right: 20px;*/
        position: absolute;
        top: 1px;
        right: 5px;
    }
</style>
<div class="col-md-6 client" >
    <div class="page-header">
        <h4><i class="fa fa-cubes"></i> 我的客户</h4>
    </div>
    <ul class="media-list" style="height:400px;overflow-y:auto;border-right: 1px solid #ccc;">
      <table class="table table-striped table-hover table-bordered table-condensed">
        <?php foreach ($models as $k => $model): ?>
          <tr>
            <td width="60"><?=$model->name?></td>
            <td width="90"><?=$model->mobile?></td>
            <td style="position:relative"><?=date('Y-m-d H:i', $model->created_at)?>
              <small class="btns pull-right">
              <a href="<?=Url::toRoute(['/client/admin/recep/index', 'id'=>$model->id])?>" class="btn btn-xs btn-info" target="_blank">接待记录</a>
              <a href="<?=Url::toRoute(['/grave/admin/tomb/search', 'client_id'=>$model->id])?>" class="btn btn-xs btn-info modalAddButton" target="_blank">办业务</a>
            </small>
            </td>
          </tr>
        <?php endforeach ?>
      </table>
    </ul>
</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
   $('.client tr').mouseover(function(){
    $('.btns', this).show();
   });

   $('.client tr').mouseleave(function(){
    $('.btns', this).hide();
   });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  