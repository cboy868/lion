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
        <a href="<?=Url::toRoute(['/grave/m/default/index'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/static/images/icons/realition.png" alt="业务办理">
            </div>
            <p class="weui-grid__label">业务办理</p>
        </a>
        <a href="<?=Url::toRoute(['/memorial/m/default/view'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/memorial.png" alt="纪念馆">
            </div>
            <p class="weui-grid__label">纪念馆</p>
        </a>
        <a href="<?=Url::toRoute(['/shop/m/default/index'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/flower.png" alt="祭祀">
            </div>
            <p class="weui-grid__label">祭祀</p>
        </a>
        <a href="<?=Url::toRoute(['/m/default/route'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/nav.png" alt="一键导航">
            </div>
            <p class="weui-grid__label">一键导航</p>
        </a>

<!--        <a href="#" class="weui-grid js_grid" data-id="button">-->
<!--            <div class="weui-grid__icon">-->
<!--                <img src="/theme/m2/static/mobile/images/icons/album.png" alt="相册">-->
<!--            </div>-->
<!--            <p class="weui-grid__label">相册</p>-->
<!--        </a>-->
<!--        <a href="#" class="weui-grid js_grid" data-id="button">-->
<!--            <div class="weui-grid__icon">-->
<!--                <img src="/theme/m2/static/mobile/images/icons/article.png" alt="投诉建议">-->
<!--            </div>-->
<!--            <p class="weui-grid__label">投诉建议</p>-->
<!--        </a>-->
        <a href="<?=Url::toRoute(['/order/m/default/index'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/order_list.png" alt="在线起名">
            </div>
            <p class="weui-grid__label">订单记录</p>
        </a>
        <a href="<?=Url::toRoute(['/user/m/default/index'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/user.png" alt="个人资料">
            </div>
            <p class="weui-grid__label">个人资料</p>
        </a>
    </div>
    <!--banner 结束-->
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">新闻资讯</div>
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
