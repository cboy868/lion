<?php
use yii\helpers\Url;
$this->title="商品详情";
$wid = Yii::$app->request->get('wid');
?>
<style>
    .concern-cart>div>p{
        font-size:10px;
    }
    .concern-cart>div{
        float: left;
        text-align: left;
        margin-top: 10px;
    }
</style>
<div class="content" id="news-box">
    <div class="swiper-container" style="height: 200px;">
      <div class="swiper-wrapper">
        <div class="swiper-slide" v-for="img in item.image">
            <img :src="img" />
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <div class="goods_info_box goods_base">
        <div class="price_div">
            <span class="product-price1">
                ¥<span class="big-price" v-text="currentSku.price"></span>
                <span class="small-price">元</span>
            </span>
        </div>
        <div class="tit_div" v-text="item.name">
            <span v-text="currentSku.name"></span>
        </div>
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
                            <span v-text="spec.attr_name"></span>
                            <em v-for="v in spec.child" :aid="spec.attr_id"
                            :class="{'yListrclickem':currentSku.attr.indexOf(spec.attr_id + ':' + v.id)>=0}"  
                            :vid="v.id" @click="selSku" v-text="v.val"><i></i></em>
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


<div id="cart1" class="cart-concern-btm-fixed five-column four-column" style="display: table;">
        <div class="concern-cart">
            <a class="cart-car-icn" id="toCart" href="/m/product/cart?wid=<?=$wid?>">
                 <em class="btm-act-icn" id="shoppingCart">
                     <i class="order-numbers" v-text="nums.goods_num"></i>
                 </em>
                <span class="focus-info">购物车</span>
            </a>
            <div>
                <p><span v-text="nums.type_num"></span>种<span v-text="nums.goods_num"></span>件商品</p>
                <p>总价<span v-text="nums.total_price"></span>元</p>
            </div>

        </div>

        <div class="action-list">
            <a href="javascript:;" class="yellow-color"
               :class="{'weui-btn_disabled':currentSku.id==0}"
               @click="toCart">加入购物车
            </a>
            <a href="javascript:;" class="red-color">立即购买</a>
        </div>
    </div>

</div>

<?php $this->beginBlock('news') ?>

var id = <?=Yii::$app->request->get('id')?>;
var uid = "<?=$wechat['user_id']?>";
var demo = new Vue({
    el: '#news-box',
    data: {
        item: [],
        sendData:{expand:'spec,image,sku'},
        apiUrl: base_url +'goods/' + id,
        cartUrl: base_url +'goods/cart',
        carCountUrl: base_url +'goods/cart-count',
        specs:[],
        currentSku:{id:0, price:1, num:1,attr:'',total_num:1},
        skus:[],
        result:[],
        user:uid,
        nums:[]
    },
    beforeMount: function() {
        this.getGoods();
        this.getCartCount();
    },
    mounted:function(){
        var mySwiper = new Swiper('.swiper-container', {
           loop: true,
           autoplay: 3000,
           pagination: '.swiper-pagination',
            observer:true,//修改swiper自己或子元素时，自动初始化swiper
            observeParents:true,//修改swiper的父元素时，自动初始化swiper
        })
    },
    methods: {
        getGoods: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb',params:this.sendData}).then((response) => {
                this.$set(this, 'item', response.data);
                this.$set(this, 'specs', response.data.spec.spec);
                var speclength = Object.keys(response.data.spec.spec).length;
                //初始化数据
                this.currentSku.price = this.item.price;

                if (speclength == 0) {
                    var sku = response.data.sku['0:0']
                    var tp = {
                        attr:'0:0',
                        id:sku.id,
                        price:sku.price,
                        num:1,
                        total_num:sku.num ? sku.num : 1,
                        name:sku.name
                    };

                    this.$set(this, 'currentSku', tp);
                }  else {
                    //sku数据存储
                    var skus = {};
                    var tmp_skus = response.data.sku;
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
                //console.log(response)
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
                //this.$set(this.currentSku, 'num', this.currentSku.total_num);
            }
        },
        skuChange: function(event){
            if (event.target.value <= 0 || isNaN(event.target.value)) {
                this.$set(this.currentSku, 'num', 1);
            } else {
                this.$set(this.currentSku, 'num', event.target.value);
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
                var tp = {
                    attr:r,
                    id:this.skus[r].id,
                    price:this.skus[r].price,
                    num:1,
                    total_num:this.skus[r].total_num,
                    name:this.skus[r].name
                };
                this.$set(this, 'currentSku', tp);
            } else {
                this.$set(this.currentSku, 'attr', aid+':'+vid)
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
            if (!uid) {
                $.toptip('请先去<a style="font-weight: 800;" href="<?=Url::toRoute(['/user/m/default/profile', 'wid'=>$wid])?>"> 个人中心>个人设置</a> 中绑定或创建账号', 'error');return;
            }

            var data = {sku_id:this.currentSku.id,num:this.currentSku.num,user:uid};
            this.$http.post(this.cartUrl, data,{emulateJSON:true}).then(function(response){
                this.getCartCount();
            }, function(response){

            });
        },
        getCartCount:function(){
            if (!uid) {
                return;
            }
            this.$http.jsonp(this.carCountUrl,{'jsonp':'lcb',params:{user:uid}}).then((response) => {
                //console.dir(parseInt(response.data));
                this.$set(this.nums, 'goods_num', response.data.goods_num);
                this.$set(this.nums, 'type_num', response.data.type_num);
                this.$set(this.nums, 'total_price', response.data.total);
            }).catch(function(response) {
                //console.log(response)
            })
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       
