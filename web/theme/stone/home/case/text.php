<?php
$this->title=$model['title'];
?>
<!--客户<!----------路径分页/面包屑导航------start----->
<div class="path-page myCarousel">
    <div class="container">
        <ol class="breadcrumb path-page-crumb">
            <li><a href="/">首页</a></li>
            <li><a href="<?=url(['/cms/home/case/index'])?>">客户案例</a></li>
            <li class="active"><?=$model['title']?></li>
        </ol>
    </div>
</div>
<!----------路径分页/面包屑导航------start----->
<style>
    .curdtl-cont p{
        padding-bottom: 10px;
    }
</style>
<!--客户详情内容-->
<div class="curdtl">
    <div class="container container-fixed">
        <!--标题-->
        <div class="curdtl-title">
            <h3><?=$model['title']?></h3>
            <span><b><?=$model['author']?>丨</b><?=date('Y-m-d', $model['created_at'])?> </span>
        </div>

        <div class="curdtl-cont">
            <?=$model['body']?>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
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
            };
        });
    })
</script>