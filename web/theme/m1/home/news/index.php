<link rel="stylesheet" type="text/css" href="/theme/m1/static/css/abc.css">

    <div class="main-wrap clearfix" style="*z-index:10;*position:relative;width:100%;margin-left:auto;margin-right:auto;;background-color:">
        <div class="main clearfix page_main" style="width:1000px;">
            <div class="content yibuLayout_Body" style="min-height:100px;margin-left:auto;margin-right:auto;;background-color:;background-color:" id="yibuLayout_center">
                <div  id="view_main_1_37674" class="mainSamrtView yibuSmartViewMargin"   >
<div class='yibuFrameContent main__Item0' style='height:590px;width:100%;'><div class='runTimeflowsmartView'><div  id="view_listnews_9_37674" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden listnews_Style2_Item0 view_listnews_9_37674_Style2_Item0' style='height:587px;width:999px;'>    <div class="w-list">
        <ul class="w-list-ul" id="ulList_view_listnews_9_37674">

            <?php foreach ($list as $k => $v): ?>
                <li class=" w-list-nopic  f-clearfix">
                    <div class="w-list-pic" >
                        <a href="/newsv/<?=$v['id']?>.html" target="_blank">
                            <img src="<?=$v['cover']?>" alt="" />
                        </a>
                    </div>
                    <div class="w-list-r" style="margin-left: 120px;">
                        <div class="w-list-r-in">
                            <h3 class="w-list-title">
                                <a href="/newsv/<?=$v['id']?>.html" target="_blank"><?=$v['title']?></a>
                            </h3>
                            <p class="w-list-desc" >
                            <?=$v['summary']?>
                            </p>
                            <div class="w-list-bottom clearfix" >
                                <span class="w-list-viewnum"  >
                                <i class="icon iconfont">&#xf06e;</i><span class="AR" data-dt="nvc" data-key="277174441"><?=$v['view_all']?></span></span>
                                <span class="w-list-date" ><?=date('Y-m-d H:i', $v['created_at'])?></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<div class="w_pager f_clearfix" id="pager_view_listnews_9_37674"><div class="w-pageline"style="float: none">
<ul class='w-page-square  w-clearfix'id='pagerHtml'>
<li><a href="javascript:;" class="w-page-cm w-page-flip"id="prePage"><span>上一页</span><i>&lt;</i></a></li><li><a href="javascript:;" class="w-page-cm activi">1</a></li><li><a href="javascript:;" class="w-page-cm">2</a></li><li style="margin-right: 0px;"><a href="javascript:;" class="w-page-cm  w-page-flip"id="nextPage"><span>下一页</span><i>&gt;</i></a></li></ul></div></div><script type="text/javascript">$(function(){PcListPagination("view_listnews_9_37674","newsList","PageNumber","5","2","-1","","1","CreatedOnUtc","DESC","off","","","False","False","view_listnews_9_37674_callback")});</script>        <script type="text/template" id="listTemplate_view_listnews_9_37674">
            $if (data.ImageUrl==""|| "False".toLowerCase()=="false")
            {
            <li class="w-list-nopic f-clearfix">
                <div class="w-list-pic" style="display:none;">
                    }
                    else
                    {
            <li class="f-clearfix">
                <div class="w-list-pic">
                    }
                    <a href="$data.Url" target="_blank">
                        <img src="/theme/m1/static/images/$data.imageurl" alt="" />
                    </a>
                </div>
                <div class="w-list-r">
                    <div class="w-list-r-in">
                        <h3 class="w-list-title"><a href="$data.Url" target="_blank">$data.Title</a></h3>
                        <p class="w-list-desc" >$data.Description</p>
                        <div class="w-list-bottom clearfix" >
                            <span class="w-list-viewnum" ><i class="icon iconfont">&#xf06e;</i>$data.Hits</span>
                            <span class="w-list-date" >$data.CreateTimeStr</span>
                        </div>
                    </div>
                </div>
            </li>
        </script>
    <script>
        function view_listnews_9_37674_callback() {
            var desc_line_height = $("#view_listnews_9_37674 .w-list-desc").css("line-height");
            $("#view_listnews_9_37674 .w-list-desc").css("max-height", parseInt(desc_line_height) * 2);

            var title_height = $("#view_listnews_9_37674 .w-list-title a").css("height");
            $("#view_listnews_9_37674 .w-list-nopic").css("min-height", parseInt(title_height));
        };
        $(function () {
            view_listnews_9_37674_callback()
        });
    </script>
</div>
</div>
</div></div>
</div>

            </div>
        </div>
    </div>
   