<?php 
use app\core\helpers\Html;
use app\core\helpers\Url;

\app\assets\VueAsset::register($this);
?>
<div class="content">
    <div class="swiper-container" style="height: 200px;">
      <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/theme/site/static/images/s1.png" /></div>
        <div class="swiper-slide"><img src="/theme/site/static/images/s1.png" /></div>
        <div class="swiper-slide"><img src="/theme/site/static/images/s1.png" /></div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <div class="weui-grids whitebg" style="margin-top:5px; padding-top:0px;">
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/s1.png" alt="生辰八字">
            </div>
            <p class="weui-grid__label">业务办理</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/s2.png" alt="周公解梦">
            </div>
            <p class="weui-grid__label">纪念馆</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/shouji.png" alt="手机吉凶测算">
            </div>
            <p class="weui-grid__label">绑定账号</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/name.png" alt="姓名测算">
            </div>
            <p class="weui-grid__label">一键导航</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/m9.png" alt="今日黄历">
            </div>
            <p class="weui-grid__label">投诉建议</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/site/static/images/m8.png" alt="在线起名">
            </div>
            <p class="weui-grid__label">订单记录</p>
        </a>
    </div>
    <!--banner 结束-->
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">公司新闻</div>
            <div class="weui-panel__bd" id="news-box">
                <a v-bind:href="'/m/news/' + item.id +'.html'" class="weui-media-box weui-media-box_appmsg" v-for="item in nitems">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" v-bind:src="item.cover" v-bind:alt="item.title">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{item.title}}</h4>
                        <p class="weui-media-box__desc">{{item.summary}}</p>
                    </div>
                </a>
            </div>
            <div class="weui-panel__ft">
                <a href="/m/news" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">查看更多</div>
                    <span class="weui-cell__ft"></span>
                </a>    
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('news') ?>  
var demo = new Vue({
    el: '#news-box',
    data: {
        gridColumns: ['title', 'author', 'id'],
        nitems: [],
        sendData:{limit:5, thumbSize:'120x120'},
        apiUrl: 'http://api.lion.cn/v1/news/list'
    },
    beforeMount: function() {
        this.getNews();
    },
    mounted:function(){
        var mySwiper = new Swiper('.swiper-container', {
           //direction: 'horizontal',
           loop: true,
           autoplay: 3000,
           pagination: '.swiper-pagination',
        })
        console.log(mySwiper)
    },
    methods: {
        getNews: function() {
            this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.sendData}).then((response) => {
                this.$set(this, 'nitems', response.data)
                console.dir(this.nitems);
            }).catch(function(response) {
                console.log(response)
            })
        }
    }
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>  
