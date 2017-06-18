<?php 
$this->title="商城";
?>
<div class="content" id="news-box">
    <div class="weui-grids"> </div>
     <div class="sortbox">
        <div class="weui-row">
            <div class="weui-col-25" v-for="cate in nitems">
                <a href="#" 
                    :rid="cate.id" 
                    v-bind:class="{'on':cate.id==clistParams.cid}"
                    @click="getGoods"
                    v-text="cate.name"
                    ></a>
            </div>
        </div>
    </div>
    <div class="spbox">
        <ul class="sp_list" id="goodslist">
            <li v-for="goods in clist">
                <a :href="'/m/product/' + goods.id+'.html'" title="">
                    <div class="pic_div"><img :src="goods.cover" style="height: 188px;"></div>
                    <div class="tit_div" v-text="goods.name"></div>
                    <div class="price_div">
                        <span class="product-price pull-left">¥<span class="big-price" v-text="goods.price"></span>
                            <span class="small-price"></span>
                        </span>
                        <!--
                        <div style="font-size: 0px;" class="weui-cell__ft pull-right"> 
                            <button class="f-red" style="background: #fff;border: none;">
                                <span class="sstfont sst-gouwuche"></span>
                            </button> 
                        </div>
                        -->
                    </div>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div>

        <div class="button_load" v-show="pageCount>clistParams.page">
          <a href="javascript:;" @click="pullLoad" class="weui-btn weui-btn_default">加载更多</a>
        </div>
        <div class="weui-loadmore weui-loadmore_line" v-show="pageCount==clistParams.page">
          <span class="weui-loadmore__tips">暂无数据</span>
        </div>
        <div class="weui-loadmore" v-show="loading"> <!--如有需要可增加style="display: none"-->
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载...*\(^_^)/*</span>
        </div>

        <div class="clearfix"></div>
</div>


<?php $this->beginBlock('news') ?>  
var demo = new Vue({
    el: '#news-box',
    data: {
        nitems: [],
        sendData:{fields:['id', 'name']},
        apiUrl: 'http://api.lion.cn/v1/goods/cates',

        clistUrl : 'http://api.lion.cn/v1/goods',
        clistParams : {cid:1, page:1, pageSize:10},
        clist:[],
        pageCount:1,
        loading:0
    },
    beforeMount: function() {
        this.getCates();
    },
    methods: {
        getCates: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.sendData}).then((response) => {
                this.$set(this, 'nitems', response.data);
                this.clistParams.cid = this.nitems[0].id;
                this.getCList();
            }).catch(function(response) {
                console.log(response);
            })
        },
        getCList: function(append=false) {
            this.$http.jsonp(this.clistUrl,{'jsonp':'lcb', params:this.clistParams}).then((response) => {
              if (append) {
              console.dir(response.data.items);
                this.$set(this, 'clist', this.clist.concat(response.data.items));
              } else {
                this.$set(this, 'clist', response.data.items);
              }

              this.$set(this, 'pageCount', response.data._meta.pageCount);
              this.$set(this, 'loading', 0);
            }).catch(function(response) {
                //console.log(response)
            })
        },
        getGoods:function(event) {
          event.preventDefault();
          var cid = event.target.getAttribute('rid');
          this.clistParams.cid = cid;
          this.clistParams.page = 1;

          this.getCList();
        },
        pullLoad:function(){
          var p = this.clistParams.page + 1;
          if (this.pageCount >= p) { 
            this.clistParams.page = p;
            this.getCList(true);
            this.loading = 1;
          }
        }
    }
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
