<?php
$this->title="关于我们"
?>
<!-------------------banner图-------------start------------>
<div class="development-banner myCarousel">
    <div class="container container-fixed">
        <p class="text-center new-banner-text1">关于我们</p>

        <p class="text-center new-banner-text2">文字描述</p>
    </div>
</div>
<!-------------------banner图-------------end-------------->


<div class="aboutUS-btn-div">
    <div class="container container-fixed">
        <ul id="aboutUS-btn" class="nav nav-pills nav-justified">
            <li class="active">
                <a class="aboutUS-btn-link" href="#com-profile" data-toggle="tab">公司简介</a>

            </li>
            <li>
                <a class="aboutUS-btn-link" href="#dev-path" data-toggle="tab">发展历程</a>
            </li>
            <li>
                <a class="aboutUS-btn-link" href="#contact-us" data-toggle="tab">联系我们</a>
            </li>

        </ul>

        <div id="aboutUS-content" class="tab-content">

            <!--第一屏-->
            <div class="tab-pane fade in active" id="com-profile">
                <div class="aboutUs-content-replace first">
                    <p class="text-left us-text-1">关于<?=g('cp_name')?></p>

                    <div class="aboutUs-first">
                        <a class="aboutUs-firs-pic left">
                            <img class="media-object" src="<?=$module['logo']?>" style="width:100%;">
                        </a>

                        <div class="aboutUs-firs-write right" style="">
                            <p class="us-media-p">
                                <?=formatterNtext($module['intro']) ?>
                            </p>

                        </div>
                    </div>

                    <p class="text-left us-text-1"><?=g('cp_name')?>文化核心理念</p>

                    <?php $post = cmsArticle(2, 3, 8);?>
                    <div class="row us-margin-top">
                        <?php foreach ($post['list']['child'] as $v):?>
                        <div class="col-xs-3">
                            <div class="thumbnail us-thumbnail">
                                <img src="<?=$v['cover']?>">

                                <div class="caption us-caption">
                                    <h3 class="us-caption-text-1"><?=$v['title']?></h3>
                                    <span class="us-caption-text-2"><?=$v['body']?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

            <!--第二屏-->
            <div class="tab-pane" id="dev-path">
                <?php $post = cmsArticle(2, 5, 10);?>
                <div class="cd-timeline-title"><h2><?=g('cp_name')?>大纪事</h2></div>
                <div id="cd-timeline" class="cd-container container-fixed">
                    <?php foreach ($post['list']['child'] as $v):?>
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-picture"></div>

                        <div class="cd-timeline-content">
                            <h2><?=$v['title']?></h2>

                            <p class="cd-timeline-p1"><?=$v['subtitle']?></p>

                            <p class="cd-timeline-p2">
                                <?=$v['body']?>
                            </p>
                        </div>
                        <!-- cd-timeline-content -->
                    </div>
                    <?php endforeach;?>
                    <!-- cd-timeline-block -->
                </div>
            </div>

            <!--第四屏-->
            <div class="tab-pane" id="contact-us">
                <div class="map" id="contenta" style="height:400px;margin:0px auto;">
                </div>
            </div>
        </div>
    </div>
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
            };
        });
    })
</script>

<div class="mapcontent" style="display: none;">
        <?=g("hotline")?><br />
        邮箱：<?=g("uemail")?><br />
        传真：<?=g("chuanzhen")?><br />
        地址：<?=g("address")?><br />
</div>


<!--引用百度地图API-->
<style type="text/css">

</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>

<script type="text/javascript">
    $(function () {
        //创建和初始化地图函数：
        function initMap(){
            createMap();//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            addMarker();//向地图中添加marker
        }
        <?php
        $point = g("point");
        $parr = explode(',', $point);
        ?>
        //创建地图函数：
        function createMap(){
            var map = new BMap.Map("contenta");//在百度地图容器中创建一个地图
            var point = new BMap.Point(<?=$point?>);//定义一个中心点坐标
            map.centerAndZoom(point,17);//设定地图的中心点和坐标并将地图显示在地图容器中
            map.panBy(500, 200);
            map.setViewport(<?=$point?>);
            window.map = map;//将map变量存储在全局
        }

        //地图事件设置函数：
        function setMapEvent(){
            map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
            map.enableScrollWheelZoom();//启用地图滚轮放大缩小
            map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
            map.enableKeyboard();//启用键盘上下左右键移动地图
        }

        //地图控件添加函数：
        function addMapControl(){
            //向地图中添加缩放控件
            var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
            map.addControl(ctrl_nav);
            //向地图中添加缩略图控件
            var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
            map.addControl(ctrl_ove);
            //向地图中添加比例尺控件
            var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
            map.addControl(ctrl_sca);
        }



        //标注点数组
        var markerArr = [{
            title:"<?=g("fullname")?>",
            content:$('.mapcontent').html(),
            point:"<?=$parr[0]?>|<?=$parr[1]?>",
            isOpen:1,icon:{w:23,h:25,l:46,t:21,x:9,lb:12}}
        ];
        //创建marker
        function addMarker(){
            for(var i=0;i<markerArr.length;i++){
                var json = markerArr[i];
                var p0 = json.point.split("|")[0];
                var p1 = json.point.split("|")[1];
                var point = new BMap.Point(p0,p1);
                var iconImg = createIcon(json.icon);
                var marker = new BMap.Marker(point,{icon:iconImg});
                var iw = createInfoWindow(i);
                var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
                marker.setLabel(label);
                map.addOverlay(marker);
                label.setStyle({
                    borderColor:"#808080",
                    color:"#333",
                    cursor:"pointer"
                });

                (function(){
                    var index = i;
                    var _iw = createInfoWindow(i);
                    var _marker = marker;
                    _marker.addEventListener("click",function(){
                        this.openInfoWindow(_iw);
                    });
                    _iw.addEventListener("open",function(){
                        _marker.getLabel().hide();
                    })
                    _iw.addEventListener("close",function(){
                        _marker.getLabel().show();
                    })
                    label.addEventListener("click",function(){
                        _marker.openInfoWindow(_iw);
                    })
                    if(!!json.isOpen){
                        label.hide();
                        _marker.openInfoWindow(_iw);
                    }
                })()
            }
        }
        //创建InfoWindow
        function createInfoWindow(i){
            var json = markerArr[i];
            var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
            return iw;
        }
        //创建一个Icon
        function createIcon(json){
            var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
            return icon;
        }

        initMap();//创建和初始化地图
    });

</script>