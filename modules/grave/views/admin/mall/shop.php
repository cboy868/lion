<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;

\app\assets\ExtAsset::register($this);
\app\assets\JqueryuiAsset::register($this);
\app\assets\MustacheAsset::register($this);
?>
<div class="page-content">
    <div class="page-header">
        <h1>商品部</h1>
    </div>
    <div class="row">
        <div class="col-sm-6" id="goods-list">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a data-toggle="tab" href="#goods-list-box">全部</a></li>
                    <li class=""><a data-toggle="tab" href="#bag-list-box">礼包</a></li>
                </ul>

                <div class="tab-content" style="height:800px;overflow:auto">
                    <div role="tabpanel" id="goods-list-box" class="tab-pane in active">
                        <table class="table table-goods">
                            <tr>
                                <th style="width:37px;">图片</th>
                                <th>商品名称</th>
                                <th>规格选择</th>
                                <th>价格</th>
                                <th>选择</th>
                            </tr>
                            <?php foreach($goods as $key=>$val):?>
                                <?php foreach($val as $g):?>
                                    <?php $sku_cnt = count($g->sku);?>
                                    <tr class="goods-tr g<?=$g->id?>"
                                        data-pinyin="<?=$g->pinyin?>"
                                        data-serial="<?=$g->serial?>"
                                        data-title="<?=$g->name?>"
                                        data-id="<?=$g->id?>"
                                        data-price="<?=$g->price?>"
                                        data-img="<?=$g->getThumb('110x110')?>"
                                    >
                                        <td>
                                            <img class="img-rounded" width="35" height="35"
                                                 src="<?=$g->getThumb()?>" />
                                        </td>
                                        <td>
                                            <a target="_blank" title="{$goods.title}" href="#"><?=$g->name?> </a>



                                            <?php if($g->unit):?>
                                                [<?=$g->unit?>]
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if ($sku_cnt > 1): ?>
                                                <p>
                                                    <select name="sku_id" class="form-control sku sku_id" style="max-width:120px;">
                                                        <?php foreach ($g->sku as $k => $sku): ?>
                                                            <option value="<?=$sku->id?>" data-price="<?=$sku->price?>">
                                                                <?=$sku->name?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </p>
                                            <?php else: ?>
                                                <input name="sku_id" type="hidden" value="<?=$g->sku[0]->id?>" class="sku_id"
                                                       sku-name="<?=$g->sku[0]->name?>" data-price="<?=$g->price?>"/>
                                            <?php endif ?>
                                        </td>
                                        <td><?=$g->price?>元</td>
                                        <td width=100>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger btn-minus" type="button">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input data-type="goods"
                                                       data-id="<?=$g->id?>"
                                                       data-title="<?=$g->name?>"
                                                       data-price="<?=$g->price?>"
                                                       class="form-control gnum" name="value" type="text"
                                                       style="padding:4px 3px;width:50px"
                                                       value="0" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success btn-plus" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div><!-- /input-group -->
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endforeach;?>

                        </table>
                    </div>
                    <div id="bag-list-box" class="tab-pane in" >

                        <table class="table table-goods">
                            <tr>
                                <th style="width:37px;">图片</th>
                                <th>商品名称</th>
                                <th>数量</th>
                                <th>价格</th>
                                <th>选择</th>
                            </tr>
                            <?php foreach($bags as $g):?>
                                <tr class="goods-tr"
                                    data-title="<?=$g->title?>"
                                    data-id="<?=$g->id?>"
                                    data-price="<?=$g->price?>"
                                    data-img="<?=$g->getThumb('110x110')?>"
                                >
                                    <td>
                                        <img class="img-rounded" width="35" height="35"
                                             src="<?=$g->getThumb()?>" />
                                    </td>
                                    <td>
                                        <a href="#" target="_blank"><?=$g->title?> [套]</a>
                                    </td>
                                    <td></td>
                                    <td><?=$g->price?>元</td>
                                    <td width=100>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger btn-minus" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </span>
                                            <input data-type="bag"
                                                   data-id="<?=$g->id?>"
                                                   data-title="<?=$g->title?>"
                                                   data-price="<?=$g->price?>"
                                                   class="form-control gnum" name="value" type="text"
                                                   style="padding:4px 3px;width:50px"
                                                   value="0" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-success btn-plus" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>

                    </div>
                </div>
            <div class="pull-right" style="position:absolute;top:0px;right:15px;">
                <input id="py_search" size="35" type="text" name="py" placeholder="拼音模糊查询" />
            </div>
        </div>

        <div class="col-sm-6" id="use-info">
            <div class="row">
                <div class="col-xs-12" id="order-list">
                    <div class="widget-box">
                        <div class="widget-body">
                            <div class="widget-main" id="goods-selected-box">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>商品</th>
                                        <th>数量</th>
                                        <th>价格</th>
                                        <th></th>
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
                </div>
                <div class="col-xs-12" id="user-info">

                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="smaller">
                                用户信息
                            </h4>
                        </div>
                        <style type="text/css">
                            .form-inline .form-group{
                                /*margin-bottom: 10px;*/
                            }
                            .selectize-control{
                                display: inline-block;
                            }

                            .selectize-input {
                                border: 1px solid #d0d0d0;
                                padding: 3px 8px;
                                width: 10em;
                                overflow: visible;
                                border-radius:0;
                            }
                        </style>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form method="post" action="<?=\yii\helpers\Url::toRoute('order')?>" class="form-horizontal" role="form">

                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">相关墓位</label>
                                        <div class="col-xs-8">
                                            <?php $gid = isset($grave->id) ? $grave->id : null?>
                                            <?=Html::dropDownList('grave_id', $gid, $graves,['class'=>'sel-ize gv grave'])?>
                                            -

                                            <input class="tombinfo trow" type="text" placeholder="排"
                                                   name="row" value="<?=isset($tomb->row) ? $tomb->row:''?>" style="width:3em">
                                            -
                                            <input class="tombinfo tcol" type="text" placeholder="列"
                                                   name="col" value="<?=isset($tomb->col) ? $tomb->col : ''?>" style="width:3em">
                                            <p class="infonote"></p>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">销售人</label>
                                        <div class="col-xs-6">
                                            <?=Select2::widget([
                                                'name' => 'op_id',
                                                'data' => $staffs,
                                                'value' => Yii::$app->user->id,
                                                'options' => [
                                                    'placeholder' => '选择销售人',
                                                    'multiple' => false,
                                                    'class'=>'op_id'
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">用户</label>
                                        <div class="col-xs-6">
                                            <input type="text"
                                                   class="form-control input-sm customer_name"
                                                   name="customer_name"
                                                   readonly
                                                   value="<?=isset($customer->name)?$customer->name : ''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">手机号码</label>
                                        <div class="col-xs-6">
                                            <input type="text"
                                                   class="form-control input-sm mobile"
                                                   name="mobile"
                                                   readonly
                                                   value="<?=isset($customer->mobile)?$customer->mobile : ''?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">使用时间</label>
                                        <div class="col-xs-6">
                                            <input type="text"
                                                   dt=true
                                                   class="form-control input-sm use_time"
                                                   name="use_time" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">备注</label>
                                        <div class="col-xs-8">
                                            <textarea name="des" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 label-control">订单总价</label>
                                        <div class="col-xs-4">
                                            <input type="text" id="total-price"
                                                   class="form-control input-sm" name="total_price" value="" readonly />
                                        </div>
                                    </div>

                                    <input type="hidden" class="goods_info" name="goods_info" value="" />
                                    <input type="hidden" class="bag_info" name="bag_info" value="" />
                                    <input type="hidden" class="tomb_id" name="tomb_id" value="<?=isset($tomb->id)?$tomb->id:''?>" />
                                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

                                    <div class="form-group">
                                        <label class="col-xs-2 label-control"></label>
                                        <div class="col-xs-4">
                                            <button class="btn btn-primary btn-sm" id="submitOrder" type="submit">提交订单</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css" media="screen">
        table.table-goods td{
            vertical-align: middle!important;
        }
    </style>

<script id="template" type="x-tmpl-mustache">

<tr class="gtr{{sku_id}} btr{{id}}" style="border-bottom:1px solid #eee;">
    <td><strong>{{ title }} {{sku_name}}</strong></li>
    <td><code>{{ num }}个</code></td>
    <td><span class="text-primary">¥{{ price }}/{{ totalPrice }}</span></td>
    <td><a class="del-goods btn btn-xs btn-danger" data-id="{{ sku_id }}" href="#">删除</a></td>
</tr>

</script>

<?php $this->beginBlock('foo') ?>
    $(function () {
        var bagSelect ={}, goodsSelect = {};
        var goodsSelectedBox = $('#goods-selected-box');
        var goodsListBox = $('#goods-list-box');
        var bagListBox = $('#bag-list-box');

        // 商品页面加减数量
        goodsListBox.on('click', 'button.btn-minus,button.btn-plus', function(e){
            e.preventDefault();

            var $this = $(this);
            var goodsItem = $this.parents('tr')
            var target = goodsItem.find('.gnum');
            var val = parseInt(target.val());
            var old_val = val;
            if ($this.hasClass('btn-minus')) {
                if (val > 0) {
                    target.val(--val);
                }
            } else{
                target.val(++val);
            }

            if ( val > 0 ) addToSelected(goodsItem);

            if (val == 0) {
                if (old_val>val) {
                    addToSelected(goodsItem);
                    $('.gtr' + goodsItem.find('.sku_id').val()).remove();
                }
            }
        });

        // 打包品加减数量
        bagListBox.on('click', 'button.btn-minus,button.btn-plus', function(e){
            e.preventDefault();

            var $this = $(this);
            var bagItem = $this.parents('tr')
            var target = bagItem.find('.gnum');
            var val = parseInt(target.val());
            var old_val = val;
            if ($this.hasClass('btn-minus')) {
                if (val > 0) {
                    target.val(--val);
                }
            } else{
                target.val(++val);
            }

            if ( val > 0 ) addToSelected(bagItem, true);

            if (val == 0) {
                if (old_val>val) {
                    addToSelected(bagItem, true);
                    $('.btr' + bagItem.data('id')).remove();
                }
            }
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



        // 添加选择商品
        function addToSelected(item, is_bag=false)
        {
            var id = item.data('id');
            var num = parseInt(item.find('input.gnum').val());

            if (is_bag) {
                var price = item.data('price');
            } else {

                var price = item.find('.sku_id option:selected').data('price');
                price = price ? price : item.find('.sku_id').data('price');
            }

            var totalPrice = price*num;
            var obj =  {
                'id'    : id,
                'title' : item.data('title'),
                'price' : price,
                'img'   : item.data('img'),
                'num'   : num,
                'totalPrice' : totalPrice
            };

            if (is_bag) {
                bagSelect[id] = obj;
            } else {
                obj.sku_name = $.trim(item.find('.sku_id option:selected').text());
                obj.sku_id = item.find('.sku_id').val();
                goodsSelect[obj.sku_id] = obj;
            }

            updateSelected();
            makeDatas();
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
                if(datas.num==0) continue;

                var rendered = Mustache.render(template, datas);
                itemBox.append(rendered);
            }

            for (key in bagSelect){
                var d = bagSelect[key];
                if(d.num == 0) continue;
                var bagrendered = Mustache.render(template, d);
                itemBox.append(bagrendered);
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

            var bagvalue = JSON.stringify(bagSelect);
            $('input[name=bag_info]').val(bagvalue);

            calPrice();
        }

        function calPrice()
        {
            var total = 0;
            for (i in goodsSelect) {
                total += goodsSelect[i].price * goodsSelect[i].num;
            }

            for (i in bagSelect) {
                total += bagSelect[i].price * bagSelect[i].num;
            }

            $("#total-price").val(total);
        }

        var pyh;
        var trs = $('tr.goods-tr');
        $('#py_search').keyup(function(e){ //拼音查找
            var $this = $(e.target);
            var pystr = $.trim($this.val());

            if (pystr == '') {
                trs.fadeIn(100);
                return;
            }

            if (typeof pyh != undefined ) {
                clearTimeout( pyh );
            }
            pyh = setTimeout(function(){
                trs.each(function(i, item){
                    var trElem = $(item);
                    var pinyin = trElem.data('pinyin');
                    var title = trElem.data("title");
                    var serial = trElem.data('serial');
                    try {
                        if (pinyin.indexOf(pystr) !=-1 || title.indexOf(pystr) != -1 || serial.indexOf(pystr) != -1) {
                            trElem.fadeIn(100);
                        } else {
                            trElem.fadeOut(100);
                        }
                    } catch (err) {
                        trElem.hide();
                    }
                });
            }, 500);
        });

        $('.grave,.trow,.tcol').change(function (e) {
            var grave = $('.grave').val();
            var row = $('.trow').val();
            var col = $('.tcol').val();

            if (!grave || !row || !col) {
                return ;
            }
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var data = {grave:grave,row:row,col:col,_csrf:csrf};
            $.post("<?=Url::toRoute(['/grave/admin/tomb/info'])?>",data,function(xhr){
                if (xhr.status) {
                    var tomb = xhr.data.tomb;
                    $('.tomb_id').val(tomb.id);

                    if (xhr.data.customer) {
                        var customer = xhr.data.customer;
                        $('.customer_name').val(customer.name);
                        $('.mobile').val(customer.mobile);
                    } else {
                        $('.customer_name').val('');
                        $('.mobile').val('');
                    }
                    $('.infonote').removeClass('text-danger').addClass('text-success').text("墓位状态:" + xhr.data.tombStatus);
                } else {
                    $('.tomb_id').val('');
                    $('.infonote').removeClass('text-success').addClass('text-danger').text(xhr.info);
                }
            },'json');
        });

        $('#submitOrder').click(function(){
            var tomb_id = $('.tomb_id').val();
            var goods = $('.goods_info').val();
            var bag = $('.bag_info').val();
            var use_time = $('.use_time').val();
            var op = $('.op_id').val();

            if (!bag && !goods){
                alert('请先选择商品');
                return false;
            }

            if (!tomb_id) {
                alert('请先填写有效墓位');
                return false;
            }

            if (!use_time) {
                alert('请填写使用时间');
                return false;
            }

            if (!op) {
                alert('请填写销售人');
                return false;
            }


        });

    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

