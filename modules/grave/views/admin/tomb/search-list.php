<?php 
use app\core\helpers\Url;
use yii\bootstrap\Modal;

?>
<?php 
    Modal::begin([
        'header' => '新增',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>

<?php if ($dataProvider->getModels()): ?>
    <table class="table">
        <?php foreach ($dataProvider->getModels() as $k => $model): ?>
            <tr>
                <td width="30%"><?=$model->tomb_no?></td>
                <td width="70%">
                    <div class="form-group pull-right">
                        <a href="<?=Url::toRoute(['/grave/admin/tomb/option', 'id'=>$model->id, 'client_id'=>Yii::$app->request->get('client_id')])?>" class="btn btn-info btn-sm mAddButton">办理业务</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
        
    </table>
<?php else: ?>
    <font color="red">未找到墓位</font>
<?php endif ?>


<?php $this->beginBlock('cate') ?>  
$(function(){
    $('.mAddButton').click(function(e){
        e.preventDefault();
        //加载完再显示，看着舒服一点
        $('#modalAdd').find('#modalContent')
                    .load($(this).attr('href'),function(){
                        $('#modalAdd').modal('show');
                    });
    });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  