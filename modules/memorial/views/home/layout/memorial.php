<?php
use yii\helpers\Html;
use yii\helpers\Url;
\app\modules\memorial\assets\HallAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="keywords" content="#">
    <meta name="Description" content="#">
    <meta name="Author" content="#">
    <link href="#" rel="shortcut icon" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-md hidden-lg" href="/">
                    <img src="/Resource/Images/v2_top_logo.gif" alt="天堂纪念网" />
                </a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li><a href="/">孝爱主页</a></li>

                    <li><a class="red" href="/MemberCenter/Recharge/Index">在线充值</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="display:block">
                    <li><a href="javascript:LoginPanel()"><i class="navIcon user"></i>登录</a></li>
                    <li><a href="/account/Register"><i class="navIcon register"></i>注册</a></li>
                    <li><a href="/ServCenter/CommonProblem"><i class="navIcon help"></i>帮助</a></li>
                    <li class="dropdown">
                        <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="navIcon snav"></i>网站导航 <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/index'])?>">纪念馆首页</a></li>
                            <li><a href="<?=Url::toRoute(['/memorial/home/hall/index'])?>">纪念馆</a></li>
                            <li><a href="/Today">生日/忌日</a></li>
                            <li><a href="/Obituary">在线讣告</a></li>
                            <li><a href="/Article">深情感文</a></li>
                            <li><a href="/Mailbox">时空信箱</a></li>
                            <li><a href="/Times">时光留影</a></li>
                            <li><a href="/ServCenter">服务专区</a></li>

                        </ul>
                    </li>
                </ul>
                <ul class="list-inline jlg-user" style="display:none">
                    <li><a href="#"><p title="进入我的博客中心"></p></a></li>
                    <li><a href="/MemberCenter"><p><strong>进入个人中心</strong></p></a></li>
                    <li><a href="/ServCenter/CommonProblem"><p><strong>帮助</strong></p></a></li>

                    <li><a href="/MemberCenter/Message"><div class="badge">0</div><span title="我的消息" class="userIcon msg">我的消息</span></a></li>
                    <li><a href="/Account/LoginOut"><p>退出</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>



<div class="container">
    <div class="bt-top">
        <div class="jng-info">
            <h1>中国近代民主革命伟大先行者孙中山</h1>
            <p>
                <span>天堂纪念馆号：<strong class="ttid">TT000000069</strong></span>
                <span>本馆由[
                    <a data-toggle="modal" data-target=".user-info-dialog"
                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                        hu</a>]创建于2009年11月12日
                </span>
            </p>
            <div class="m-tool">
                <a onclick="Care('6b3eae8e-808b-4653-a41b-7f77585cc850',this)" href="javascript:void(0)">
                    <i class="smIcon add"></i>
                    <span>我要关注</span>
                </a>

                <button id="JoinFriendMeorialHall" class="tt-btn">加入亲友馆</button>
                <a onclick="Vote('6b3eae8e-808b-4653-a41b-7f77585cc850',this)" href="javascript:;" class="tt-btn">我要祈福</a>
                <a id="VoteList" href="javascript:void(0)" >
                    <strong class="visit">535</strong><span>次</span>
                </a>
            </div>
        </div>
        <a href="/ServCenter/Detailed?id=66">
            <span class="m-level level0"></span>
        </a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="menu-list">
            <ul id="toolbar" class="list-unstyled">
                <li><a class="menu_1" href="<?=Url::toRoute(['/memorial/home/site/index'])?>">纪念首页</a></li>
                <li><a class="menu_2" key="M" href="<?=Url::toRoute(['/memorial/home/hall/index'])?>">网上纪念堂</a></li>

                <li><a href="<?=Url::toRoute(['/memorial/home/site/life'])?>">生平简介</a></li>
                <li><a href="<?=Url::toRoute(['/memorial/home/site/album'])?>">音容笑貌</a></li>
                <li><a href="<?=Url::toRoute(['/memorial/home/site/achive'])?>">档案资料</a></li>
                <li><a href="<?=Url::toRoute(['/memorial/home/site/miss'])?>">追忆文章</a></li>
                <li><a href="<?=Url::toRoute(['/memorial/home/site/msg'])?>">时空信箱</a></li>
                <li><a href="<?=Url::toRoute(['/memorial/home/site/record'])?>">祭奠记录</a></li>
            </ul>
        </div>
    </div>
</div>

<?=$content?>

<div class="container footer">
    <div class="col-md-8">
        <p>建馆者：<a href="#">hu</a> | 建馆时间:2009年11月12日 | 您是
            <strong>638516</strong>位前来悼念的人</p>
        <p>服务电话：400-860-4520 0756-5505883 0756-5505888</p>
        <p>邮箱：tt@waheaven.com 公司常年法律顾问：广东林氏律师事务所林叔权律师  <a href="#" class="tt-btn">我要举报</a></p>
    </div>
    <div class="col-md-4"><div class="text-right footer-logo"><img src="/Resource/images/memorials/foot-wenzhi.png"></div></div>
</div>
<div class="blank"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>