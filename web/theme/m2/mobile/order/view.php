<?php
$this->title="订单详情页面";
?>
<div class="content" id="order-box">
    <div class="page preview js_show">
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>订单号: <span v-text="order.id"></span></p>
            </div>
            <div class="weui-cell__ft" style="color:red" v-text="order.progress"></div>
          </div>
        </div>
        <div class="weui-panel__ft">
            <a href="javascript:void(0);" class="weui-cell weui-cell_access weui-cell_link">
              <div class="weui-cell__bd">感谢您在<?=g("cp_name")?>购物，欢迎再次光临!</div>
              <span class="weui-cell__ft"></span>
            </a>    
        </div>

        <div class="page__bd">
            <div class="weui-panel weui-panel_access" v-for="rel in rels">
                <div class="weui-panel__bd">
                    <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb" :src="rel.cover" alt="">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title" >
                                <span v-text="rel.title"></span>
                                <span class="pull-right" v-text="'￥' + rel.price"></span>
                            </h4>
                            <p class="weui-media-box__desc">
                                数量: <span v-text="rel.num"></span> <span v-text="rel.sku_name"></span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="weui-cells">
            <!--
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>支付方式</p>
            </div>
            <div class="weui-cell__ft">{{order.pay_type}}</div>
          </div>
          -->
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>订单日期</p>
            </div>
            <div class="weui-cell__ft" v-text="order.created_date"></div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>商品总额</p>
            </div>
            <div class="weui-cell__ft" v-text="'￥'+order.price"></div>
          </div>
          <div class="weui-cell pull-right">
            <div class="weui-cell__ft">实付款：￥ <span v-text="order.price"></span></div>
          </div>


        </div>
        <a href="javascript:;" class="weui-btn weui-btn_primary">付款</a>
    </div>
</div>


<?php $this->beginBlock('order') ?>
var id = '<?=Yii::$app->request->get('id')?>';
var demo = new Vue({
    el: '#order-box',
    data: {
        order: [],
        rels:[],
        sendData:{thumb:'35x24',expand:'rels'},
        apiUrl: base_url +'order/view?id=' + id,
    },
    beforeMount: function() {
        this.getOrder();
    },
    methods: {
        getOrder: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb',params:this.sendData}).then((response) => {

                this.$set(this, 'order', response.data.data.order);
                this.$set(this, 'rels', response.data.data.rels);
            }).catch(function(response) {
            })
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  
