<?php
$this->title="个人信息管理";
?>
<div class="content">
    <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="#">
            <div class="weui-cell__bd">
                <p>头像</p>
            </div>
            <div class="weui-cell__ft">
                <img class="tx" src="/static/images/default.png" width="20" height="20" style="vertical-align:middle">
            </div>
        </a>

        <a class="weui-cell weui-cell_access" href="#">
            <div class="weui-cell__bd">
                <p>登录账号</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">昵称</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" placeholder="昵称">
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">性别</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="select2">
                    <option value="1">男</option>
                    <option value="2">女</option>
                    <option value="3">保密</option>
                </select>
            </div>
        </div>
    </div>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">手机号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" pattern="[0-9]*"  placeholder="手机号">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">邮箱</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input"  placeholder="邮箱">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" placeholder="住址" rows="3"></textarea>
                <div class="weui-textarea-counter"><span>0</span>/200</div>
            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary">提交保存</a>
    </div>

</div>