<?php
use yii\widgets\LinkPager;

$this->title="卓迅知识库";
?>
<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<script type='text/javascript' src="/theme/zhuoxun/static/js/itbeing.js"></script>
<script type='text/javascript' src="/theme/zhuoxun/static/js/jquery.itbeing.js"></script>
<?php $focus = focus(3, 1, '2560x600')?>
<div class="about_box" style="background:url(<?=$focus['focus'][0]['cover']?>) no-repeat center top; background-size:cover;"></div>
<!--about-->
<div id="case_con">
    <div class="blog_tab">
        <?php $cates = cmsCates(8, [17,18,19,20,21,22]);?>
        <ul>
            <?php $cid = Yii::$app->request->get('cid');?>
            <li><a href="<?=url(['/cms/home/knowledge/index'])?>"  class="case_category <?php if(!$cid)echo'current';?>" >最近更新</a></li>
            <?php foreach ($cates as $v):?>
            <li>
                <a href="<?=url(['/cms/home/knowledge/index', 'cid'=>$v['id']])?>"
                   class="case_category <?php if($cid == $v['id'])echo'current';?>" >
                    <?=$v['name']?>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <!--blog_tab-->
    <div class="case blogs">
        <div class="case_con blog_bg blogs_con">
            <?php foreach ($data as $v): ?>
            <dl>
                <dd style="background:url(<?=$v['cover']?>) no-repeat center center; background-size:cover;height: 220px">
                    <a href="<?=url(['/cms/home/knowledge/view', 'id'=>$v['id']])?>"></a>
                </dd>
                <dt>
                <h3>
                    <a href="<?=url(['/cms/home/knowledge/view', 'id'=>$v['id']])?>">
                        <?=$v['title']?>
                    </a>
                </h3>
                </dt>
                <dt><?=$v['author']?>   <?=date('Y-m-d', $v['created_at'])?></dt>
                <dt style="height: 48px;overflow: hidden;">
                    <?=$v['summary']?>
                </dt>
            </dl>
            <?php endforeach;?>
        </div>
        <div class="pagess">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'nextPageLabel' => '>',
                'prevPageLabel' => '<',
                'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',
            ]);
            ?>
            <div class="addmore">
                <div class="loading-sk-circle" style="display: none">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
                <span>加载更多</span>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 5);
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.weixin2').click(function(){
            $('.theme-mask').show();
            $('.theme-mask').height($(document).height());
            $('.popover1').slideDown(200);
        })
        $('.close').click(function(){
            $('.theme-mask').hide();
            $('.popover1').slideUp(200);
        })
    })
</script>
<script>
    $(function(){
        // 页数
        var page = '1';
        $(".addmore").on('click', function(){
            var result = ''
            page++;
            $(".loading-sk-circle").show();
            $.ajax({
                type: 'GET',
                url: '/article/get_page?type_id=2&page='+page,
                dataType: 'json',
                success: function(data){
                    if(data.status){
                        for(var i in data.cases){
                            result +=  '<dl>'+
                                '<dd style="background:url('+data.cases[i].image_mid+') no-repeat center center; background-size:cover;"><a href="/article/'+data.cases[i].id+'.html"></a></dd>'+
                                '<dt>'+
                                '<h3><a href="/article/'+data.cases[i].id+'.html">'+data.cases[i].title+'</a></h3>'+
                                '</dt>'+
                                '<dt>创意设计   '+data.cases[i].addtime+'</dt>'+
                                '<dt>'+data.cases[i].daodu+'...</dt>'+
                                '</dl>';
                        }
                        // 如果没有数据
                    }else{
                        $(".addmore").find("span").html("没有更多数据了")
                    }
                    $('.case_con').append(result);
                    $(".loading-sk-circle").hide();
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    $(".loading-sk-circle").hide();
                    // 即使加载出错，也得重置
                }
            });
        })
    });
</script>