<?php 
use app\assets\Tabletree;
use app\assets\MustacheAsset;
use app\core\helpers\Url;
Tabletree::register($this);
MustacheAsset::register($this);
?>
<style type="text/css" media="screen">
#cate-list-box {
    max-height:500px;
    overflow:auto;
    padding-right:5px;
}
div.goods-item{ border:1px solid white; margin-bottom: 5px;}
input.goods-num { font-size:12px;height:24px; }
.goods-nav>li>a { padding: 5px  }
.list-group-item{
    padding:5px;
}
.list-group-item.active a{color:white}
#content-box{ /*height:450px;*/overflow:auto;/* border-left:1px solid #ccc;*/ }

ul.goods-selected-item {
    border-bottom:1px solid #ccc;
}

#cate-tree td.active{
    background-color:#D5ECD5;
}
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row" id="goods_order">
            <form method="post" id="goodsForm">

            <?php if (count($goods_cates)): ?>
                
                <div class="col-sm-10">
            <?php else: ?>
                <div class="col-sm-12">
            <?php endif ?>
                 <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-justified goods-nav" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#goods-list-box" aria-controls="goods-list-box"
                                                  role="tab" data-toggle="tab"><i class="fa
                                                      fa-fw fa-list"></i> <?=$tname?>列表</a>
                    </li>
                    <li role="presentation">
                        <a href="#goods-selected-box" 
                           aria-controls="goods-selected-box"
                           role="tab"
                           data-toggle="tab"><i class="fa fa-fw fa-check-square-o "></i> 已定<?=$tname?></a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content" id="content-box">
                    <div role="tabpanel" class="tab-pane active" id="goods-list-box">
                    <div class="row">
                        <?php foreach($goods_list as $goods):?>
                        <?php 

                            $sku_cnt = count($goods->sku);


                        ?>
                        <div class="col-sm-4 goods-item" data-id="<?=$goods->id?>" data-title="<?=$goods->name?>" data-price="<?=$goods->price?>" data-img="<?=$goods->getThumb('110x110')?>" >


                             <div class="media">
                                  <div class="media-left media-middle">
                                    <a href="#">
                                      <img class="media-object" src="<?=$goods->getThumb('110x110')?>" alt="..." width="110" height="110">
                                    </a>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading"><small class="text-primary"><strong><?=$goods->name?></strong></small></h4>
                                    <p>
                                        <small>价格:<code>¥<?=$goods->price?>元</code></small>
                                    </p>
                                    <?php if ($sku_cnt > 1): ?>
                                         <p>
                                            <select name="sku_id" class="form-control sku" style="max-width:120px;">
                                                <?php foreach ($goods->sku as $k => $sku): ?>
                                                    <option value="<?=$sku->id?>"><?=$sku->name?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </p>
                                    <?php endif ?>
                                        <input name="sku_id" type="hidden" value="<?=$goods->sku[0]->id?>" class="sku_id" sku-name="<?=$goods->sku[0]->name?>"/>

                                        <div class="text-left goods-sel-btn">
                                            <button class="btn-sub btn btn-xs btn-default" ><span class="fa fa-minus"></span></button>
                                            <input class="goods-num" style="" type="text" value="0" size="3" />
                                            <button class="btn-add btn btn-xs btn-default"><span class="fa fa-plus"></span></button>
                                        </div>
                                  </div>
                                </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    
                    
                    </div>
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

<tr>
    <td><img style="width:50px;height:50px;" class="img-rounded" src="{{ img }}"/></li>
    <td><strong>{{ title }} {{sku_name}}</strong></td>
    <td><code>{{ num }}个</code></td>
    <td><span class="text-primary">¥{{ price }}</span></td>
    <td><span class="text-danger">¥{{ totalPrice }}</span></td>
    <td><a class="sel-goods btn btn-xs btn-danger" data-id="{{ id }}" href="#">删除</a></td>
</tr>

</script>

<?php $this->beginBlock('foo') ?>  
 

$(function(){

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
    // -----------------------------------



    var goodsSelect = {};
    var goodsSelectedBox = $('#goods-selected-box')


    $('.sku').change(function(e){
        e.preventDefault();
        var sku_id = $(this).val();
        var sku_name = $('option:selected', this).text();
        $(this).closest('.media-body').find('.sku_id').attr('sku-name', sku_name).val(sku_id);

        var num = 0;
        if (typeof(goodsSelect[sku_id]) != 'undefined') {
            num = goodsSelect[sku_id].num;
        }
        $(this).closest('.media-body').find('.goods-num').val(num);

    });

    $('.buy').click(function(e){
        e.preventDefault();

        var data = $('#goodsForm').serialize();
        $.post("<?=Url::toRoute(['/grave/admin/mall/index', 'category_id'=>$get['category_id'], 'tomb_id'=>$get['tomb_id']])?>", data, function(xhr){
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
        var num = parseInt(item.find('input.goods-num').val());
        var price = item.data('price');
        var totalPrice = price*num;
        var day = parseInt(item.find('input.goods-day').val());
        var sku_id = item.find('.sku_id').val();
        var sku_name = item.find('.sku_id').attr('sku-name');
        goodsSelect[sku_id] = {
            'id'    : item.data('id'),
            'title' : item.data('title'),
            'price' : price,
            'img'   : item.data('img'),
            'num'   : num,
            'totalPrice' : totalPrice,
            'day'   : day,
            'sku_id': sku_id,
            'sku_name' : sku_name
        }
        //console.dir(goodsSelect[sku_id]);
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

    // 更新商品页面
    function updateGoods(){
    
    
    }

    var goodsListBox = $('#goods-list-box');
    $('div.goods-item').mouseover(function(e){
        $(this).css({'border-color':'#e1e1e1', 'background-color':'#FCF8E3'})
    });
    $('div.goods-item').mouseout(function(e){
        $(this).css({'border-color':'white', 'background-color':'white'})
    });

    // 调取分类
    $('a.goods-category').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var url = $this.attr('href');
        $.get(url, function(xhr){
            goodsListBox.html(xhr);
            $this.parents('tbody:first').find('td').removeClass('active');
            $this.parents('td:first').addClass('active');
        }, 'html')
    });

    // 商品页面加减数量
    goodsListBox.on('click', 'button.btn-sub,button.btn-add', function(e){
        e.preventDefault();
        var $this = $(this);
        var goodsItem = $this.parents('div.goods-item:first');
        var target = $this.parents('div:first').find('input.goods-num');
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
            }
        }
        makeDatas();
    });

    goodsListBox.on('change', 'input.goods-day', function(e){
        var $this = $(this);
        console.dir($this);
        var goodsItem = $this.parents('div.goods-item:first');
        addToSelected(goodsItem);
        makeDatas();
    });


    // 揭换界面
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(this).attr('href');
        if ( target == '#goods-selected-box') {
            updateSelected();
        }
        if ( target == '#goods-list-box') {
            updateGoods();
        }
    })

    // 删除商品
    goodsSelectedBox.on('click', 'a.sel-goods', function(e){
        e.preventDefault();
        var $this = $(this);
        var goodsId = $this.data('id');
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



