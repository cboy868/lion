<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/login.css">
<div class="login common">
	<div class="container">
		<div class="skin_img shadow"><img src="/theme/m2/static/gls/img/login/skin_login.jpg" /></div>
		<div class="shadow">
			<h2 class="tit1">
				<span>注册/登录</span>
			</h2>
			<div class="det">
				<div class="tab bor">
					<div class="login_top">
			            <a class="now"><span class="png"></span>用户登录</a>
			            <a><span class="png"></span>用户注册</a>
			        </div>
			        <div class="login_det">
			            <div style="display: block;" class="login_tab_items">
			                <form method="post">
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="text" name="username" class="txt"></span><span class="txtr">用户名：
			                        </span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="password" name="password" class="txt"></span><span class="txtr">密码：
			                        </span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="checkbox" id="auto_login" value="1" name="remember_me"> <label for="auto_login">自动登录</label>
			                        </span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="submit" value="登陆" class="btn1">
			                        </span>
			                    </div>
			                </form>
			                <div class="forget">
			                    <a class="red" href="#">您登录时遇到问题了吗？</a>
			                    <a class="btn" href="#">忘记密码？</a>
			                </div>
			            </div>
			            <div class="login_tab_items">
			                <form method="post" id="registerForm">
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="text" name="username" class="txt"> (请实名注册)
			                        </span>
			                        <span class="txtr"><i>*</i>用户名：</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="password" name="password" class="txt"> (必填)
			                        </span>
			                        <span class="txtr"><i>*</i>密码：</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="password" class="txt" name="repassword"> (必填)
			                        </span>
			                        <span class="txtr"><i>*</i>重复密码：</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="text" class="txt" name="email"> (必填)
			                        </span>
			                        <span class="txtr"><i>*</i>电子邮箱：</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <input type="checkbox" id="ya_user" value="1" name="is_customer"> <label for="ya_user">我是华夏客户</label>
			                        </span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                           <input type="text" class="textfield" name="captcha" id="captcha">
			                        </span>
			                        <span class="txtr"><i>*</i>验证码：</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right">
			                            <p class="captcha">
										  <img style="cursor:pointer;" src="/verify/output?t=1404984418" class="captchaImg">
										  <span class="captchaRefresh">
										  <a href="#" class="capchaChange">看不清楚？换一个</a></span>
										</p>           
									</span>
			                    </div>
			                    <div class="items clearfix">
			                        <span class="right"><input type="submit" value="登陆" class="btn1"></span>
			                    </div>
			                </form>
			            </div>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('.tab').cSwitch({
			btnItems : '.login_top a',
			bigImg : '.login_det .login_tab_items',
			PNBtnShow : false,
			changeFade : false,
			autoPlay : false,
			eventType : 'click',
			active : 'now'
		}); 
	});
</script>