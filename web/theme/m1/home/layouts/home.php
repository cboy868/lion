<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" xmlns="http://www.w3.org/1999/xhtml">
<?php 
$action = Yii::$app->controller->action->id;
$navs = \app\modules\cms\models\Nav::navs(); 
 ?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link rel="stylesheet" href="/theme/m1/static/css/jquery-ui.min.css" />

    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link rel="stylesheet" href="/theme/m1/static/css/base.pc.css" type="text/css" />
    <link href="/theme/m1/static/css/iconfont.css" rel="stylesheet" />
    <link href="/theme/m1/static/css/pager.css" rel="stylesheet" />
    <link href="/theme/m1/static/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/theme/m1/static/css/iconfontv2.css" rel="stylesheet" />
    <link rel="stylesheet" href="/theme/m1/static/css/791bd96edabb43bb8c3997ef8b01efe8.css " type="text/css" />
    <link rel="stylesheet" href="/theme/m1/static/css/pager.css" /> 

    <script type="text/javascript" src="/theme/m1/static/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/public.common.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery.lazyload.min.js"></script>
    <script src="/theme/m1/static/js/kino.razor.min.js"></script>
        <script type="text/javascript" src="/theme/m1/static/js/underscore.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery.slider.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery.color.js"></script>


    <script type="text/javascript" src="/theme/m1/static/js/velocity.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/velocity.ui.min.js"></script>
    <script type="text/javascript" src="/theme/m1/static/js/jquery.validatestar.min.js"></script>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style type="text/css">
.header,.main-wrap .main,.footer { position:relative; clear:both; margin:0 auto; padding:0;}
.main-wrap { clear:both; margin:0; padding:0; width:auto; }
.main-wrap .main {}
.main-wrap .main .content { width:100%;}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        if ("fade"=="fold") {
            setRenderFullScreen($("#view_photoalbum_34_843"), "window");
        } else {
            setRenderFullScreen($("#view_photoalbum_34_843"));
        }
        $(".w_slider_2_view_photoalbum_34_843").slide({
            titCell: $(".w_slider_2_view_photoalbum_34_843 .w_slider_num ul"),
            mainCell: $(".w_slider_2_view_photoalbum_34_843 .w_slider_img ul"),
            effect: "fade",
            autoPlay: "true",
            autoPage: true,
            trigger: "click",
            interTime: "3000"
        });
    });

</script>
<div  id="view_layout_1_843" class="mainSamrtView yibuSmartViewMargin"   >
<div class='yibuFrameContent layout_Block2_Item0' style='border-style:none;'>
    <div style="*z-index:11;*position:relative;width:100%;height:800px;margin-left:auto;margin-right:auto;background-color:">
      <div class="header page_header yibuLayout_tempPanel" style="width:1000px;height:800px;background-color:;;">
           <div class='runTimeflowsmartView'>

<div  id="view_photoalbum_34_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden photoalbum_Style2_Item0 view_photoalbum_34_843_Style2_Item0' style='height:775px;width:1000px;'><div class="w_slider_2 renderfullScreen w_slider_2_view_photoalbum_34_843">
<?php 

$f = focus(1,5);
 ?>
    <div class="w_slider_img">
        <ul>
            <?php foreach ($f as $k => $v): ?>
                <li style="background: url(<?=$v['image']?>) center 0 no-repeat;">
                    <div class="siteWidth">
                        <p class="txt"   style="display:none;">
                            <span class="btn"></span>
                        </p>
                        <p class="txtDesc"   style="display: none;"         >
                            <?=$v['title']?>
                        </p>
                        <a style=" cursor:default" title="" ></a>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
    <a  class="prev" href="javascript:void(0)"></a>
    <a  class="next" href="javascript:void(0)"></a>
    <div class="w_slider_num" ><ul></ul></div>
</div>

</div>
</div>
<div  id="view_image_39_843" class="yibuSmartViewMargin absPos"   >
    <div class='yibuFrameContent overflow_hidden image_Style1_Item0 view_image_39_843_Style1_Item0' style='height:48px;width:127px;'>    <div class="megwh" style="height:100%; width:100%;">
            <a id="autosize_view_image_39_843" href="/sy" target="_self" >
                <img  src="/theme/m1/static/images/logo.png"  alt="<?=g("cp_name")?>" style="border:none; position:relative;" />
            </a>
        </div>
    </div>
</div>


<?php 
$about = postDetail(3, 1);
 ?>
<div  id="view_text_40_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:133px;width:296px;'>
<style type="text/css">
    #view_text_40_843_txt ul{ padding-left:20px;}
</style>
<div id='view_text_40_843_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-indent: 2em; line-height: 2em;">
        <?= truncate($about['body'], 200, '...')?>
        </p>
    </div>
</div>
</div>
</div>
<div  id="view_image_41_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:39px;width:78px;'>    
<div class="megwh" style="height:100%; width:100%;">
        <a href="<?=Url::toRoute('/about.html')?>" target="_self" >
        <img  src="/theme/m1/static/images/2000002422.png"  alt="" style="border:none; position:relative;" />
        </a>
    </div>
</div>
</div>
<div  id="view_text_42_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:23px;width:52px;'>
<style type="text/css">
    #view_text_42_843_txt ul{ padding-left:20px;}
</style>
<div id='view_text_42_843_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-align: center;">
        <a href="<?=Url::toRoute('/about.html')?>" target="_self"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(255, 255, 255);">more+</span></a></p>
    </div>
</div>
</div>
</div>
<div  id="view_navigator_43_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden navigator_Style2_Item0 view_navigator_43_843_Style2_Item0' style='height:98px;width:614px;'>    
<ul id=nav_view_navigator_43_843 styleItem=Style2>
    <?php foreach ($navs as $k => $nav): ?>
        <li class=w_nav_item style=width:20%;*width:19.6%>
            <h3>
                <a href="<?=Url::toRoute($nav['url'])?>" target=_self>
                    <?=$nav['name']?>
                </a>
            </h3>
        </li>
    <?php endforeach ?>
</ul>
</div>
</div>
</div>
      </div>
    </div>
    <?=$content?>
<div style="width:100%;height:53px;background-color:#000000;margin:0 auto;">
      <div class="footer page_footer yibuLayout_tempPanel" style="width:1000px;height:53px;background-color:#000000;;">
           <div class='runTimeflowsmartView'><div  id="view_text_7_843" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:22px;width:1000px;border-style:none;'>
<style type="text/css">
    #view_text_7_843_txt ul{ padding-left:20px;}
</style>
<div id='view_text_7_843_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-align: center; color: #999; font-family: 微软雅黑;">
        <span style="color: rgb(255, 255, 255);">版权所有：<?=g("cp_name")?></span>
        <span style="color: rgb(255, 255, 255);"> &nbsp; &nbsp;技术支持：</span>
        <span style="color: rgb(255, 255, 255);">XX网络&nbsp;</span>
        </p>
    </div>
</div>

</div>
</div>
</div>
      </div>
    </div>
      </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
