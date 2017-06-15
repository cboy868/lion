<?php
use app\core\helpers\Url;

\app\assets\VueAsset::register($this);
?>
<div class="content" id="news-box">
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
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/nav.png" alt="申请建馆">
            </div>
            <p class="weui-grid__label">申请建馆</p>
        </a>
        <a href="#" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/article.png" alt="投诉建议">
            </div>
            <p class="weui-grid__label">投诉建议</p>
        </a>
        <a href="<?=Url::toRoute(['/order/m/default/index'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/order_list.png" alt="订单记录">
            </div>
            <p class="weui-grid__label">订单记录</p>
        </a>
        <a href="<?=Url::toRoute(['/user/m/default/profile'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/xufei.png" alt="续维护费">
            </div>
            <p class="weui-grid__label">续维护费</p>
        </a>
        <a href="<?=Url::toRoute(['/user/m/default/profile'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/xiujinbo.png" alt="修金箔">
            </div>
            <p class="weui-grid__label">修金箔</p>
        </a>
        <a href="<?=Url::toRoute(['/user/m/default/profile'])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/user.png" alt="个人资料">
            </div>
            <p class="weui-grid__label">个人资料</p>
        </a>
    </div>
    <!--banner 结束-->
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">纪念馆</div>

                <div class="weui-panel__bd" >
                    <a :href="'/m/memorial/'+item.id+'.html'" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access"
                       v-for="item in memorials">
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb" :src="item.cover">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title" v-text="item.title"></h4>
                            <p class="weui-media-box__desc" v-text="item.intro"></p>
                        </div>
                        <div class="weui-cell__ft">
                            进入
                        </div>
                    </a>
                </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('news') ?>
    var demo = new Vue({
        el: '#news-box',
        data: {
            nitems: [],
            memorials:[],
            sendData:{limit:5, thumbSize:'120x120'},
            memorialData:{uid:1,thumbSize:'120x120'},
            apiMemorial: 'http://api.lion.cn/v1/memorial',
            apiUrl: 'http://api.lion.cn/v1/news'
        },
        beforeMount: function() {
            this.getNews();
            this.memorial();
        },
        mounted:function(){
            var mySwiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: 3000,
                pagination: '.swiper-pagination',
            })
        },
        methods: {
            getNews: function() {
                this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.sendData}).then((response) => {
                    this.$set(this, 'nitems', response.data.items)
                }).catch(function(response) {
                    console.log(response)
                })
            },
            memorial: function () {
                this.$http.jsonp(this.apiMemorial,{'jsonp':'lcb', params:this.memorialData}).then((response) => {
                    this.$set(this, 'memorials', response.data.items)
                }).catch(function(response) {
                    console.log(response)
                })
            }

        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>
