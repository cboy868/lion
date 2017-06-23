<?php
use yii\widgets\LinkPager;
?>

<!----------路径分页/面包屑导航------start----->
<div class="path-page myCarousel">
    <div class="container container-fixed">
        <ol class="breadcrumb path-page-crumb">
            <li><a href="/">首页</a></li>
            <li class="active">客户案例</li>
        </ol>
    </div>
</div>
<!----------路径分页/面包屑导航------start----->


<!--**************客户案例**********start******-->
<div class="customer-case">
    <div class="container container-fixed">
        <div class="row">

            <?php foreach ($data as $v):?>
            <div class="col-xs-3 div1">
                <div class="thumbnail cus-case-div-1">
                    <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>">
                        <img src="<?=$v['cover']?>">
                    </a>

                    <div class="caption">
                        <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>"><p><?=$v['title']?></p></a>
                    </div>

                    <!--  <a href="view8-29.html" class="cus-case-bg">
                         <p class="news-p">点击查看</p>
                     </a> -->
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!--**************客户案例**********end******-->

<!--******分页********-->
<div style="text-align: center; background: #f9f9f9; min-width: 1170px;">
    <?php
    echo LinkPager::widget([
        'pagination' => $pagination,
        'nextPageLabel' => '>',
        'prevPageLabel' => '<',
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'options' =>['class'=>'pagination pagination-lg']
    ]);
    ?>
</div>
<!--******分页********-->


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