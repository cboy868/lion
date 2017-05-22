<?php
use yii\helpers\Html;
use yii\helpers\Url;
$user = Yii::$app->user->identity;

$getuid = Yii::$app->request->get('uid');
$home_user = isset($getuid) ? $getuid :$user->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="baidu-site-verification" content="sSXyxVj8bS">
    <link rel="stylesheet" href="/theme/m2/static/css/an.css" type="text/css">
    <link rel="stylesheet" href="/theme/m2/static/css/layout.css">
    <link rel="stylesheet" href="/theme/m2/static/css/blog.css">
    <link rel="stylesheet" href="/theme/m2/static/css/center.css">
    <script type="text/javascript" src="/theme/m2/static/libs/jquery1.7.2/jquery.min.js"></script>
</head>


<body>
<?php $this->beginBody() ?>
<div id="site-nav">
    <div id="site-navright">
        <ul>
            <li class="site-go"> <a href="<?=Url::toRoute(['/member/default/logout'])?>">退出</a> </li>
        </ul>
    </div>
    <div id="site-navleft">
        <ul>
            <li class="site-user">
                <a href="<?=Url::toRoute(['/member'])?>" target="_blank"><?=$user->username;?></a> 您好！
                <a href="<?=Url::toRoute(['/admin'])?>" target="_blank">管理中心</a>
                <a href="<?=Url::toRoute(['/member/default/logout'])?>" id="signOut">退出</a>
            </li>
        </ul>
    </div>
</div>
<div id="index-header">
    <div id="header">
        <a class="logo" href="<?=Url::toRoute(['/'])?>">
            <img class="png" src="<?=g('logo')?>" alt="">
        </a>
    </div>
</div>
<div id="nav">
    <div class="container">
        <div class="right">
            <a href="<?=Url::toRoute(['/member'])?>"><?=Yii::$app->user->identity->username;?></a>
        </div>
        <ul class="clearfix">
            <li class="first"><a href="<?=Url::toRoute(['/'])?>">首页</a></li>
            <li><a href="<?=Url::toRoute(['/news/home/default/index'])?>">资讯</a></li>
            <li><a href="<?=Url::toRoute(['/blog/home/default/index'])?>">服务日志</a></li>
            <li><a href="<?=Url::toRoute(['/memorial/home/default/index'])?>">纪念馆</a></li>
        </ul>
    </div>
</div>
<div id="container" class="pad12">
    <div class="index-aside left">

        <dl id="staff-profile-wrap">
            <dt class="corner8">
                <a target="_blank" href="#">
                    <img width="190px" title="" alt="" src="<?=$user->getAvatar('190x380')?>">
                </a>
            </dt>
            <dd>
        </dl>

        <?php $memorials = getMemorialByUser($home_user);?>
        <div class="blog-list corner12 list-bgcolor profile-memorial-list">
                <h4>纪念馆</h4>
            <?php if ($memorials):?>
                <ul>
                    <?php foreach ($memorials as $v):?>
                    <li>
                        <a style="color:#0A7E35" href="<?=Url::toRoute(['/memorial/home/default/view', 'id'=>$v['id']])?>"
                           target="_blank" title="<?=$v['title']?>"><?=$v['title']?></a>
                    </li>
                    <?php endforeach;?>
                </ul>

            <?php else:?>
                还没有纪念馆
            <?php endif;?>
        </div>

        <?php $blogs = getBlogsByUser($home_user);?>
        <div class="blog-list corner12 list-bgcolor">
            <h4>日志</h4>
            <a target="_blank" class="more" href="/blog/index/uid/58">更多</a>
            <ol>
                <?php foreach ($blogs as $v):?>
                    <li>
                        <a target="_blank" title="<?=$v['title']?>" href="<?=Url::toRoute(['/blog/member/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a>
                    </li>
                <?php endforeach;?>
            </ol>
        </div>

    </div>
    <?=$content?>
    <div class="clear"></div>
</div>
<div id="footer" class="cornerb12">
    <p><?=g('fullname')?>客服电话:<?=g("cmobile")?></p>
    <p>传真:<?=g("chuanzhen")?> <?=g("beian")?></p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
