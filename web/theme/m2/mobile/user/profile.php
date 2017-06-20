<?php
$this->title="个人信息管理";
\app\assets\JqueryFormAsset::register($this);
?>
<div class="content" id="profile-box">

    <div class="weui-cells">
        <form class="avatar-form" enctype="multipart/form-data" method="post">
            <input type="hidden" name="uid" value="1" />
            <a class="weui-cell weui-cell_access avatar-btn" href="#" @click="avatar">
                <div class="weui-cell__bd">
                    <p>头像</p>
                </div>
                <div class="weui-cell__ft">
                    <img class="tx" :src="user.avatar" width="20" height="20" style="vertical-align:middle">
                </div>
                <input type="file" class="avatar-input" name="avatar" @change="upfile" style="display: none;">
            </a>
        </form>
<!--
        <a class="weui-cell weui-cell_access" href="/m/user/default/account.html">
            <div class="weui-cell__bd">
                <p>账号</p>
            </div>
            <div class="weui-cell__ft" v-text="user.username"></div>
        </a>
        -->
    </div>

    <form class="info-form">
        <input type="hidden" name="id" value="1">
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" placeholder="姓名" name="mobile" v-model="user.addition.real_name">
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">性别</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="gender" v-model="user.addition.gender">
                    <option value="1" >男</option>
                    <option value="2" >女</option>
                    <option value="3" >保密</option>
                </select>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">手机号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" pattern="[0-9]*"  placeholder="手机号" name="mobile" v-model="user.mobile">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">邮箱</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input"  placeholder="邮箱" name="email" v-model="user.email">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" placeholder="住址" rows="3" name="address" v-model="user.addition.address"></textarea>
                <div class="weui-textarea-counter"><span>0</span>/200</div>
            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary" @click="save">提交保存</a>
    </div>

    </form>

</div>


<?php $this->beginBlock('news') ?>
    var demo = new Vue({
        el: '#profile-box',
        data: {
            apiUrl: 'http://api.lion.cn/api/v1/user/avatar',
            apiUserInfo: 'http://api.lion.cn/api/v1/users',
            apiSave:'http://api.lion.cn/api/v1/user/up',
            uid:1,
            user:{avatar:''}
        },
        beforeMount: function() {
            this.userinfo();
        },
        mount:function() {


        },
        methods: {
            userinfo: function() {
                this.$http.jsonp(this.apiUserInfo + '/' + this.uid,{'jsonp':'lcb', params:{expand:'addition',avatarSize:'20x20'}}).then((response) => {
                    console.dir(response.data);
                    this.$set(this, 'user', response.data)
                }).catch(function(response) {
                    console.log(response)
                })
            },
            avatar:function () {
                $('.avatar-input').trigger('click');
            },
            upfile:function(){
                var that = this;
                $('form.avatar-form').ajaxSubmit({
                    type:'post',
                    url:this.apiUrl,
                    success: function (data) {
                        that.$set(that.user, 'avatar', data);
                        $.toptip('头像修改成功', 'success');
                    },
                    error: function (data) {
                    }
                });
            },
            save:function() {

                if (!this.user.addition.real_name) {$.toptip('用户姓名不可为空', 'error');return;}
                if (!this.user.mobile) {$.toptip('手机号不可为空', 'error');return;}
                if (!this.user.email) {$.toptip('邮箱不可为空', 'error');return;}
                this.$http.post(this.apiSave, this.user,{emulateJSON:true}).then(function(response){
                    $.toptip('个人信息修改成功', 'success');
                    this.userinfo();
                }, function(response){

                });
            }

        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>
