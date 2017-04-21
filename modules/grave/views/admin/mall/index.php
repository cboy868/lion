<?php 
use app\assets\Tabletree;
use app\assets\MustacheAsset;
use app\core\helpers\Url;
Tabletree::register($this);
MustacheAsset::register($this);

$tomb_no = '';
if ($tomb) {
    $tomb_no = $tomb->tomb_no;
}
$this->title = $tomb_no .' 购买商品';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row" id="goods_order">
            <form method="post" id="goodsForm">

            <?php if (count($goods_cates)): ?>
                <div class="col-sm-2" id="cate-list-box">
                    <div class="panel panel-primary nav nav-tabs"role="tablist">
                      <div class="panel-heading">
                          <span style="margin-right:1em;">商品分类</span>
                      </div>
                        <table class="table table-bordered table-hover table-condensed" id="cate-tree">
                            <tbody>
                              <tr>
                                <td class="text-center"> 
                                  <a id="btn-plus" href="#"> <i class="fa fa-plus"></i> 展开</a> | 
                                  <a id="btn-times" href="#"><i class="fa fa-minus"></i> 折叠</a>
                                 </td>
                                </tr>
                            </tbody>
                            <tbody>
                            <?php foreach ($goods_cates as $k => $vo): ?>
                                <tr class="cate-box"  data-tt-id="<?=$vo['id']?>" <?php if($vo['pid']!=1):?>data-tt-parent-id="<?=$vo['pid']?>" <?php endif;?>>
                                  <td role="presentation">
                                  <a class="cgoods" href="#goods<?=$vo['id']?>" cid="<?=$vo['id']?>" role="tab" data-toggle="tab"><?=$vo['name']?></a>
                                  </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-5">
            <?php else: ?>
                <div class="col-sm-7">
            <?php endif ?>

                <div class="search-box search-outline">
                        <div class="input-group">
                          <input type="text" class="form-control sname" placeholder="请输入商品名">
                          <input type="hidden" class="scategory_id" value="<?=$first->id?>">
                          <span class="input-group-btn">
                            <button class="btn btn-default btngs" type="button"> 查 &nbsp; 找 </button>
                          </span>
                        </div><!-- /input-group -->
                </div>
                <div id="goods-list-box">
                    
            </div>
            </div>

            <div class="col-sm-5">
                <div role="tabpanel" class="tab-pane" id="goods-selected-box">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>封面</th>
                                <th>商品名称</th>
                                <th>数量</th>
                                <th>单价</th>
                                <th>总价</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="selected-item-box">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                
                </div>
            </div>
                
                <div class="col-md-12">
                    <input type="hidden" name="goods_info" value="" />
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    <input type="hidden" name="tomb_id" value="<?=$get['tomb_id']?>" />
                    <button type="button" class="btn btn-info buy pull-right">提交</button>
                </div>

                
            </form>
        </div>
<script id="template" type="x-tmpl-mustache">

<tr class="gtr{{sku_id}}">
    <td><img style="width:50px;height:50px;" class="img-rounded" src="{{ img }}"/></li>
    <td><strong>{{ title }} {{sku_name}}</strong></td>
    <td><code>{{ num }}个</code></td>
    <td><span class="text-primary">¥{{ price }}</span></td>
    <td><span class="text-danger">¥{{ totalPrice }}</span></td>
    <td><a class="del-goods btn btn-xs btn-danger" data-id="{{ sku_id }}" href="#">删除</a></td>
</tr>

</script>

<?php $this->beginBlock('foo') ?>  
 

