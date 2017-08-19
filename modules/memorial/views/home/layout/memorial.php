<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\user\models\Track;
use app\modules\memorial\models\Memorial;

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
                <a class="navbar-brand hidden-md hidden-lg" href="<?=g("url")?>">
                    <img src="<?=g('logo')?>" alt="<?=g('cp_name')?>">
                </a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <?php
                    $current_nav = isset($this->params['current_nav']) ? $this->params['current_nav'] : '';
                    $id = Yii::$app->request->get('id');
                    ?>
                    <li><a href="<?=Url::toRoute(['/'])?>"><?=g('cp_name')?>门户</a></li>

                    <li><a href="<?=Url::toRoute(['/'])?>">纪念馆主页</a></li>

                    <li class="<?php if($current_nav=='index'):?>active<?php endif;?>">
                        <a class="" key="" href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$id])?>">首页</a></li>
                    <li class="<?php if($current_nav=='memorial'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/memorial', 'id'=>$id])?>">纪念馆</a></li>
                    <li class="<?php if($current_nav=='life'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$id])?>">生平简介</a></li>
                    <li class="<?php if($current_nav=='album'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/album', 'id'=>$id])?>">音容笑貌</a></li>
                    <li class="<?php if($current_nav=='archive'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/archive', 'id'=>$id])?>">档案资料</a></li>
                    <li class="<?php if($current_nav=='miss'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/miss', 'id'=>$id])?>">追忆文章</a></li>
                    <li class="<?php if($current_nav=='msg'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/msg', 'id'=>$id])?>">美好祝福</a></li>
                    <li class="<?php if($current_nav=='record'):?>active<?php endif;?>">
                        <a class="" href="<?=Url::toRoute(['/memorial/home/hall/record', 'id'=>$id])?>">祭祀记录</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="display:block">
                    <li><a href="#"><i class="navIcon user"></i>登录</a></li>
                    <li><a href="#"><i class="navIcon register"></i>注册</a></li>
                    <li class="dropdown">
                        <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="http://www.5201000.com/Memorial/TT000000069#">
                            <i class="navIcon snav"></i>网站导航 <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/index'])?>">纪念馆首页</a></li>
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/miss'])?>">追思文章</a></li>
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/msg'])?>">美好祝福</a></li>
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/album'])?>">影像资料</a></li>
                            <li><a href="<?=Url::toRoute(['/memorial/home/site/recird'])?>">祭祀记录</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="list-inline jlg-user" style="display:none">
                    <li><a href="#"><p title="我的博客中心"></p></a></li>
                    <li><a href="#"><p><strong>进入个人中心</strong></p></a></li>
                    <li><a href="#"><p><strong>帮助</strong></p></a></li>

                    <li><a href="#">
                            <div class="badge">0</div><span title="我的消息" class="userIcon msg">我的消息</span></a></li>
                    <li><a href="#"><p>退出</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="ink-hook"></div>
<div class="container">
    <div class="row" style="height: 40px;background: #fff;overflow: hidden;position: relative;">
    </div>
</div>
<!--
<div class="container" style="margin-top:100px;">
    <div class="row">
        <div class="menu-list">
            <ul id="toolbar" class="list-unstyled">
                <?php
                $current_nav = isset($this->params['current_nav']) ? $this->params['current_nav'] : '';
                $id = Yii::$app->request->get('id');
                ?>
                <li class="<?php if($current_nav=='index'):?>active<?php endif;?>">
                    <a class="" key="" href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$id])?>">首页</a></li>
                <li class="<?php if($current_nav=='memorial'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/memorial', 'id'=>$id])?>">网上纪念馆</a></li>
                <li class="<?php if($current_nav=='life'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$id])?>">生平简介</a></li>
                <li class="<?php if($current_nav=='album'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/album', 'id'=>$id])?>">音容笑貌</a></li>
                <li class="<?php if($current_nav=='archive'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/archive', 'id'=>$id])?>">档案资料</a></li>
                <li class="<?php if($current_nav=='miss'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/miss', 'id'=>$id])?>">追忆文章</a></li>
                <li class="<?php if($current_nav=='msg'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/msg', 'id'=>$id])?>">美好祝福</a></li>
                <li class="<?php if($current_nav=='record'):?>active<?php endif;?>">
                    <a class="" href="<?=Url::toRoute(['/memorial/home/hall/record', 'id'=>$id])?>">祭祀记录</a></li>
            </ul>
        </div>
    </div>
</div>
-->
<?=$content?>



<div class="blank"></div>
<div class="mainfooter waheaven-footer">
    <div class="container">
        <div class="">
            <div class="col-md-9">
                <div class="row">
                    <ul class="list-inline">
                        <li><a href="#">关于我们</a></li>
                        <li><a href="#">公司动态</a></li>
                        <li><a href="#">联系我们</a></li>
                    </ul>
                    <p>
                        <a href="http://www.miibeian.gov.cn/" target="_blank"><?=g("beian")?></a>
                        <?=g("reserved")?>
                    </p>

                </div>
            </div>
            <div class="col-md-3">
                <div class="row attention">
                    <div class="col-md-6 col-xs-12">
                        <img width="100" src="/static/images/ma1.jpg">
                        <p>关注微信平台</p>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <img width="100" src="/static/images/ma2.jpg">
                        <p>小程序</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>