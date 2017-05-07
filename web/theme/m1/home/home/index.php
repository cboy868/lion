
    <div class="main-wrap clearfix" style="*z-index:10;*position:relative;width:100%;margin-left:auto;margin-right:auto;;background-color:">
        <div class="main clearfix page_main" style="width:1000px;">
            <div class="content yibuLayout_Body" style="min-height:100px;margin-left:auto;margin-right:auto;;background-color:;background-color:" id="yibuLayout_center">
                <div  id="view_main_1_277327905" class="mainSamrtView yibuSmartViewMargin"   >
<div class='yibuFrameContent main__Item0' style='height:1966px;width:100%;'><div class='runTimeflowsmartView'><div  id="view_photoalbum_3_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden photoalbum_Style2_Item0 view_photoalbum_3_277327905_Style2_Item0' style='height:660px;width:1000px;'><div class="w_slider_2 renderfullScreen w_slider_2_view_photoalbum_3_277327905">
<?php 

$f = focus(7,5);
 ?>
    <div class="w_slider_img">
        <ul>

        <?php foreach ($f as $k => $v): ?>
                <li style="background: url(<?=$v['image']?>) center 0 no-repeat;">
                    <div class="siteWidth">
                        <p class="txt"   style="display:none;">
                            <span class="btn"></span>
                        </p>
                        <p class="txtDesc"   style="display: none;"         >
                            <?=$v['title']?>
                        </p>
                        <a style=" cursor:default" title="" ></a>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
    <a   style="display:none;"     class="prev" href="javascript:void(0)"></a>
    <a   style="display:none;"     class="next" href="javascript:void(0)"></a>

    <div class="w_slider_num"   style="display:none;"      ><ul></ul></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ("fade"=="fold") {
            setRenderFullScreen($("#view_photoalbum_3_277327905"), "window");
        } else {
            setRenderFullScreen($("#view_photoalbum_3_277327905"));
        }
        $(".w_slider_2_view_photoalbum_3_277327905").slide({
            titCell: $(".w_slider_2_view_photoalbum_3_277327905 .w_slider_num ul"),
            mainCell: $(".w_slider_2_view_photoalbum_3_277327905 .w_slider_img ul"),
            effect: "fade",
            autoPlay: "true",
            autoPage: true,
            trigger: "click",
            interTime: "1500"
        });
    });


</script></div>
</div>
<div  id="view_image_5_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:574px;width:221px;'>    <div class="megwh" style="height:100%; width:100%;">
        <a id="autosize_view_image_5_277327905" href="/products.html" target="_self" >
        <img  src="/theme/m1/static/images/2000002429.png"  alt="" style="border:none; position:relative;" />
        </a>
    </div>
</div>
</div>
<div  id="view_text_6_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:147px;width:716px;'>
<style type="text/css">
    #view_text_6_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_6_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 30px;">文化产业项目产品&nbsp;</span><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(192, 0, 0);">Products</span></p><p><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(192, 0, 0);"><br/></span></p><p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);">
        <?=g("pa")?>
        </span></p>
    </div>
</div>
</div>
</div>
<?php 
$cates = ProductCateList(4, '52x44');

 ?>
<?php $i=0; foreach ($cates as $k => $v): ?>
    <div class="yibuSmartViewMargin absPos view_text" style="left:<?=285+160*$i?>px"  >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:106px;width:100px;'>
<style type="text/css">
    .view_text_7_277327905_txt ul{ padding-left:20px;}
</style>
<div  style="cursor:default; height:100%; width:100%;"  class="view_text_7_277327905_txt">
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-align: center;"><a href="/products/<?=$v['id']?>.html" target="_self"><img src="<?=$v['cover']?>"/></a></p><p><br/></p><p style="text-align: center;"><a href="/products.html" target="_self" style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0); text-decoration: none;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);"><?=$v['name']?></span></a></p>
    </div>
</div>
</div>
</div>
<?php $i++; endforeach ?>