$(function(){
    var goodsSelect = {};
    var goodsSelectedBox = $('#goods-selected-box');
    var goodsListBox = $('#goods-list-box');
    getGoods();

    $('.btngs').click(function(){
        var name = $('.sname').val();
        var category_id = $('.scategory_id').val();
        var data = {name:name, category_id:category_id};
        $.get('<?=Url::toRoute(['/grave/admin/mall/goods'])?>', data, function(xhr){
            goodsListBox.html(xhr);
        }, 'html')
    });

    function getGoods()
    {
        var category_id = $('.scategory_id').val();
        var data = {category_id:category_id};
        $.get('<?=Url::toRoute(['/grave/admin/mall/goods'])?>', data, function(xhr){
            goodsListBox.html(xhr);
        }, 'html')
    }

    $('body').on('click', '.pagination li a', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(xhr){
            console.log(xhr);
            goodsListBox.html(xhr);
        }, 'html')
    })

    $('.pagination ')

        // 调取分类
    $('a.cgoods').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var cid = $(this).attr('cid');
        $('.scategory_id').val(cid);
        $.get('<?=Url::toRoute(['/grave/admin/mall/goods'])?>',{category_id:cid}, function(xhr){
            console.log(xhr);
            goodsListBox.html(xhr);
            $this.parents('tbody:first').find('td').removeClass('active');
            $this.parents('td:first').addClass('active');
        }, 'html')
    });


    // 商品页面加减数量
    goodsListBox.on('click', 'button.btn-sub,button.btn-add', function(e){
        e.preventDefault();
        var $this = $(this);
        var goodsItem = $this.parents('tr')
        var target = goodsItem.find('.gnum');
        var val = parseInt(target.val());
        var old_val = val;
        if ($this.hasClass('btn-sub')) {
            if (val > 0) {
                target.val(--val);
            }
        } else{
            target.val(++val);
        }

        if ( val > 0 ) {
            addToSelected(goodsItem);
        } 

        if (val == 0) {
            if (old_val>val) {
                addToSelected(goodsItem);
                $('.gtr' + goodsItem.find('.sku_id').val()).remove();
            }
        }
        makeDatas();
    });

    $('body').on('change', '.sku', function(e){
        e.preventDefault();
        var sku_id = $(this).val();
        var sku_name = $('option:selected', this).text();
        $(this).closest('tr').find('.sku_id').attr('sku-name', sku_name).val(sku_id);

        var num = 0;
        if (typeof(goodsSelect[sku_id]) != 'undefined') {
            num = goodsSelect[sku_id].num;
        }
        $(this).closest('tr').find('.gnum').val(num);
    })



    var cTree = $('#cate-tree');
    cTree.treetable({ 
        expandable: true,
        initialState: 'collapsed',
    });
    $('#btn-plus').click(function(e){
        e.preventDefault();
        cTree.treetable('expandAll');
    });
    $('#btn-times').click(function(e){
        e.preventDefault();
        cTree.treetable('collapseAll');
    });

    $('.buy').click(function(e){
        e.preventDefault();

        var data = $('#goodsForm').serialize();
        $.post("<?=Url::toRoute(['/grave/admin/mall/index', 'tomb_id'=>$get['tomb_id']])?>", data, function(xhr){
            if (xhr.status) {
                //$('#modalAdd').modal('hide');
                location.reload();
            }
        },'json');

    });

    // 添加选择商品
    function addToSelected(item)
    {
        var goods_id = item.data('id');
        var num = parseInt(item.find('input.gnum').val());

        var price = item.data('price');
        var totalPrice = price*num;
        var sku_id = item.find('.sku_id').val();
        var sku_name = item.find('.sku_id').attr('sku-name');
        goodsSelect[sku_id] = {
            'id'    : item.data('id'),
            'title' : item.data('title'),
            'price' : price,
            'img'   : item.data('img'),
            'num'   : num,
            'totalPrice' : totalPrice,
            //'day'   : day,
            'sku_id': sku_id,
            'sku_name' : sku_name
        }
        //console.dir(goodsSelect[sku_id]);
        updateSelected();
        makeDatas
    }

    // 更新列表页面
    function updateSelected()
    {
         var itemBox = $('#selected-item-box');
         itemBox.empty();
         var template = $('#template').html();
          Mustache.parse(template); 
          for (key in goodsSelect){
              var datas = goodsSelect[key];
              var rendered = Mustache.render(template, datas);
              itemBox.append(rendered);
          }
    }


    // 删除商品
    goodsSelectedBox.on('click', 'a.del-goods', function(e){
        e.preventDefault();
        var $this = $(this);
        var goodsId = $this.data('id');
        $('.g'+goodsId).find('.gnum').val(0);
        delete goodsSelect[goodsId];
        $this.parents('tr:first').remove();
        makeDatas();
    });

    function makeDatas()
    {
        var value = JSON.stringify(goodsSelect);
        $('input[name=goods_info]').val(value);
    }
}); 
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  