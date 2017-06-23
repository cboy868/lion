<?php
$this->title="购物车";
$wid = Yii::$app->request->get('wid');
?>
<div class="content" id="cart-box">
    <div class="cart_list">
        <div class="weui-panel weui-panel_access oneGood" v-for="item in items">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd" style="padding-left: 20px;">
                        <div class="check-wrapper">
                            <span class="cart-checkbox"
                            :class="{'checked':sels.indexOf(item.sku_id) !== -1}"
                             @click.prevent="selGoods" :sku-id="item.sku_id">
                                <!-- <input type="checkbox" autocomplete="off" v-model="sels"  style="display: none;"> -->
                            </span>
                        </div>
                        <img class="weui-media-box__thumb" src="/theme/site/static/images/58f1e76d6b023_64_64.jpg" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title" v-text="item.goods_name"></h4>
                        <p class="weui-media-box__desc">
                            <span v-text="item.sku_name"></span>
                            <span class="fr f-red">￥<span class="oneGoodPrice" v-text="item.price"></span>元</span>
                        </p>
                        <div class="caozuo">
                            <div style="font-size: 0px;" class="weui-cell__ft">
                                <a class="number-selector number-selector-sub needsclick f-red" :skuid="item.sku_id" @click="skuSub">-</a>
                                <input class="number-input oneGoodNum" style="width: 50px;" :value="item.num" :skuid="item.sku_id">
                                <a class="number-selector number-selector-plus needsclick f-red" :skuid="item.sku_id" @click="skuPlus">+</a>
                            </div>
                            <span class="fr sc" :sku_id="item.sku_id" @click="delCart"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="payment-total-bar payment-total-bar-new box-flex-f" id="payment">
    <!-- <div class="shp-chk shp-chk-new  box-flex-c choose_all">
        <span class="cart-checkbox checked" id="checkIcon-1" state="1">
            <input type="checkbox" name="">
        </span>
        <span class="cart-checkbox-text">全选</span>
    </div> -->
    <div class="shp-cart-info shp-cart-info-new  box-flex-c">
        <strong id="shpCartTotal" data-fsizeinit="14" class="shp-cart-total" style="font-size: 14px;">
            合计:<span class="bottom-bar-price" id="cart_realPrice">¥ <span v-text="result.total"></span></span>
        </strong>
        <span id="saleOffNew" data-fsizeinit="10" class="sale-off sale-off-new  bottom-total-price" style="font-size: 10px;">
            总额:<span class="money-unit-bf" id="cart_oriPrice" v-text="result.o_total"></span>
            立减:<span class="money-unit-bf" id="cart_rePrice" v-text="result.o_total - result.total"></span>
        </span>
    </div>
    <a class="btn-right-block btn-right-block-new  box-flex-c" @click="order">
        去结算<span>({{result.goods_num}})</span>
    </a>
</div>
    </div>

<?php $this->beginBlock('news') ?>
var uid = "<?=$wechat['user_id']?>";
var demo = new Vue({
    el: '#cart-box',
    data: {
        items: [],
        apiUrl: base_url +'goods/cart-list',
        cartUrl: base_url +'goods/update-cart',
        carCountUrl:base_url +'goods/cart-count',
        delCartUrl:base_url +'goods/del-cart',
        buyUrl:base_url +'order/buy',
        user:uid,
        sels:[],
        result:[]
    },
    beforeMount: function() {
        this.getCart();
        this.getCartCount();
    },
    methods: {
        getCart:function(){
            var data = {user:this.user};
            this.$http.post(this.apiUrl, data,{emulateJSON:true}).then(function(response){
                this.$set(this, 'items',response.data);
                this.$set(this, 'sels', []);
                for (i in response.data){
                    this.selSku(response.data[i].sku_id, true);
                }
            }, function(response){

            });
        },
        selGoods:function(e){
            var sku_id = e.target.getAttribute('sku-id');
            this.selSku(sku_id);
            this.calPrice();
        },
        skuSub: function(e){
            var sku_id = e.target.getAttribute('skuid');
            var num = this.items[sku_id].num;
            if (num>1) {
                this.$set(this.items[sku_id], 'num', num-1);
                this.selSku(sku_id, true);
            } else {
                this.$set(this.items[sku_id], 'num', 0);
                //this.selSku(sku_id, false);
            }
            //this.updateCart();
            this.calPrice();
        },
        skuPlus: function(e){
            var sku_id = e.target.getAttribute('skuid');
            var num = this.items[sku_id].num;
            this.$set(this.items[sku_id], 'num', parseInt(num)+1);
            this.selSku(sku_id, true);
            //this.updateCart();
            this.calPrice();
        },
        selSku:function(sku_id, flag){

            if (this.sels.indexOf(sku_id) != -1) {
                if (flag == true) {
                    return;
                }
                var index = this.sels.indexOf(sku_id);
                this.sels.splice(index,1);
            } else {
                if (flag == false) {
                    return;
                }
                this.sels.push(sku_id);
            }
        },
        updateCart() {
            var items = this.items;
            var sels = this.sels;
            var data = {params:[],user:this.user};
            for (i in sels) {
                data['params'][i] = {
                    sku_id : sels[i],
                    num : items[sels[i]].num,
                    id : items[sels[i]].id
                };
            }

            this.$http.post(this.cartUrl, data,{emulateJSON:true}).then(function(response){
                this.getCartCount();
            }, function(response){

            });
        },
        getCartCount:function(){
            this.$http.jsonp(this.carCountUrl,{'jsonp':'lcb',params:{user:this.user}}).then((response) => {
                //console.dir(parseInt(response.data));
                this.$set(this, 'result', response.data);

            }).catch(function(response) {
                //console.log(response)
            })
        },
        calPrice:function(){
            var sels = this.sels;
            var o_total = total =goods_num = type_num = 0;
            //console.dir(sels);
            //console.dir(this.items);
            for (i in sels) {
                var item = this.items[sels[i]];
                o_total += item.original_price * item.num;
                total += item.price * item.num;
                type_num++;
                goods_num += parseInt(item.num);
            }

            var result = {
                total : total,
                o_total:o_total,
                goods_num:goods_num,
                type_num:type_num
            };

            this.$set(this, 'result', result);
        },
        delCart:function(e){
            if (!confirm('确定要删除此项')) {
                return;
            }
            var sku_id = e.target.getAttribute('sku_id');
            this.delCartSku(sku_id);
        },
        delCartSku:function(sku_id){
            var data = {user:this.user,sku_id:sku_id};

            this.$http.post(this.delCartUrl, data,{emulateJSON:true}).then(function(response){
                this.getCart();
                this.getCartCount();

            }, function(response){

            });
        },
        order:function(){
            var items = this.items;
            var sels = this.sels;
            var data = {params:[],user:this.user};
            for (i in sels) {
                data['params'][i] = {
                    sku_id : sels[i],
                    num : items[sels[i]].num,
                    id : items[sels[i]].id
                };
            }

            this.$http.post(this.buyUrl, data,{emulateJSON:true}).then(function(response){
                location.replace('/m/order/'+ response.data.order.id);
            }, function(response){

            });
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       
