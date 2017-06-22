<?php
$this->title="创建系统账号";

?>
<div class="content">

    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">适用于原来没有注册过本系统的用户</div>

            <div class="weui-cells">

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">登录账号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="username" placeholder="登录账号">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">登录密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="passwd" placeholder="登录密码">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">再次输入密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="repasswd" placeholder="再次输入登录密码">
                    </div>
                </div>
                <div class="weui-cells__tips">以后可用此账号登入系统办理其它业务</div>

            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary" @click="save">提交</a>
    </div>
</div>


<?php $this->beginBlock('news') ?>
    var wechat_user_id = "<?=$wechat['id']?>";
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
