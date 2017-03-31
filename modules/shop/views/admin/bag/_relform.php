<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;;
USE app\core\widgets\Ueditor;
use app\core\widgets\Webup\Webup;
use app\modules\shop\models\Category;
// use kartik\select2\Select2;

use app\assets\MustacheAsset;
MustacheAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Bag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bag-form">
    <div class="col-sm-6">
            <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="remotegoods">
                
            </div>
    </div>

    <div class="col-sm-6 ">
        <?php $form = ActiveForm::begin(); ?>
        <table class="table table-bordered sels">
            <thead>
                <tr>
                    <th>关联商品</th>
                    <th>数量</th>
                    <th>价格</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            
            <?php if (isset($model->rels)): ?>
                <?php foreach ($model->rels as $k => $v): ?>
                    <tr class="seltr">
                        <td><?=$v->sku->getName()?></td>
                        <td><input type="number" name="sku[<?=$v->sku_id?>]" class="form-control num" value="<?=$v->num?>"></td>
                        <td class="bprice"><?=$v->price?></td>
                        <td><a href="#">删除</a></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>

            </tbody>

        </table>
        <?= $form->field($model, 'original_price')->textInput(['maxlength' => true, 'class'=>'oprice form-control']) ?>
        <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'class'=>'oprice form-control']) ?>

        <div class="form-group">
            <div class="col-sm-3">
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>


	

</div>
<script id="template" type="x-tmpl-mustache">
<tr class="seltr">
    <td>{{sku_name}}</td>
    <td><input type="number" name="sku[{{sku_id}}]" class="form-control num" value="1"></td>
    <td class="bprice">{{price}}</td>
    <td><a href="#">删除</a></td>
</tr>

</script>

<?php $this->beginBlock('sel') ?>  
$(function(){
    var BagBox = $('table.sels tbody');
    var goodsSelect = [];

    $('.remotegoods').load("<?=Url::toRoute(['/shop/admin/bag/search-goods', 'Category_id'=>2])?>");

    $('body').on('click', '.sku-sel tr', function(){
        addToSelected($(this));
        updateSelected();
    })

    $('body').on('change', '.num', function(){
        calPrice();
    });


    // 添加选择商品
    function addToSelected(item)
    {
        var price = item.data('price');
        var sku_id = item.data('rid');
        var sku_name = item.data('name');
        goodsSelect[sku_id] = {
            'sku_id'    : sku_id,
            'price' : item.data('price'),
            'goods_id' : item.data('gid'),
            'sku_name' : sku_name
        }
    }

    // 更新列表页面
    function updateSelected()
    {
        BagBox.empty();
        var template = $('#template').html();
        Mustache.parse(template); 
        for (key in goodsSelect){
          var datas = goodsSelect[key];
          var rendered = Mustache.render(template, datas);
          BagBox.append(rendered);
        }
        calPrice();
    }

    function calPrice()
    {
        var total = 0;
        BagBox.find('tr').each(function(index){
            var num = $(this).find('.num').val();
            var price = $(this).find('.bprice').text();
            total += parseInt(num) * parseFloat(price);
        });

        $('.oprice').val(total);
    }
})  


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['sel'], \yii\web\View::POS_END); ?>  