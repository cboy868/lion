<?php
use app\core\helpers\Url;

\app\assets\VueAsset::register($this);

$this->title="个人中心";
$wid = Yii::$app->request->get('wid');
$focus =focus(2, 5, '425x300');
?>
<div class="content" id="news-box">
    <div class="swiper-container" style="height: 200px;">
        <div class="swiper-wrapper">
            <?php foreach ($focus['focus'] as $f):?>
                <div class="swiper-slide">
                    <img src="<?=$f['image']?>" />
                </div>
            <?php endforeach;?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php if (!isset($wechat['user_id']) || !$wechat['user_id']): ?>
    <div class="weui-panel__hd">办理业务之前请在
        <a href="<?=Url::toRoute(['/user/m/default/profile', 'wid'=>$wid])?>">
        <strong>个人设置</strong>
        </a>
        中绑定或创建系统账号
    </div>

        <?php else:?>
        <div class="weui-grids whitebg" style="margin-top:5px; padding-top:0px;">
            <a href="<?=Url::toRoute(['/grave/m/default/index', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/static/images/icons/realition.png" alt="业务办理">
                </div>
                <p class="weui-grid__label">业务办理</p>
            </a>
            <a href="<?=Url::toRoute(['/memorial/m/default/apply', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/memorial.png" alt="申请建馆">
                </div>
                <p class="weui-grid__label">申请建馆</p>
            </a>
            <!--
            <a href="#" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/article.png" alt="投诉建议">
                </div>
                <p class="weui-grid__label">投诉建议</p>
            </a>
            -->
            <a href="<?=Url::toRoute(['/order/m/default/index', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/order_list.png" alt="订单记录">
                </div>
                <p class="weui-grid__label">订单记录</p>
            </a>
            <a href="<?=Url::toRoute(['/grave/m/default/renew', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/xufei.png" alt="续维护费">
                </div>
                <p class="weui-grid__label">续维护费</p>
            </a>
            <!--

        <a href="<?=Url::toRoute(['/grave/m/default/repair', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
            <div class="weui-grid__icon">
                <img src="/theme/m2/static/mobile/images/icons/xiujinbo.png" alt="修金箔">
            </div>
            <p class="weui-grid__label">修金箔</p>
        </a>
                -->

            <a href="<?=Url::toRoute(['/grave/m/default/tombs', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/static/images/icons/archive.png" alt="墓位档案">
                </div>
                <p class="weui-grid__label">墓位档案</p>
            </a>
            <a href="<?=Url::toRoute(['/user/m/default/profile', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/user.png" alt="个人资料">
                </div>
                <p class="weui-grid__label">个人设置</p>
            </a>
            <a href="<?=Url::toRoute(['/analysis/m/default/index', 'wid'=>$wid])?>" class="weui-grid js_grid" data-id="button">
                <div class="weui-grid__icon">
                    <img src="/theme/m2/static/mobile/images/icons/statistics.png" alt="个人资料">
                </div>
                <p class="weui-grid__label">统计图表</p>
            </a>
        </div>
    <?php endif;?>

    <!--banner 结束-->
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">纪念馆</div>

                <div class="weui-panel__bd" >
                    <a :href="'/m/memorial/'+item.id+'.html?wid=<?=$wid?>'" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access"
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

    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">待审批的纪念馆</div>

            <div class="weui-panel__bd" >
                <a href="#" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access"
                   v-for="apply in applys">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" :src="apply.cover">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title" v-text="apply.title"></h4>
                        <p class="weui-media-box__desc" v-text="apply.intro"></p>
                    </div>
<!--                    <div class="weui-cell__ft">-->
<!--                        进入-->
<!--                    </div>-->
                </a>
            </div>
        </div>
    </div>
    <div class="weui-panel__ft">
        <a href="/m/memorial?wid=<?=$wid?>" class="weui-cell weui-cell_access weui-cell_link">
            <div class="weui-cell__bd">查看更多公开纪念馆</div>
            <span class="weui-cell__ft"></span>
        </a>
    </div>
</div>


<?php $this->beginBlock('news') ?>
    var user_id = "<?=isset($wechat['user_id'])?$wechat['user_id']:0?>";
    var demo = new Vue({
        el: '#news-box',
        data: {
            nitems: [],
            memorials:[],
            applys:[],

            sendData:{limit:5, thumbSize:'120x120'},
            memorialData:{uid:user_id,thumbSize:'120x120', status:1},
            applyData:{uid:user_id,thumbSize:'120x120', status:0},
            apiMemorial: base_url + 'memorial',
        },
        beforeMount: function() {
            this.memorial();
            this.apys();
        },
        mounted:function(){
            var mySwiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: 3000,
                pagination: '.swiper-pagination',
            })
        },
        methods: {
            memorial: function () {
                this.$http.jsonp(this.apiMemorial,{'jsonp':'lcb', params:this.memorialData}).then((response) => {
                    this.$set(this, 'memorials', response.data.items)
                }).catch(function(response) {
                    console.log(response)
                })
            },
            apys: function () {
                this.$http.jsonp(this.apiMemorial,{'jsonp':'lcb', params:this.applyData}).then((response) => {
                    this.$set(this, 'applys', response.data.items)
                }).catch(function(response) {
                    console.log(response)
                })
            }

        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>
