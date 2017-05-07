<link rel="stylesheet" type="text/css" href="/theme/m1/static/css/contact.css">
<div class="main-wrap clearfix" style="*z-index:10;*position:relative;width:100%;margin-left:auto;margin-right:auto;;background-color:">
        <div class="main clearfix page_main" style="width:1000px;">
        	<div class="content yibuLayout_Body" style="min-height:100px;margin-left:auto;margin-right:auto;;background-color:;background-color:" id="yibuLayout_center">
        	    <div  id="view_main_1_1266" class="mainSamrtView yibuSmartViewMargin"   >
<div class='yibuFrameContent main__Item0' style='height:495px;width:100%;border-style:none;'>
<div class='runTimeflowsmartView'>

<div  id="view_map_12_1266" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden map_Style1_Item0' style='height:343px;width:1000px;'>    
<div id="view_map_12_1266_allmap" style="height: 343px; width: 1000px;">
    
</div>


<script type="text/javascript" src="/theme/m1/static/js/baidumap.js"></script>
<script type="text/javascript">
                //创建和初始化地图函数：
                function initMap(){
                    createMap();//创建地图
                    setMapEvent();//设置地图事件
                    addMapControl();//向地图添加控件
                    addMarker();//向地图中添加marker
                }
                
                //创建地图函数：
                function createMap(){
                    var map = new BMap.Map("view_map_12_1266_allmap");//在百度地图容器中创建一个地图
                    var point = new BMap.Point(<?=g("point")?>);//定义一个中心点坐标
                    map.centerAndZoom(point,17);//设定地图的中心点和坐标并将地图显示在地图容器中
                    
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
                var markerArr = [{title:"<?=g('cp_name')?>",content:"联系方式：<?=g("cmobile")?><br />邮箱地址：<?=g("uemail")?><br />联系地址：<?=g("address")?>",point:"<?=g("point")?>",isOpen:1,icon:{w:19,h:25,l:0,t:0,x:6,lb:5}}
                     ];
                //创建marker
                function addMarker(){
                    for(var i=0;i<markerArr.length;i++){
                        var json = markerArr[i];
                        var p0 = json.point.split(",")[0];
                        var p1 = json.point.split(",")[1];
                        var point = new BMap.Point(p0,p1);
                        var marker = new BMap.Marker(point);
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
                    var icon = new BMap.Icon("demo/images/markers.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
                    return icon;
                }
                
                initMap();//创建和初始化地图
            </script>
















            </div>
</div>
</div></div>
</div>

        	</div>
        </div>
    </div>