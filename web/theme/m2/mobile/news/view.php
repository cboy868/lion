<?php
$this->title="新闻资讯";
?>
<div class="content" id="news-box">
  <article class="weui-article">
    <h1 class="sst_article" v-text="item.title"></h1>
    <div class="sst_article_meta" v-text="item.created_at"></div>
    <section v-html="item.body"></section>
  </article>
  <div class="weui-panel weui-panel_access zixun_list">
      <div class="weui-panel__hd">热门推荐</div>
      <div class="weui-panel__bd" id="listbox">
        <a :href="'/m/news/' + it.id +'.html'" class="weui-media-box weui-media-box_appmsg" v-for="it in recommend">
          <div class="weui-media-box__hd">
              <img class="weui-media-box__thumb" :src="it.cover" alt="">
          </div>
          <div class="weui-media-box__bd">
              <h4 class="weui-media-box__title" v-text="it.title"></h4>
              <p class="weui-media-box__desc" v-text="it.created_date"></p>
          </div>
      </a>
      </div>        
  </div>
</div>

<?php $this->beginBlock('news') ?>
var id = "<?=Yii::$app->request->get('id');?>";
var demo = new Vue({
    el: '#news-box',
    data: {
        item: [],
        recommend:[],
        sendData:{recommend:true},
        apiUrl: 'http://api.lion.cn/v1/news/' + id,
    },
    beforeMount: function() {
        this.getNews();
        this.getRecommend();
    },
    methods: {
        getNews: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb'}).then((response) => {
              var item = response.data.data;
              item.created_at = this.goodTime(item.created_at * 1000);
                this.$set(this, 'item', item);
            }).catch(function(response) {
                console.log(response)
            })
        },
        getRecommend:function(){
          this.$http.jsonp('http://api.lion.cn/v1/news',{'jsonp':'lcb',params:this.sendData}).then((response) => {
            this.$set(this, 'recommend', response.data.items);
            console.dir(response.data.items);
          }).catch(function(response) {
            console.log(response)
          })
        },
        goodTime: function(str){
          var now = new Date().getTime(),
              oldTime = new Date(str).getTime(),
              difference = now - oldTime,
              result='',
              minute = 1000 * 60,
              hour = minute * 60,
              day = hour * 24,
              halfamonth = day * 15,
              month = day * 30,
              year = month * 12,

              _year = difference/year,
              _month =difference/month,
              _week =difference/(7*day),
              _day =difference/day,
              _hour =difference/hour,
              _min =difference/minute;
               if(_year>=1) {result= "发表于 " + ~~(_year) + " 年前"}
          else if(_month>=1) {result= "发表于 " + ~~(_month) + " 个月前"}
          else if(_week>=1) {result= "发表于 " + ~~(_week) + " 周前"}
          else if(_day>=1) {result= "发表于 " + ~~(_day) +" 天前"}
          else if(_hour>=1) {result= "发表于 " + ~~(_hour) +" 个小时前"}
          else if(_min>=1) {result= "发表于 " + ~~(_min) +" 分钟前"}
          else result="刚刚";
          return result;
      }
    }
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
       
