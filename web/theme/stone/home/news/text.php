<?php
$this->title = $data['title'];
?>
<!----------路径分页/面包屑导航------start----->
<div class="path-page myCarousel">
    <div class="container container-fixed">
        <ol class="breadcrumb path-page-crumb">
            <li><a href="/">首页</a></li>
            <li><a href="<?=url('/news/home/default/index')?>">新闻资讯</a></li>
            <li class="active"><?=$data['title']?></li>
        </ol>
    </div>
</div>
<!----------路径分页/面包屑导航------start----->

<!--新闻内容-->
<div class="news-content">
    <!--新闻主体内容-->
    <div class="container container-fixed">
        <!--内容左边-->
        <div class="news-content left first">
            <h2><?=$data['title']?></h2>
            <b><?=$data['author']?>丨<span><?=date('Y-m-d', $data['created_at'])?> </span></b>
            <?=$data['body']?>
            <div class="clear"></div>
        </div>

        <!--内容右边-->
        <div class="news-content right">
            <h3>新闻分类</h3>

            <ul class="nav nav-pills nav-stacked nav-ul">
                <?php $cid = getParam('cid')?>
                <li class="<?php if(!$cid)echo'active'?>">
                    <a href="<?=url(['/news/home/default/index'])?>">全部</a>
                </li>
                <?php
                foreach ($cates as $cate):
                    ?>
                    <li class="<?php if($cid==$cate['id'])echo'active'?>">
                        <a href="<?=url(['/news/home/default/index', 'cid'=>$cate['id']])?>"><?=$cate['name']?></a>
                    </li>
                <?php endforeach;?>
            </ul>
            <p class="text-left news-text-2 news-text-3">热门文章</p>
            <?php $hots = news(null, 10, null, null, true);?>
            <?php foreach ($hots as $hot):?>
                <a href="<?=url(['/news/home/defualt/view','id'=>$hot['id']])?>" class="btn btn-link btn-pri" style="display: block;">
                    <?=$hot['title']?>
                </a>
            <?php endforeach;?>

            <div class="clear"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(e) {
        /*导航文字颜色切换*/
        $(".nav-inner.right li").click(function(){
            $(".nav-inner.right li a").css({"color":"#666666"});
            $(this).children("a").css({"color":"#ff5541"})
        });
        /*弹框*/
        $("[data-toggle='tooltip']").tooltip();
        $(".header-branch").click(function(){
            $(this).parents(".header").prev(".bomb").delay(100).fadeIn();
            $(this).parents(".header").prev(".bomb").children(".bomb-inner").delay(200).fadeIn();
        })
        $(".bomb-inner-title img").click(function(){
            $(this).parents(".bomb").delay(100).fadeOut();
            $(this).parents(".bomb-inner").delay(200).fadeOut();
        })
        /*内容切换*/
        $(".news-content.title.first").css({"color":"#fff","background":"#ff5642"});
        $(".news-content.left.first").css({"display":"block"})
        $(".news-content.title.first").click(function(){
            $(".news-content.left.first").css({"display":"block"});
            $(".news-content.left.second").css({"display":"none"});
            $(this).css({"color":"#fff","background":"#ff5642"})
                .siblings().css({"color":"#333333","background":"#fff"});
        })
        $(".news-content.title.second").click(function(){
            $(".news-content.left.second").css({"display":"block"});
            $(".news-content.left.first").css({"display":"none"});
            $(this).css({"color":"#fff","background":"#ff5642"})
                .siblings().css({"color":"#333333","background":"#fff"});
        });



        /*
         *   导航浮动
         */
        $(document).scroll(function () {
            var top = $(document).scrollTop();
            if (top > 40) {
                $(".navbar-style").addClass("navbar-display");
                $(".header-pos").addClass("header-fixed");
                $(".header-pos .navbar-inverse").css({"box-shadow": "0px 3px 18px -5px #aaa"});
            } else {
                $(".navbar-style").removeClass("navbar-display");
                $(".header-pos").removeClass("header-fixed");
                $(".header-pos .navbar-inverse").css({"box-shadow": "none"});
            }
        });
    })
</script>