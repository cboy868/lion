<?php
$this->title="绑定系统账号";

?>
<div class="content" id="bind">

    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">适用于已有本系统的用户</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">登录账号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" placeholder="登录账号" v-model="uname">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input"  placeholder="登录密码" v-model="passwd">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary" @click="bind">确定提交</a>
    </div>

</div>

<?php $this->beginBlock('bind') ?>
    var wechat_uid = "<?=$wechat['id']?>";
    var demo = new Vue({
        el: '#bind',
        data: {
            wechat_uid:wechat_uid,
            uname:'',
            passwd:'',
            apiBind: base_url + 'wechat-user/bind'
        },
        methods: {
            bind: function () {
                //if(!this.uname || !this.passwd){$.toptip("账号与密码均必填", 'error'); return;}
                if(this.uname.length<2) {$.toptip("账号长度不可小于两位", 'error'); return;}
                if(this.passwd.length<6) {$.toptip("密码长度不可小于六位", 'error'); return;}
                var data = {wechat_uid:this.wechat_uid,uname:this.uname,passwd:this.passwd};

                this.$http.post(this.apiBind, data,{emulateJSON:true}).then(function(response){
                    console.dir(response);
                }, function(response){

                });

            },
        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['bind'], \yii\web\View::POS_END); ?>
