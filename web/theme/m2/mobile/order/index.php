<div class="content" id="order-box">
    <div class="page preview js_show">
        <div class="page__bd">
            <div class="weui-form-preview" style="margin-bottom: 5px;" v-for="item in orders">
                <div class="weui-form-preview__hd">
                    <label class="weui-form-preview__label">卓迅</label>
                    <em class="weui-form-preview__value">
                        <a href="#" ><i class="sstfont sst-shanchu" v-on:click="delOrder" :order_id="item.id" ></i></a>
                    </em>
                </div>
                <div class="weui-form-preview__bd">
                    <div class="weui-form-preview__item" style="text-align: left">
                        <img :src="rel.cover" :alt="rel.title" style="width:45px;height:45px;" v-for="rel in item.rels">
                    </div>
                    <div class="weui-form-preview__item">
                        <span class="weui-form-preview__value">共{{Object.keys(item.rels).length}}种商品，实付款：￥{{item.price}} {{item.created_date}} </span>
                    </div>
                </div>
                <div class="weui-form-preview__ft">
                    <button type="submit" v-if="item.progress >= 5" class="weui-form-preview__btn weui-form-preview__btn_default" href="javascript:">评价晒单</button>
                    <button type="submit" v-if="item.progress < 5" class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">支付</button>
                    <button type="submit" v-if="item.progress >= 5" class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">再次购买</button>
                </div>
            </div>
        </div>
    </div>


    <div class="button_load" v-show="pageCount>sendData.page">
          <a href="javascript:;" @click="pullLoad" class="weui-btn weui-btn_default">加载更多</a>
        </div>
        <div class="weui-loadmore weui-loadmore_line" v-show="pageCount==sendData.page">
          <span class="weui-loadmore__tips">暂无数据</span>
        </div>
        <div class="weui-loadmore" v-show="loading"> <!--如有需要可增加style="display: none"-->
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载...*\(^_^)/*</span>
        </div>

        <div class="clearfix"></div>
</div>



<?php $this->beginBlock('order') ?>  
var demo = new Vue({
    el: '#order-box',
    data: {
        orders: [],
        sendData:{relThumbSize:'60x60',user:1,page:1,pageSize:3 },
        apiUrl: 'http://api.ibagou.com/v1/order/list',
        apiDel: 'http://api.ibagou.com/v1/order/del',
        pageCount:1,
        loading:0
    },
    beforeMount: function() {
        this.getOrders();
    },
    methods: {
        getOrders: function(append=false) {
            this.$http.post(this.apiUrl + '?page=' + this.sendData.page, this.sendData,{emulateJSON:true}).then(function(response){
                if (append) {
                    this.$set(this, 'orders', this.orders.concat(response.data.items));
                } else {
                    this.$set(this, 'orders', response.data.items);
                }
                this.$set(this, 'pageCount', response.data.pageCount);
                this.$set(this, 'loading', 0);
            }, function(response){
            });
        },
        pullLoad:function(){
          var p = this.sendData.page + 1;
          if (this.pageCount >= p) { 
            this.$set(this.sendData, 'page', p);
            this.getOrders(true);
            this.loading = 1;
          }
        },
        delOrder:function(event){
            event.preventDefault();
            if (!confirm('您确定要删除此项吗?')){
                return ;
            }
            var oid = event.target.getAttribute('order_id');
            var data={order_id:oid};
            this.$http.post(this.apiDel, data,{emulateJSON:true}).then(function(response){

                var newArr = this.orders.filter(function(obj){
                  return (oid != obj.id);
                });

                this.$set(this,'orders', newArr);
            }, function(response){
            });
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  
