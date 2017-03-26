<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\grave\widgets\Tomb;
use yii\bootstrap\Modal;
\app\assets\ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Tomb */

$this->title = $model->tomb_no;
$this->params['breadcrumbs'][] = ['label' => '墓位管理', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>一墓一档 <small>墓位详细信息</small></h1>
        </div>
        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdi',
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
             <?=Tomb::widget(['method'=>'customer', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'ins', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'portrait', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'order', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'car', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'memorial', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'dead', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'task', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'note', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'pre_bury', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'bury', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'withdraw', 'tomb_id'=>$tomb_id])?>
             <?=Tomb::widget(['method'=>'todo', 'tomb_id'=>$tomb_id])?>

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