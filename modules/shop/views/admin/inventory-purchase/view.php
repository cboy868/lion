<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\InventoryPurchase */

$this->title = $model->supplier->cp_name;
$this->params['breadcrumbs'][] = ['label' => '进货管理', 'url' => ['index']];
?>
<style type="text/css">
    .table{
        margin-bottom: 0;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-8 inventory-purchase-view">
            <table class="table">
                <tr>
                    <th>供货商</th>
                    <td><?=$model->supplier->cp_name?></td>
                    <th>联系人</th>
                    <td><?=$model->ct_name .'(' .$model->ct_mobile.')'?></td>
                    <th>验收人</th>
                    <td><?=$model->checker_name?></td>
                    <th>总金额</th>
                    <td><?=$model->total?></td>
                    <th>备注</th>
                    <td><?=$model->note?></td>
                    <th>添加时间</th>
                    <td><?=date('Y-m-d H:i', $model->created_at)?></td>
                </tr>
            </table>
            </div><!-- /.col -->

            <div class="col-xs-12">
                <table class="table table-bordered" style="margin-top: 20px">
                    <tr class="tbsearch">
                        <td width="180">商品首拼 <input type="text" style="width: 100px" class="sp"></td>
                        <td width="180">商品编码 <input type="text" style="width: 100px" class="bm"></td>
                        <td width="180">名称 <input type="text" style="width: 100px" class="gname"></td>
                        <td colspan="2"><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>  查找</button></td>
                    </tr>
                </table>
                <div class="glist">
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <td colspan="5">
                            碑文刻字费 大字
                        </td>
                    </tr>
                    <tr>
                        <td width="170">进货量 <input type="text" name="" style="width: 100px"></td>
                        <td width="170">单&nbsp&nbsp&nbsp位 <input type="text" name="" style="width: 100px"></td>
                        <td width="170">总&nbsp&nbsp&nbsp价 <input type="text" name="" style="width: 100px"></td>
                        <td width="170">单&nbsp&nbsp&nbsp价 <input type="text" name="" style="width: 100px"></td>
                        <td>建议零售价 <input type="text" name="" style="width: 100px"></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <textarea placeholder="备注" rows="6" style="width:100%"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <a href="#">添加商品</a>
                        </td>
                        <td style="text-align: right;">
                            <button class="btn btn-info btn-lg" style="margin-right: 50px">提    交</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
    $('.sp,.bm,.gname').keyup(function(){
        var item = $('.tbsearch');
        var sp = item.find('.sp').val();
        var bm = item.find('.bm').val();
        var gname = item.find('.gname').val();
        var data = {sp:sp, bm:bm, name:gname};
        console.log(data);
        var url = '<?=Url::toRoute(["glist"])?>';

        if (!sp && !bm && !gname) {
            return ;
        }

        $.get(url, data, function(xhr){
            $('.glist').html(xhr);
        });
       // $('.glist').load(url);
    });

    $('body').on('click', '.glist', function(e){
        e.preventDefault();
        alert(1);
    })
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
