<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\grave\widgets\Tomb;
use app\modules\grave\models\Tomb as GraveTomb;
use yii\bootstrap\Modal;
use app\core\helpers\Url;
\app\assets\ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Tomb */
$this->params['current_menu'] = 'grave/tomb/index';

$this->title = $model->tomb_no;
$this->params['breadcrumbs'][] = ['label' => '墓位管理', 'url' => ['index']];
?>
<style type="text/css">
    .table-header{
        font-size: 14px;
        line-height: 38px;
        padding-left: 12px;
        background-color: #90CFF0;
        color: #393939;
        border-bottom: none;
        margin-bottom: 0px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>一墓一档
                <small>墓位详细信息
                    <?php if($model->status >1 &&$model->status < 9 ):?>
                    <a class="btn btn-info btn-sm pull-right" href="<?=Url::toRoute(['/grave/admin/process/index', 'tomb_id'=>$model->id,'step'=>1])?>" target="_blank">办业务</a>
                    <?php endif;?>
                </small>
            </h1>
        </div>
        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAd',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]

                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdi',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]

                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <?php 
                $tomb_id = Yii::$app->request->get('id');
             ?>
             <?=Tomb::widget(['method'=>'tomb', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'ins', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'portrait', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'order', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'refund', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'car', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'dead', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'task', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'bury', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'withdraw', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'note', 'tomb_id'=>$tomb_id])?>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('moda') ?>  

$(function () {
    $('.mAddButton').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');
        //加载完再显示，看着舒服一点
        $('#modalAd').find('#modalContent')
                    .load($(this).attr('href'),function(xhr){
                        LN.dtInit();
                        $('#modalAd').modal('show');
                        btn.button('reset');
                    });
    });

    $('.mEditButton').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');
        $('#modalEdi').find('#editContent')
                    .load($(this).attr('href'),function(){
                        LN.dtInit();
                        $('#modalEdi').modal('show');
                        btn.button('reset');
                    });
    });
});

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['moda'], \yii\web\View::POS_END); ?>  