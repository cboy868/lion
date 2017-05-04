<div class="content" id="news-box">
    <div class="swiper-container" style="height: 200px;">
      <div class="swiper-wrapper">
        <div class="swiper-slide" v-for="img in item.imgs">
            <img :src="img.url" />
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <div class="goods_info_box goods_base">
        <div class="price_div">
            <span class="product-price1">
                ¥<span class="big-price">{{currentSku.price}}</span>
                <span class="small-price">元</span>
            </span>
            <!-- <span class="product-xiaoliang">已有0人购买</span> -->
        </div>
        <div class="tit_div">{{item.name}}<span>{{currentSku.name}}</span></div>
        <!-- <div class="prod-act">每位缘主都应该请一尊本命佛</div> -->
    </div>
   <div class="weui-cells">
        
        <div class="shuxingbox">
            <div class="weui-cell chooseshuxiang">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>请选择商品规格</p>
                </div>
                <div class="weui-cell__ft"><i class="sstfont sst-xiangshang"></i></div>
            </div>
            <div class="weui-cell">
                <div class="yListr">
                    <ul>
                        <li v-for="spec in specs" :sid="spec.attr_id">
                            <span>{{spec.attr_name}}</span>
                            <!-- <em class="yListrclickem">深灰色<i></i></em> -->
                            <em v-for="v in spec.child" :aid="spec.attr_id" 
                            :class="{'yListrclickem':currentSku.attr.indexOf(spec.attr_id + ':' + v.id)>=0}"  
                            :vid="v.id" @click="selSku">{{v.val}}<i></i></em> 
                        </li>
                    </ul>
                </div>
                
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>数量 <span style="color:red" v-show="currentSku.id==0">请先选择商品规格</span></p>
                </div>
                <div style="font-size: 0px;" class="weui-cell__ft"> 
                    <a class="number-selector number-selector-sub needsclick f-red" @click="skuSub">-</a>
                    <input class="number-input" style="width: 50px;" v-model="currentSku.num" :rid="currentSku.id" @change="skuChange">
                    <a class="number-selector number-selector-plus needsclick f-red" @click="skuPlus">+</a> 
                </div>
            </div>
                <a href="javascript:;" class="weui-btn weui-btn_primary"
                    :class="{'weui-btn_disabled':currentSku.id==0}" 
                  @click="toCart">加入购物车</a>
        </div>
    </div>

    <div class="content-padded">
        <div class="content-box">
            <p v-html="item.intro"></p> 
        </div>
        <br>
        <h5>温馨提示</h5>
        <hr>
        <div class="content-box" >
            <p v-html="item.skill"></p>
        </div>
    </div>
</div>



<?php $this->beginBlock('news') ?>  
var demo = new Vue({
    el: '#news-box',
    data: {
        item: [],
        apiUrl: 'http://api.lion.cn/v1/goods/<?=$get['id']?>',
        cartUrl: 'http://api.lion.cn/v1/goods/cart',
        specs:[],
        currentSku:{id:0, price:1, num:1,attr:'',total_num:1},
        skus:[],
        result:[]
    },
    beforeMount: function() {
        this.getGoods();
    },
    mounted:function(){
        var mySwiper = new Swiper('.swiper-container', {
           //direction: 'horizontal',
           loop: true,
           autoplay: 3000,
           pagination: '.swiper-pagination',
        })
    },
    methods: {
        getGoods: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb'}).then((response) => {
                this.$set(this, 'item', response.data.item);
                this.$set(this, 'specs', response.data.specs);

                var speclength = Object.keys(response.data.specs).length;
                //初始化数据
                this.currentSku.price = this.item.price;

                if (speclength == 0) {
                    var sku = response.data.skus['0:0']
                    this.currentSku.attr = '0:0';
                    this.currentSku.id = sku.id;
                    this.currentSku.price = sku.price;
                    this.currentSku.num = 1;
                    this.currentSku.total_num = sku.num ? sku.num : 1;
                    this.currentSku.name = sku.name;

                }  else {
                    //sku数据存储
                    var skus = {};
                    var tmp_skus = response.data.skus;
                    for (i in tmp_skus) {
                        skus[tmp_skus[i].av] ={
                            'id' : tmp_skus[i].id,
                            'price' : tmp_skus[i].price,
                            'total_num' : tmp_skus[i].num,
                            'name' : tmp_skus[i].name
                        };
                    }
                    this.$set(this, 'skus', skus);
                }

            }).catch(function(response) {
                console.log(response)
            })
        },
        skuSub: function(){
            if (this.currentSku.num>1) {
                this.currentSku.num--;
            }
        },
        skuPlus: function(){
            this.currentSku.num++;
            if (this.currentSku.num >= this.currentSku.total_num) {
                this.currentSku.num = this.currentSku.total_num;
            }
        },
        skuChange: function(event){
            if (event.target.value <= 0 || isNaN(event.target.value)) {
                this.currentSku.num = 1;
            } else {
                this.currentSku.num = event.target.value;
            }
        },
        selSku: function(e){
            var el = e.target;
            var skus = this.skus;
            var aid = el.getAttribute('aid');
            var vid = el.getAttribute('vid');

            this.result[aid] = {
                'av' : aid+':'+vid
            }
            var r = this.parseAttr();

            if (this.skus[r]) {
                this.currentSku.attr = r;
                this.currentSku.id = this.skus[r].id;
                this.currentSku.price = this.skus[r].price;
                this.currentSku.num = 1;
                this.currentSku.total_num = this.skus[r].total_num;
                this.currentSku.name = this.skus[r].name;
            } else {
                this.currentSku.attr = aid+':'+vid;
            }

        },
        parseAttr:function(){
            var attr = this.result;
            var tmp_attr = '';
            for (i in attr) {
                tmp_attr = tmp_attr ? tmp_attr +';'+ attr[i].av : attr[i].av;
            }
            return tmp_attr;
        },
        toCart:function(){
            var data = {sku_id:this.currentSku.id,num:this.currentSku.num,user:1};
            this.$http.post(this.cartUrl, data,{emulateJSON:true}).then(function(response){
                //console.dir(response);
            }, function(response){

            });
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       
