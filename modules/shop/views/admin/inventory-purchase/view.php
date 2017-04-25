<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
app\assets\ValidateAsset::register($this);
app\assets\MustacheAsset::register($this);
app\assets\FormAsset::register($this);

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
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div class="glist">
                </div>
                <div class="terror" style="text-align: center;color:red;font-size: 25px">
                </div>
                <div class="tsuccess" style="text-align: center;color:green;font-size: 25px; ">
                </div>
                <form method="post" id="frm">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <div>
                        <div id="sel-box" style="max-height: 500px;overflow: auto;">
                        </div>

                    </div>
                </form>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<script id="template" type="x-tmpl-mustache">


<table class="table table-bordered gdata">
    <tr>
        <td colspan="5">
            <h4 style="color:green" class="intit pull-left">{{sku_name}}<small></small></h4>
            <a href="#" class="btn btn-danger btn-sm box-del pull-right">删除</a>
        </td>
    </tr>
    <tr>
        <td width="170">进货量 <input type="text" name="in[{{sku_id}}][num]" style="width: 100px" required class="num"></td>
        <td width="170">总&nbsp&nbsp&nbsp价 <input type="text" name="in[{{sku_id}}][total]" style="width: 100px" required class="total"></td>
        <td width="170">单&nbsp&nbsp&nbsp价 <input type="text" name="in[{{sku_id}}][unit_price]" style="width: 100px" required class="uprice"></td>
        <td width="170">单&nbsp&nbsp&nbsp位 <input type="text" name="in[{{sku_id}}][unit]" style="width: 100px"></td>
        <td>建议零售价 <input type="text" name="in[{{sku_id}}][retail]" style="width: 100px"></td>
    </tr>
    <tr>
        <td colspan="5">
            <input type="hidden" name="in[{{sku_id}}][goods_id]" class="goods_id" value="{{goods_id}}">
            <textarea name="in[{{sku_id}}][note]" placeholder="备注" rows="3" style="width:100%"></textarea>
            
        </td>
    </tr>
</table>

</script>
<?php $this->beginBlock('cate') ?>  
$(function(){
    $('.sp,.bm,.gname').change(function(){
        var item = $('.tbsearch');
        var sp = item.find('.sp').val();
        var bm = item.find('.bm').val();
        var gname = item.find('.gname').val();
        var data = {sp:sp, bm:bm, name:gname};
        var url = '<?=Url::toRoute(["glist"])?>';

        if (!sp && !bm && !gname) {
            return ;
        }

        $.get(url, data, function(xhr){
            $('.glist').html(xhr);
        });
    });


   
    $('body').on('change', '.num, .total', function(e){
        e.preventDefault();

        var item = $(this).closest('table.gdata');
        var num = item.find('.num').val();
        var total = item.find('.total').val();

        if (!num || !total) {
            return; 
        }
        var uprice = parseFloat(total) / parseFloat(num);
        item.find('.uprice').val(uprice.toFixed(2));

    })

     $('body').on('click', '.glist .instor', function(e){
        e.preventDefault();
        addToSelected($(this));
    })


    $('body').on('click', '.box-del', function(e){
        e.preventDefault();
        $(this).closest('table.gdata').remove();
    });

    var goodsSelect = {};
    // 添加选择商品
    function addToSelected(item)
    {
        var goods_id = item.data('gid');
        var sku_id = item.data('sku_id');
        var sku_name = item.data('name');

        goodsSelect[sku_id] = {
            'sku_id'   : sku_id,
            'sku_name' : sku_name,
            'goods_id' : goods_id
        }
        updateSelected();
    }

    // 更新列表页面
    function updateSelected()
    {
         var itemBox = $('#sel-box');
         itemBox.empty();
         var template = $('#template').html();
          Mustache.parse(template); 
          for (key in goodsSelect){
              var datas = goodsSelect[key];
              var rendered = Mustache.render(template, datas);
              itemBox.append(rendered);
          }
          var btn = '<div class="form-group">' +
                        '<div class="col-sm-offset-5 col-sm-2">' +
                                '<button type="submit" class="btn btn-info btn-lg btn-block gsub">保 存</button>' +
                        '</div>' +
                    '</div>';
          itemBox.append(btn);
    }

    $('#frm').submit(function() {  
       $(this).ajaxSubmit(function(xhr) {   
            if (xhr.status) {
                $(".tsuccess").html("恭喜,入库成功!").show(300).delay(1000).hide(1000);
                $("#sel-box").html(''); 
            } else {
                $('.terror').html("提示,入库失败!,请重试或联系管理员").show(300).delay(1000).hide(1000); 
            }
       });  
       return false; //阻止表单默认提交  
    });  

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
