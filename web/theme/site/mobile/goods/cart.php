<div class="content" id="cart-box">
    <div class="cart_list">
        <div class="weui-panel weui-panel_access oneGood" v-for="item in items">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd" style="padding-left: 20px;">
                        <div class="check-wrapper" goodid="27">
                            <span class="cart-checkbox checked" state="1">
                                <input type="checkbox" autocomplete="off" name="sel_cartgoods[]" value="274" id="sel_cartgoods_274" checked="checked">
                            </span>
                        </div>
                        <img class="weui-media-box__thumb" src="/theme/site/static/images/58f1e76d6b023_64_64.jpg" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{item.goods_name}}</h4>
                        <p class="weui-media-box__desc">
                            <span>{{item.sku_name}}</span>
                            <span class="fr f-red">￥<span class="oneGoodPrice">{{item.price}}</span>元</span>
                        </p>
                        <div class="caozuo">
                            <div style="font-size: 0px;" class="weui-cell__ft">
                                <a class="number-selector number-selector-sub needsclick f-red" :skuid="item.sku_id">-</a>
                                <input class="number-input oneGoodNum" style="width: 50px;" :value="item.num" :skuid="item.sku_id">
                                <a class="number-selector number-selector-plus needsclick f-red" :skuid="item.sku_id">+</a>
                            </div>
                            <span class="fr sc sstfont sst-shanchu" sku_id="item.sku_id"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>

    <div class="payment-total-bar payment-total-bar-new box-flex-f" id="payment">
    <div class="shp-chk shp-chk-new  box-flex-c choose_all">
        <span class="cart-checkbox checked" id="checkIcon-1" state="1">
            <input type="checkbox" name="">
        </span>
        <span class="cart-checkbox-text">全选</span>
    </div>
    <div class="shp-cart-info shp-cart-info-new  box-flex-c">
        <strong id="shpCartTotal" data-fsizeinit="14" class="shp-cart-total" style="font-size: 14px;">
            合计:<span class="bottom-bar-price" id="cart_realPrice">¥990.00</span>
        </strong>
        <span id="saleOffNew" data-fsizeinit="10" class="sale-off sale-off-new  bottom-total-price" style="font-size: 10px;">
            总额:<span class="money-unit-bf" id="cart_oriPrice">3846.00</span>
            立减:<span class="money-unit-bf" id="cart_rePrice">66.96</span>
        </span>
    </div>
    <a class="btn-right-block btn-right-block-new  box-flex-c" id="submit">
        去结算<span id="checkedNum">(5)</span>
    </a>
</div>


<?php $this->beginBlock('news') ?>  
var demo = new Vue({
    el: '#cart-box',
    data: {
        items: [],
        apiUrl: 'http://api.lion.cn/v1/goods/cart-list',
        user:1
    },
    beforeMount: function() {
        this.getCart();
    },
    methods: {
        getCart:function(){
            var data = {user:this.user};
            this.$http.post(this.apiUrl, data,{emulateJSON:true}).then(function(response){
                this.$set(this, 'items',response.data);
            }, function(response){

            });
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       
