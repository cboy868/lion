<?php 
use app\core\helpers\Url;
$this->title = "Lion 信息管理系统安装"
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">安装向导---协议</h3>
        </div>
        <div class="panel-body">
          <h4 class="text-center">中文版授权协议</h4>

            <!-- <p>
                版权所有:助力科技
            </p> -->
            <p>
                感谢您选择Lion信息管理系统。希望我们的努力能为您提供一个高效、有力网络信息管理解决方案。
            </p>

            <p>
                Lion 官方网站为 http://www.ibagou.com  目前正在建设中
            </p>

            <p>
                本系统非开源、禁止以任何形式转卖或扩散。
            </p>

            <p>
                本系统可用于小型企业日常信息管理、企业建站。
            </p>

            <p>
                本程序模块化开发、安全稳定，后续扩展方便且不会影响原有系统。
            </p>   

            <p>
                在开始前，我们需要您数据库的一些信息。请准备好如下信息。

                数据库主机
                数据库名
                数据库用户名
                数据库密码

                OK 我们继续
            </p>

        </div>
        <div class="panel-footer text-right">
            <a href="<?=Url::toRoute(['env'])?>" class="btn btn-primary">同 意</a>
        </div>
      </div>
    </div>
  </div>
</div>