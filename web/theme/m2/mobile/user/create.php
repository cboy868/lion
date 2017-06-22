<?php
$this->title="创建系统账号";

?>
<div class="content" id="create">

    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">适用于原来没有注册过本系统的用户</div>

            <div class="weui-cells">

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">登录账号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" v-model="uname" placeholder="登录账号">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">邮箱</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" v-model="email" type="email" placeholder="邮箱">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">登录密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" v-model="passwd" placeholder="登录密码">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">再次输入密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" v-model="repasswd" placeholder="再次输入登录密码">
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

<?php $this->beginBlock('create') ?>
    var wechat_uid = "<?=$wechat['id']?>";
    var wid="<?=Yii::$app->request->get('wid')?>";
    var demo = new Vue({
        el: '#create',
        data: {
            wechat_uid:wechat_uid,
            uname:'',
            passwd:'',
            repasswd:'',
            email:'',
            apiCreate: base_url + 'wechat-user/create'
        },
        methods: {
            save: function () {
                if(this.uname.length<2) {$.toptip("账号长度不可小于两位", 'error'); return;}
                if(this.passwd.length<6) {$.toptip("密码长度不可小于六位", 'error'); return;}
                if(this.passwd != this.repasswd) {$.toptip("两次密码输入不一致", 'error'); return;}
                var data = {wechat_uid:this.wechat_uid,
                    email:this.email,
                    uname:this.uname,passwd:this.passwd,
                    repasswd:this.repasswd};

                this.$http.post(this.apiCreate, data,{emulateJSON:true}).then(function(response){
                    if (response.body.errno == 1) {
                        $.toast(response.body.error, "error");
                    } else {
                        $.toast('账号创建成功，请查看是否正确', "success", function() {
                            location.href="/m/user/default/profile.html?wid=" + wid;
                        });
                    }

                }, function(response){
                });
            },
        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['create'], \yii\web\View::POS_END); ?>
