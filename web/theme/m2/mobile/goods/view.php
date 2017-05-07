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
        <div class="concern-cart"> <a class="dong-dong-icn J_ping" id="imBottom" href="#"> <em class="btm-act-icn"></em> <span class="focus-info"> 客服 </span> </a>
            <a class="love-heart-icn J_ping" id="payAttention" onclick="doFav(1)">
                <div class="focus-container" id="focusOn">
                    <div class="focus-icon">
                        <i class="bottom-focus-icon  focus-out" id="attentionFocus"></i>
                    </div>
                    <span class="focus-info"> 关注 </span>
                </div>
            </a>
            <a class="cart-car-icn" id="toCart" href="/m/goods/cart">
                 <em class="btm-act-icn" id="shoppingCart"> <i class="order-numbers" v-text="nums.type_num"></i> </em> <span class="focus-info">购物车</span>
            </a>
        </div>
        <script>
            function doFav(info_id) {
                var MID = "0";
                if (MID != 0) {
                    var url ="/shop/index/dofav.html"
                    $.post(url, {'id': info_id}, function (msg) {
                        var btn = $('#store_btn_fav_' + info_id);
                        if (msg.status == 1) {
                            $.toast('收藏成功。');

                            btn.removeClass('c_fav_likebf');
                            btn.addClass('c_fav_liked');
                            btn.attr('title', '取消收藏');
                            btn.text('取消收藏')

                        }
                        else if (msg.status == 2) {
                            $.toast('取消收藏成功。');
                            btn.attr('title', '收藏');
                            btn.addClass('c_fav_likebf');
                            btn.removeClass('c_fav_liked');
                            btn.text('加入收藏')
                        }
                        else if (msg.status == 3) {
                            $.toast('不能收藏自己发布的内容。');
                        }
                        else {
                            $.toast('未知情况，处理失败。');
                        }
                    }, 'json');
                }
                else {
                    $.toast('请登陆后收藏。');
                }
            }
        </script>
        <div class="action-list">


            <a href="javascript:;" class="yellow-color" :class="{'weui-btn_disabled':currentSku.id==0}"  @click="toCart">加入购物车</a>
            <a href="javascript:;" class="red-color">立即购买</a>

            <a class="yellow-color J_ping" id="looksimilar" href="#" style="display: none;">查看相似</a>
            <a class="red-color J_ping" id="arrivalInform" style="display: none;">到货通知</a>
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
        carCountUrl: 'http://api.lion.cn/v1/goods/cart-count',
        specs:[],
        currentSku:{id:0, price:1, num:1,attr:'',total_num:1},
        skus:[],
        result:[],
        user:1,
        nums:[]
    },
    beforeMount: function() {
        this.getGoods();
        this.getCartCount();
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
                this.$set(this.currentSku, 'num', this.currentSku.total_num);
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
            var data = {sku_id:this.currentSku.id,num:this.currentSku.num,user:1};
            this.$http.post(this.cartUrl, data,{emulateJSON:true}).then(function(response){
                this.getCartCount();
            }, function(response){

            });
        },
        getCartCount:function(){
            this.$http.jsonp(this.carCountUrl,{'jsonp':'lcb',params:{user:1}}).then((response) => {
                //console.dir(parseInt(response.data));
                this.$set(this.nums, 'goods_num', response.data.goods_num);
                this.$set(this.nums, 'type_num', response.data.type_num);
            }).catch(function(response) {
                console.log(response)
            })
        }
    }
})

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       

<script>
    // function refresh_carNum(num){
    //     $('#carNum').text(num);
    // }

    // function add_to_cart( info_id, rightnow ) {
    //      var addcart_url="/shop/index/cart_add_item.html";
    //      var directbuy_url="/shop/index/cart.html";
    //     $.post(addcart_url, {good_id: info_id, count: $('#qty_num').val()}, function (msg) {
    //             //console.log(msg);return false;
    //              if (msg.status) {
    //                      if (rightnow && msg.status==1) {
    //                          location.replace(directbuy_url);
    //                      }
    //                      else {
    //                          if(msg.status==1){
    //                              $.toast("加入购物车成功");
    //                              refresh_carNum( msg.cart_count );
    //                          }else if(msg.status=='-1'){
    //                              $.toast("购买商品时输入的数量不合法");
    //                          }else if(msg.status=='-2'){
    //                              $.toast("没有登陆,请先登陆");
    //                              window.location ="/login";
    //                          }else if(msg.status=='-3'){
    //                              $.toast("库存不足！");
    //                          }
    //                          else{
    //                              $.toast("添加到购物车失败");
    //                          }
    //                      }
    //              } else {
    //                  $.toast('添加到购物车失败。');
    //              }
    //      }, 'json');
    // }

    // $(document).ready(function(){
    //     var addto_cart=$('#add_cart');
    //     var direc_buy=$('#directorder');
    //     var good_id=1;
    //     addto_cart.click(function(){
    //         add_to_cart(good_id);
    //     });
    //     direc_buy.click(function(){
    //         add_to_cart(good_id,true)
    //     });
    // });
</script>