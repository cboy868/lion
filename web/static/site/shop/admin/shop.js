$(function () {
    var bagSelect ={}, goodsSelect = {};
    var goodsSelectedBox = $('#goods-selected-box');
    var goodsListBox = $('#goods-list-box');
    var bagListBox = $('#bag-list-box');

    // 商品页面加减数量
    goodsListBox.on('click', 'button.btn-minus,button.btn-plus', function(e){
        e.preventDefault();

        var $this = $(this);
        var goodsItem = $this.parents('tr');
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
        var bagItem = $this.parents('tr');
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
    });

    // 添加选择商品
    function addToSelected(item, is_bag)
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
        var csrf = $('meta[name="csrf-token"]').attr('content');
        var data = {grave:grave,row:row,col:col,_csrf:csrf};
        var url = $('.uri').val();
        $.post(url,data,function(xhr){
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
            }2
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