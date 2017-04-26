<div class="content">
            <div class="weui-cells">
                  <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/avatar">
                        <div class="weui-cell__bd">
                          <p>头像</p>
                        </div>
                        <div class="weui-cell__ft"><img class="tx" src="./static/images/default_avatar_128_128.jpg" width="20" height="20" style="vertical-align:middle"></div>
                  </a>
                <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
                <div class="weui-cell__bd">
                  <p>我的姓名</p>
                </div>
                <div class="weui-cell__ft">cboy</div>
                </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/ziliao.html#">
                <div class="weui-cell__bd">
                  <p>我的账号</p>
                </div>
                <div class="weui-cell__ft"></div>
                </a> 
            </div>

             <div class="weui-cells"> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
                <div class="weui-cell__bd weui-cell_primary">
                  <p>我的生日</p>
                </div>
                <div class="weui-cell__ft">0000-00-00</div>
                </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
                <div class="weui-cell__bd">
                  <p>我的性别</p>
                </div>
                <div class="weui-cell__ft">男</div>
                </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
                <div class="weui-cell__bd">
                  <p>工作状况</p>
                </div>
                <div class="weui-cell__ft"></div>
                </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
                <div class="weui-cell__bd">
                  <p>婚姻状况</p>
                </div>
                <div class="weui-cell__ft">未婚</div>
                </a> </div>

                <div class="weui-cells"> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/config/profile.html">
    <div class="weui-cell__bd">
      <p>绑定邮箱</p>
    </div>
    <div class="weui-cell__ft"></div>
    </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/shop/address/address_list.html">
    <div class="weui-cell__bd">
      <p>地址管理</p>
    </div>
    <div class="weui-cell__ft"></div>
    </a> <a class="weui-cell weui-cell_access" href="http://m.shensuantang.com/ucenter/password">
    <div class="weui-cell__bd">
      <p>修改密码</p>
    </div>
    <div class="weui-cell__ft"></div>
    </a> </div>

                <div class="weui-btn-area"> <a event-node="logout" class="weui-btn weui-btn_warn" href="javascript:" id="showTooltips">退出登录</a> </div>
    <script>

            $('[event-node=logout]').click(function () {
                $.get("/ucenter/system/logout.html", function (msg) {
                    console.log(msg);return false;
                    $('body').append(msg.html);
                    $.toast(msg.message);
                    setTimeout(function () {
                        location.href = msg.url;
                    }, 1500);
                }, 'json')
            });

    </script>
            
        </div>