<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $name;
$this->context->layout = false;
?>

<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>很抱歉，<?= Html::encode($this->title) ?></title>
    <style type="text/css">
        .main-box{margin: 105px auto 0; width: 510px; padding-bottom: 65px;}
        .main-box .main-top{}
        .main-box .main-top .logo{width: 166px; float: left;}
        .main-box .main-top .title{    margin-left: 200px;display: block;}
        .main-box .main-top h5{font-size: 12px; font-weight: normal; margin-top: 4px; color: #999999; margin-bottom: 6px;}
        .main-box .main-top li{background: url(http://static.lehecai.com/img/404/list_style.gif) 0 10px no-repeat; padding-left: 8px; line-height: 20px;}
        .main-box .main-top .link a{text-decoration: none; margin-right: 8px; color: #0065BA;}
        .main-box .main-top .link a:hover{color: #F00; text-decoration: none;}
    </style>
  </head>
  <body>
  <div class="main-box">
      <div class="main-top">
            <div class="logo"><img src="/static/images/404.jpg"></div>
            <div class="title">
            <!-- <img src="/static/images/404_title.jpg"> -->

            <p>很抱歉
                <?= nl2br(Html::encode($message)) ?>
            </p>   
                <h5>您可以访问以下地址： </h5>
                <div class="link">
                    <a href="<?=Url::toRoute(['/'])?>">网站首页</a>
<!--                    <p>该页将在<span id="t_s">3</span>秒后自动跳转!</p>-->
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>


<script>
//   var a = function(){
//    var t = 3;
//    setInterval(function(){
//        document.getElementById("t_s").innerHTML = t--;
//        if (t == 0) {
//            history.go(-1);
//        };
//    }, 1000);
//   }
//   a();
</script>
</body>
</html>