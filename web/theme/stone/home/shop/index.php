<?php
$this->title="产品与服务";
?>
<?php $focus = focus(4,1);?>
<!-------------------banner图-------------start------------>
<?php if(isset($focus[0])):?>
<div class="marketing-banner myCarousel" style="background-image: url(<?=$focus[0]['cover']?>);">
    <div class="container  container-fixed">
        <p class="text-center new-banner-text1"><?=$focus[0]['title']?></p>

        <p class="text-center new-banner-text2"><?=$focus[0]['intro']?></p>
    </div>
</div>
<?php endif;?>
<!-------------------banner图-------------end-------------->


<?php $focus = focus(2,6);?>
<div class="marketing-div-1">
    <div class="container text-center  container-fixed">
        <p class="marketing-p-1"><?=$focus['cate']['title']?></p>
        <p class="marketing-p-2"><?=$focus['cate']['intro']?></p>
        <div class="row">
            <?php foreach ($focus['focus'] as $v):?>
            <div class="col-xs-4">
                <dl>
                    <dd><img src="<?=$v['cover']?>"></dd>
                    <dd class="marketing-dd-1"><?=$v['title']?></dd>
                    <dd class="marketing-dd-2"><?=$v['intro']?></dd>
                </dl>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div class="marketing-div-2">
    <div class="container text-center  container-fixed">
        <p class="marketing-p-1 market-p-color">我们营销网站具备哪些特点？</p>
        <p class="marketing-p-2 market-p-color">十年的网站建设服务，成就如今经验丰富的我们</p>

        <div class="thumbnail visible-xs marketing-thum-style">
<!--            <img src="/theme/stone/static/images/pic72.png">-->
        </div>
    </div>
</div>


<div class="marketing-bg">
    <div class="container text-center  container-fixed">
        <div class="thumbnail marketing-thum-style">
            <img src="/theme/stone/static/images/pic72.png" style="margin-top: -370px;">
        </div>
    </div>
</div>


<?php $focus = focus(3,6);?>
<div class="marketing-div-3">
    <div class="container  container-fixed padding">
        <div class="row">
            <?php foreach ($focus['focus'] as $v):?>
            <div class="col-xs-4">
                <dl>
                    <dd class="marketing-dd-3">
                        <img src="<?=$v['cover']?>">
                        <p><?=$v['title']?></p>
                    </dd>
                    <dd class="marketing-dd-4"><?=$v['intro']?></dd>
                </dl>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>


<div class="marketing-div-4">
    <div class="container  container-fixed">
        <p class="text-center marketing-p-1">我们的经验与案例</p>
        <p class="text-center marketing-p-2 market-p">10多年互联网从业经验，成就了我们如今的专业并且让更多客户走上了网络营销之路</p>
<?php $case = cmsNewArticle(1, 8, '420x240');?>
        <div class="row">
            <?php foreach ($case as $v):?>
            <div class="col-xs-3">
                <div class="thumbnail marketing-thum-bg">
                    <img src="<?=$v['cover']?>">

                    <div class="caption">
                        <p class="marketing-p-4"><?=$v['title']?></p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>



<div class="merketing-join">
    <div class="container clearfix container-fixed">
        <div class="row">
            <div class="col-xs-6">
                <p class="pull-left marketing-p-5">已有10521家企业创建了营销网站</p>
            </div>
            <div class="col-xs-6 text-right">
                <a href="#" class="btn btn-default marketing-btn-2" data-toggle="modal" data-target="#advisory-btn-1">立即咨询</a>
            </div>
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
            }
        });
    })
</script>