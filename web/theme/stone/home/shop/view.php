<?php
$this->title = $data['name'];
?>
<link rel="stylesheet" href="/theme/juding/static/css/base.css">
    <style type="text/css">
    .clearfix:after{content:""; display:block; visibility:hidden; height:0; clear:both;}
    .clearfix{zoom:1;}
    .xq-l .por-r{margin-right: 2%; width:73%;  float:right; }
    .xq-l .por-r ul{left: 0; width: :100%;/*height:auto;*/}
    .xq-l .por-r ul li{ /*max-height:380px;*//*float: left;margin-right: 14px;*//*position: absolute;left:0;top:0;*/width:100%; overflow:hidden; display:block;}
    .xq-l .por-r ul li img{width: 100%;}
    .xq .xq-l .por-l {
        height: 300px;
    }
    #time {
        height: 358px;
    }
    .imgc{border-radius:50px;width:50px;height:50px;}
    .xq-type{left:2%;width:98%; text-align:center;/*position:relative;bottom: 0;top:150%;*/margin-top:5%;}
</style>
<!-- 内容区 -->
<div class="inside-focus">
    <img src="<?=$data['cover']?>" alt="" />
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置：
            <a href="/">网站首页</a> &gt
            <a href="<?=url(['/shop/home/default/index'])?>">产品展厅</a> &gt;
            <a href="#"><?=$data['name']?></a>
        </span>
    </div>
</div>
<div class="xq wrap clearfix" >
    <!-- 内容左分区banner -->
    <div class="xq-l fl clearfix" style="border:solid 0px #000;">
        <div class="por-r" >
            <ul  >
                <?php foreach ($thumbs as $v):?>
                    <li><img src="<?=$v['url']?>"></li>
                <?php endforeach;?>
            </ul>
        </div>

        <div class="por-l pro-detail-l" >
            <span  class="anniu_top"></span>
            <div id="time">
                <ul class="demo-01 clearfix" >
                    <?php foreach ($thumbs as $v):?>
                    <li><img src="<?=$v['url']?>"></li>
                    <?php endforeach;?>
                </ul>
            </div>

            <span class="anniu_bottom"></span>
        </div>

    </div>

    <script type="text/javascript">
        $(function(){
            $(window).on('load resize',  function(event) {
                $(".xq-l .por-r").css("height",$(".por-r ul li").height());
            });
            $(".pro-detail-l ul li").click(function(event) {
                var index = $(this).index();
                $(this).addClass('on').siblings('li').removeClass('on');
                $(".xq-l .por-r ul li").eq(index).siblings('li').hide();
                $(".xq-l .por-r ul li").eq(index).fadeIn("fast");

            });
            $(".pro-detail-l ul li").eq(0).click();
            var listL = $(".pro-detail-l ul li").length;
            var a = 0;
            var aa=0;
            // var cc;
            $(".anniu_bottom").click(function(event) {
                // var cc = listL - a;

                if(a>=listL-5){
                    a=0
                    $(".pro-detail-l ul").animate({"top":0}, 200);
                }else{
                    a++;
                    $(".pro-detail-l ul").animate({"top":-a*90}, 200);
                }
                aa = a;
            });
            //
            $(".anniu_top").click(function(event) {

                if(aa == 0){
                    $(".pro-detail-l ul").animate({"top":0}, 200);
                    a=0;


                }else{
                    aa--;
                    $(".pro-detail-l ul").animate({"top":-aa*90}, 200);
                    a=aa;
                }
                if(aa < 0){
                    aa=0;
                    $(".pro-detail-l ul").animate({"top":0}, 200);

                };
            });


        });
    </script>

    <!-- 内容右分区 -->
    <div class="xq-r fr">
        <h3><?=$data['name']?></h3>
        <div>
            <?=$data['intro']?>
        </div>
    </div>
</div>
<div style="clear:both;height:40px;"></div>
<div class="xq-bom" >
    <ul class="clearfix">
        <li>
            <p><span>免费上门测量</span></p>
            <span>上门测量服务，专业装修建议</span>
        </li>
        <li>
            <p><span>免费方案设计</span></p>
            <span>设计装修方案，呈现优质服务</span>
        </li>
        <li>
            <p><span>一体化配送安装</span></p>
            <span>专人送货上门，让您一步到位</span>
        </li>
    </ul>

</div>