<div id="view_text_11_277327905" class="yibuSmartViewMargin absPos yibulocked" oldbottom="582">
<div class="yibuFrameContent overflow_hidden text_Style1_Item0" style="height:56px;width:537px;">
<div id="view_text_11_277327905_txt" style="cursor:default; height:100%; width:100%;">
    <div class="editableContent " style="line-height:1.5;">
        <p><span style="font-family: 微软雅黑, 'Microsoft YaHei'; font-size: 14px; color: rgb(255, 255, 255);"><?=g("pb")?></span></p>
    </div>
</div>
</div>
</div>




<div  id="view_image_12_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:39px;width:78px;'>    <div class="megwh" style="height:100%; width:100%;">
        <a id="autosize_view_image_12_277327905" href="javascript:void(0)" target="_self" >
            <input id="canadjustheight_view_image_12_277327905" type="hidden" value="False" />
            <img  src="/theme/m1/static/images/2000002422.png"  alt="" style="border:none; position:relative;" />
            
        </a>
    </div>
    <script type="text/javascript">
        $(function () {
            ChangeImage("view_image_12_277327905");
        });
    </script>
</div>
</div>
<div  id="view_text_13_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:22px;width:54px;'>
<style type="text/css">
    #view_text_13_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_13_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-align: center; line-height: 2em;"><a href="/products.html" target="_self"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(255, 255, 255);">more+</span></a></p>
    </div>
</div>
</div>
</div>
<div  id="view_image_14_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:460px;width:134px;'>    <div class="megwh" style="height:100%; width:100%;">
        <a id="autosize_view_image_14_277327905" href="javascript:void(0)" target="_self" >
            <input id="canadjustheight_view_image_14_277327905" type="hidden" value="False" />
                <img  src="/theme/m1/static/images/2000002430.png"  alt="" style="border:none; position:relative;" />
            
        </a>
    </div>
</div>
</div>
<div  id="view_text_16_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:335px;width:215px;'>
<style type="text/css">
    #view_text_16_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_16_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="line-height: 2em;"><span style=" font-size: 30px;"><br/></span></p><p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 30px;">产品展示</span></p><p style="line-height: 2em;"><span style="color: rgb(192, 0, 0); font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; line-height: 2em;">Products</span><br/></p><p><br/></p><p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px;"><?=g("pc")?></span></p>
    </div>
</div>
</div>
</div>
<div  id="view_image_17_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:39px;width:78px;'>    
<div class="megwh" style="height:100%; width:100%;">
    <a id="autosize_view_image_17_277327905" href="javascript:void(0)" target="_self" >
        <img  src="/theme/m1/static/images/2000002422.png"  alt="" style="border:none; position:relative;" />
    </a>
</div>
</div>
</div>
<div  id="view_text_18_277327905" class="yibuSmartViewMargin absPos yibulocked"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:22px;width:54px;'>
<style type="text/css">
    #view_text_18_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_18_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="text-align: center; line-height: 2em;"><a href="/products.html" target="_self"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(255, 255, 255);">more+</span></a></p>
    </div>
</div>
</div>
</div>
<div  id="view_photoalbum_19_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden photoalbum_Style2_Item0 view_photoalbum_19_277327905_Style2_Item0' style='height:735px;width:1000px;'><div class="w_slider_2 renderfullScreen w_slider_2_view_photoalbum_19_277327905">

<?php 

