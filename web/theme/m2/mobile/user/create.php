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
                <div class="weui-cells__tips">以后可用此账号登入系统</div>

            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary" @click="save">提交保存</a>
    </div>
</div>