<?php
use yii\widgets\LinkPager;

$this->title = '新闻资讯';
?>
<!-------------------banner图-------------start------------>
<div class="banner myCarousel">
    <div class="container container-fixed">
        <p class="text-center new-banner-text1">新闻资讯</p>

        <p class="text-center new-banner-text2">提供最新最热的动态，产品活动相关资讯平台</p>
    </div>
</div>
<!-------------------banner图-------------end-------------->

<!--------------------新闻列表-------------start----------->
<section id="news-list">
    <div class="container container-fixed">
        <div class="row">
            <div class="col-xs-3 tab-wrap">
                <p class="text-left news-text-2">新闻分类</p>
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
            </div>


            <div class="col-xs-9">
                <div class="tab-content">
                    <p class="text-left news-text-2">新闻资讯</p>

                    <div class="tab-pane fade active  in" id="tab1">
                        <?php foreach ($list as $v):?>
                        <div class="media media-1">
                            <div class="pull-left first">
                                <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>">
                                    <img class="img-responsive" src="<?=$v['cover']?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <h3 class="news-title-1"><a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="news-title-1-cl"><?=$v['title']?></a></h3>

                                <p class="news-text-1">
                                    <?=$v['summary']?>
                                </p>
                                <div class="clear">
                                    <p class="pull-left news-text-4 p-line-height"><?=$v['author']?>&nbsp;|&nbsp;
                                        <label class="time"><?=date('Y-m-d H:i',$v['created_at'])?></label>
                                    </p>
                                    <p class="pull-right p-line-height">
                                        <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="btn text-right">阅读全文
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <!--******分页********-->
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $pagination,
                            'nextPageLabel' => '>',
                            'prevPageLabel' => '<',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '尾页',
                            'options' =>['class'=>'pagination','style'=>'float:right;']
                        ]);
                        ?>
                        <!--******分页********-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--/#content-->
<!--------------------新闻列表-------------end------------->



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