$fc = focus(8,5);
 ?>
    <div class="w_slider_img">
        <ul>
            <?php foreach ($fc as $k => $v): ?>
                <li style="background: url(<?=$v['image']?>) center 0 no-repeat;" style="height:735px;">
                    <div class="siteWidth">

                        <p class="txt"   style="display:none;"       >
                            
                            <span class="btn"></span>
                        </p>
                        <p class="txtDesc"   style="display: none;"         >
                            <?=$v['title']?>
                        </p>

                        <a   style=" cursor:default" title="" ></a>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
    <a   style="display:none;"     class="prev" href="javascript:void(0)"></a>
    <a   style="display:none;"     class="next" href="javascript:void(0)"></a>

    <div class="w_slider_num"   style="display:none;"      ><ul></ul></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ("fade"=="fold") {
            setRenderFullScreen($("#view_photoalbum_19_277327905"), "window");
        } else {
            setRenderFullScreen($("#view_photoalbum_19_277327905"));
        }
        $(".w_slider_2_view_photoalbum_19_277327905").slide({
            titCell: $(".w_slider_2_view_photoalbum_19_277327905 .w_slider_num ul"),
            mainCell: $(".w_slider_2_view_photoalbum_19_277327905 .w_slider_img ul"),
            effect: "fade",
            autoPlay: "true",
            autoPage: true,
            trigger: "click",
            interTime: "3000"
        });
    });


</script></div>
</div>
<div  id="view_image_20_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:496px;width:718px;'>    <div class="megwh" style="height:100%; width:100%;">
        <a id="autosize_view_image_20_277327905" href="/lxwm" target="_self" >
            <img  src="/theme/m1/static/images/2000002431.png"  alt="" style="border:none; position:relative;" />
        </a>
    </div>
</div>
</div>
<div  id="view_text_21_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:54px;width:262px;'>
<style type="text/css">
    #view_text_21_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_21_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 30px; color: rgb(0, 0, 0);">联系我们</span><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 30px;">&nbsp;</span><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(192, 0, 0);">Contact us</span></p>
    </div>
</div>

</div>
</div>
<div  id="view_text_22_277327905" class="yibuSmartViewMargin absPos yibulocked"   >
<div class='yibuFrameContent overflow_hidden text_Style1_Item0' style='height:168px;width:275px;'>
<style type="text/css">
    #view_text_22_277327905_txt ul{ padding-left:20px;}
</style>
<div id='view_text_22_277327905_txt'   style="cursor:default; height:100%; width:100%;"  >
    <div class="editableContent " style="line-height:1.5;">
        <p style="line-height: 2em;">
        <span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);">联系电话：<?=g("cmobile")?></span></p>
        <p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);">联系地址：<?=g("address")?></span></p><p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);">E-mail:<?=g("uemail")?></span></p><p style="line-height: 2em;">
        <p style="line-height: 2em;"><span style="font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 14px; color: rgb(0, 0, 0);">投诉电话：<?=g("tousu")?></span></p>
        <p><br/></p>
    </div>
</div>
</div>
</div>
<!-- <div  id="view_barcode_23_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden barcode_Style1_Item0' style='height:120px;width:120px;'>        <img src="/theme/m1/static/images/cc7e8fa382024692835ceae5a235bb4c.gif" style='height: 100%;width: 100%;' />
</div>
</div> -->
<!-- <div  id="view_image_24_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden image_Style1_Item0' style='height:39px;width:78px;'>    <div class="megwh" style="height:100%; width:100%;">
        <a id="autosize_view_image_24_277327905" href="javascript:void(0)" target="_self" >
            <img  src="/theme/m1/static/images/2000002422.png"  alt="" style="border:none; position:relative;" />
        </a>
    </div>
</div>
</div> -->

<?php 
$goods = ProductList(4, '600x450');
?>
<div  id="view_listproducts_40_277327905" class="yibuSmartViewMargin absPos"   >
<div class='yibuFrameContent overflow_hidden listproducts_Style2_Item0 view_listproducts_40_277327905_Style2_Item0' style='height:502px;width:608px;'>    <div class="w-product">
        <ul class="w-product-list clearfix">
            <?php foreach ($goods as $k => $v): ?>
                <li class="w-pl-unit">
                    <a href="/product/<?=$v['id']?>.html" target="_blank">
                        <div class="w-pl-pic"><img src="<?=$v['cover']?>" /></div>
                        <p class="w-pl-price">¥ <?=$v['price']?></p>
                        <h5 class="w-pl-title"><?=$v['name']?></h5>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
</div>
</div>
</div>
</div>

            </div>
        </div>
    </div>
    

       