<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\TombSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<style type="text/css">
    .table ul {
    margin-top: 5px;
    margin-right: 10px;
    margin-bottom: 5px;
    margin-left: 40px;
    list-style-image: none;
    list-style-type: none;
    white-space: nowrap;
    padding: 0px;
}
.table ul li {
    margin: 0px;
    padding: 0px;
    display: block;
    width: 40px;
    float: left;
}
.table ul li span {
    padding: 0px;
    display: block;
    height: 14px;
    width: 40px;
    margin-top: 0px;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    line-height: 14px;
    text-align: center;
    color: #000000;
    font-size: 12px;
}
.table ul li img {
    padding: 0px;
    display: block;
    height: 24px;
    width: 24px;
    margin-top: 0px;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    border: 1px solid #FFF;
}
</style>


<?php 
    $models = $dataProvider->getModels();
    $result = ArrayHelper::index($models, 'id', 'row');
 ?>

<?php 
    Modal::begin([
        'header' => '业务操作',
        'id' => 'modalAdd',
        'size' => Modal::SIZE_LARGE,
        'footer' => '<button class="btn btn-info" data-dismiss="modal">取消</button>',
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>

<?php 
$grave_id = \Yii::$app->request->get('grave_id');

$sta = \Yii::$app->request->get('TombSearch')['status'];


 ?>
<?php if (isset($grave_id)): ?>
    <div class="widget-box transparent ui-sortable-handle" id="widget-box-13">
    <?php $status = \app\modules\grave\models\Tomb::getSta(); ?>
        <div class="widget-header">
            <div class="widget-toolbar no-border">
                <ul class="nav nav-tabs">
                    <li class="<?php if ($sta == null): ?>active<?php endif ?>">
                        <a href="<?=Url::toRoute(['index', 'grave_id'=>$grave_id])?>" aria-expanded="true">全部</a>
                    </li>
                    <?php foreach ($status as $k => $v): ?>
                        <li class="<?php if ($sta == $k): ?>active<?php endif ?>">
                            <a href="<?=Url::toRoute(['index', 'grave_id'=>$grave_id,'TombSearch[status]'=>$k])?>" aria-expanded="true"><?=$v?></a>
                        </li>
                    <?php endforeach ?>
                    
                </ul>
            </div>
        </div>
    </div> 
<?php endif ?>

 <?php if (!$models): ?>
     <p>此墓区不存在相应墓位</p>
 <?php endif ?>
 <table class="table">
    <?php foreach ($result as $k=>$models):?>
     <tr>
         <td>
            <div class="pull-left"><?=$k?>排</div>
             <ul>
                <?php foreach ($models as $model): ?>
                 <li>
                     <div>
                         <a href="<?=Url::toRoute(['option', 'id'=>$model->id])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                             <img src="/static/images/tree.jpg" width="26" height="26" title="<?=$model->tomb_no?>">
                         </a>
                         <span><?=$model->col?>号</span>
                     </div>
                 </li>
                <?php endforeach ?>
             </ul>
         </td>
     </tr>
    <?php endforeach ?>
 </table>

    <div class="hr hr-18 dotted hr-double"></div>




<?php $this->beginBlock('mod') ?>  
$(function(){
   $('.modalAddButton').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');
        //加载完再显示，看着舒服一点
        $('#modalAdd').find('#modalContent')
                    .load($(this).attr('href'),function(){
                        btn.button('reset');
                        $('#modalAdd').modal('show');
                    });
    });
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['mod'], \yii\web\View::POS_END); ?>  








