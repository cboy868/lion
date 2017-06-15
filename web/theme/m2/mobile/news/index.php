<style type="text/css">
  .xuetang_menu .swiper-slide{
    /*width:30%;*/
      padding: 0 10px;
  }
  .swiper-slide, .swiper-wrapper{
      width:auto;
  }

</style>
<div class="content" id="news-box">
    <div class="sortbox">
        <div class="weui-row">
            <div class="weui-col-25" v-for="(item, index) in nitems" >
                <a href="#"
                   :rid="item.id"
                   v-bind:class="{'on':item.id==clistParams.cid}"
                   @click="getNews"
                   v-text="item.name"
                ></a>
            </div>
        </div>
    </div>

    <div class="weui-panel weui-panel_access zixun_list">
        <div class="weui-panel__bd" id="listbox">
            <a v-bind:href="'/m/news/' + item.id +'.html'" class="weui-media-box weui-media-box_appmsg" v-for="item in clist">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" v-bind:src="item.cover" v-bind:alt="item.title">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title" v-text="item.title"></h4>
                    <p class="weui-media-box__desc" v-text="item.created_date"></p>
                </div>
            </a>
        </div>
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
</div>

<?php $this->beginBlock('news') ?>  
var demo = new Vue({
    el: '#news-box',
    data: {
        nitems: [],
        sendData:{fields:['id', 'name']},
        apiUrl: 'http://api.lion.cn/v1/news/cates',

        clistUrl : 'http://api.lion.cn/v1/news',
        clistParams : {page:1, pageSize:10},
        clist:[],
        pageCount:1,
        currentCate:0,
        loading:0
    },
    beforeMount: function() {
        this.getCates();
    },
    methods: {
        getCates: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.sendData}).then((response) => {
                this.$set(this, 'nitems', response.data);
                this.$set(this.clistParams, 'cid', this.nitems[0].id);
                this.getList();
            }).catch(function(response) {
                //console.log(response)
            })
        },
        getList: function(append=false) {
            this.$http.jsonp(this.clistUrl,{'jsonp':'lcb', params:this.clistParams}).then((response) => {
              if (append) {
                this.$set(this, 'clist', this.clist.concat(response.data.items));
              } else {
                this.$set(this, 'clist', response.data.items);
              }
              this.$set(this, 'pageCount', response.data.pageCount);
              this.$set(this, 'loading', 0);
            }).catch(function(response) {
                //console.log(response)
            })
        },
        getNews:function(event) {
          event.preventDefault();
          var cid = event.target.getAttribute('rid');
          this.$set(this.clistParams, 'cid', cid);
          this.$set(this.clistParams, 'page', 1);
          this.getList();
        },
        pullLoad:function(){
          var p = this.clistParams.page + 1;
          if (this.pageCount >= p) {
            this.$set(this.clistParams, 'page', p);
            this.getList(true);
            this.$set(this, 'loading', 1);
          }
        }
    }
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
