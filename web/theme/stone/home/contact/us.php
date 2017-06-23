<?php
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
$this->title = '联系我们';
?>
<div class="inside-focus">
    <img src="<?=$module['logo']?>" alt="联系我们" />
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置：
            <a href="/">网站首页</a> &gt
            <a href="#">联系我们</a>
        </span>
    </div>
</div>
<div class="inside-title">
    <h2 class="en">CONTACT US</h2>
    <h2 class="cn">联系我们</h2>
</div>
<div class="clearfix wrap contact">
    <div class="contact-way fl">
        <h2>
            联系方式
        </h2>
        <h3>
            <?=g("fullname")?>
        </h3>
        <ul>
            <li>
                <p>
                    招商加盟热线
                </p>
                <i></i>
                <p>
                    <?=g("cmobile")?>
                </p>
            </li>
            <li>
                <p>
                    地址
                </p>
                <i></i>
                <p>
                    营销中心总部<br />
                    <span style="line-height:1.5;"><?=g("address")?></span>
                </p>
            </li>
            <li>
                <p>
                    客服热线
                </p>
                <i></i>
                <p>
                    <?=g("hotline")?>
                </p>
            </li>
            <li>
                <p>
                    传真
                </p>
                <i></i>
                <p>
                    <?=g("chuanzhen")?>
                </p>
            </li>
        </ul>
        <!--
        <div class="qrcode">

            <span> <img src="/Uploads/201607/577f033b21728.jpg" alt="" />
                <p>
                    軒尼斯服务号
                </p>
            </span>
            <span> <img src="/Uploads/201607/577f031780d09.jpg" alt="" />
                <p>
                    軒尼斯订阅号
                </p>
            </span>
        </div>
           -->
    </div>

    <style>
        .field-msgform-verifycode{
            width:50%;
            float: left;
        }
        img#captchaimg{
            width:30%;
            display: inline-block;
        }
        .has-error .help-block{
            color:red;
        }
        .form-group{
            margin-bottom:10px;
        }
        .contact-Leave input{
            margin-bottom:0;
        }
        div.msg{
            height: 40px;
            line-height:40px;
            color: green;
            font-size: 25px;
            border-bottom: 1px solid green;
        }
    </style>
    <div class="contact-Leave fr">

        <h2>在线留言</h2>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="msg">
            <?=Yii::$app->session->getFlash('success')?>
        </div>
        <?php endif;?>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('留言主题<font color="red">(*)</font>') ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('姓名<font color="red">(*)</font>') ?>
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label('电话') ?>
        <?= $form->field($model, 'intro')->textarea(['rows' => 6, 'class'=>'intro form-control'])->label('留言内容') ?>

        <?= $form->field($model, 'verifyCode')->textInput()->label('验证码') ?>
        <?=Captcha::widget([
            'name'=>'captchaimg',
            'captchaAction'=>'/home/default/captcha',
            'imageOptions'=>['id'=>'captchaimg',
                'title'=>'Refresh',
                'alt'=>'Refresh',
                'style'=>'cursor:pointer;'],
            'template'=>'{image}'
        ]);
        ?>
        <input type="submit" class="submit" value="发送" style="cursor: pointer;"/>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<script type="text/javascript" src="/Public/guangfan/js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function(){

        $('#myform').submit(function(){
            var c1 = $('#check5').val();
            var c2 = $('#check7').val();
            var c3 = $('#check8').val();
            var c4 = $('#check9').val();

            if(c1=='' && c2=='' && c3=='' && c4=='' ){
                alert('您没有填写完所有必填项哦');
                return false;
            }
        });

    })

</script>
<div class="map"  id="contenta">

</div>

<!--引用百度地图API-->
<style type="text/css">
    html,body{margin:0;padding:0;}
    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word;}

</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>

<script type="text/javascript">
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
        content:"<?=g("address")?>",
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
</script>