<?php 

use yii\widgets\LinkPager;
 ?>
<link rel="stylesheet" type="text/css" href="/theme/m1/static/css/18282a6d914c423b874b74481b8269cd.css">
    <div class="main-wrap clearfix" style="*z-index:10;*position:relative;width:100%;margin-left:auto;margin-right:auto;;background-color:">
        <div class="main clearfix page_main" style="width:1000px;">
        	<div class="content yibuLayout_Body" style="min-height:100px;margin-left:auto;margin-right:auto;;background-color:;background-color:" id="yibuLayout_center">
        	    <div id="view_main_1_37675" class="mainSamrtView yibuSmartViewMargin">
<div class="yibuFrameContent main__Item0" style="height:1099px;width:100%;"><div class="runTimeflowsmartView"><div id="view_listproducts_11_37675" class="yibuSmartViewMargin absPos" oldbottom="897">
<div class="yibuFrameContent overflow_hidden listproducts_Style2_Item0 view_listproducts_11_37675_Style2_Item0" style="width:1030px;">    <div class="w-product">
        <ul class="w-product-list clearfix" id="ulList_view_listproducts_11_37675">
            <?php foreach ($list as $k => $v): ?>
                <li class="w-pl-unit">
                    <a href="/product/<?=$v['id']?>.html" target="_blank">
                        <div class="w-pl-pic"><img src="<?=$v['cover']?>"></div>
                        <p class="w-pl-price">¥ <?=$v['price']?></p>
                        <h5 class="w-pl-title"><?=$v['name']?></h5>
                        <!-- <p class="w-pl-info">
                        </p> -->
                    </a>
                </li>
            <?php endforeach ?>
        </ul>

        <div style="clear:both;"></div>
    </div>
<div class="w_pager f_clearfix" id="pager_view_listproducts_11_37675"><div class="w-pageline" style="float: none">

<?php 

echo LinkPager::widget([
    'pagination' => $pagination,
]);
 ?>



</div></div><script type="text/javascript">$(function(){PcListPagination("view_listproducts_11_37675","productList","PageNumber","6","2","-1","","0","CreatedOnUtc","DESC","off","","","False","False","view_listproducts_11_37675_callback")});</script>        <script type="text/template" id="listTemplate_view_listproducts_11_37675">
            <li class="w-pl-unit">
                <a href="$data.Url" target="_blank">
                    <div class="w-pl-pic"><img src="$data.ImageUrl" /></div>
                    <p class="w-pl-price">¥ $data.PriceStr</p>
                    <h5 class="w-pl-title">$data.Title</h5>
                    <p class="w-pl-info">$data.Description</p>
                    <p class="w-pl-btn">立即购买</p>
                </a>
            </li>
        </script>
</div>
</div>
<div id="view_category_12_37675" class="yibuSmartViewMargin absPos" style="z-index: 99999;" oldbottom="59">
<div class="yibuFrameContent overflow_hidden category_Style2_Item0 view_category_12_37675_Style2_Item0" style="height: 40px; width: 1000px; overflow: visible;">
<?php 
$cates = ProductCateList(4, '52x44');

 ?>
<ul class="w_category_first" styleitem="Style2">

        <?php foreach ($cates as $k => $v): ?>
            <li class="w_category_first_item for_search" style="width:25%;*width:24.5%" id="view_category_12_37675_w_category_first_item" data-cid="1090752">

                <h3 class="w_category_first_title" style="width:100%;">
                    <a href="/products/<?=$v['id']?>.html">
                            <i class="iconfont right_icon"></i>
                        <?=$v['name']?>
                    </a>
                </h3>
                <!--/w_category_second-->
            </li>
        <?php endforeach ?>
</ul>
<!--/w_category_first-->
<!--/w_category-->

<script type="text/javascript">
    $(function () {
        //处理边框导致的二级菜单位置错误变化
        var borderWith =0;
        if($("#view_category_12_37675_w_category_first_item").parent().length>0){
            borderWith  = ($("#view_category_12_37675_w_category_first_item").parent().css("borderBottomWidth")).toString().split("p")[0];
        }

        $("#view_category_12_37675 .w_category_seconds").css("left", 0 - borderWith);
        $("#view_category_12_37675 .w_category_third").css("top", 0 - borderWith);

        //处理超出设计边框位置的二级菜单不能显示的问题
        $("#" + 'view_category_12_37675').children("div").eq(0).css("overflow", "visible");

        $('#view_category_12_37675 .w_category_first_item').hover(function () {
            $(this).children(".w_category_first_title").toggleClass("first_hover");
        });

        $('#view_category_12_37675 .w_category_second_item').hover(function () {
            $(this).children(".w_category_second_title").toggleClass("second_hover");

        });
        $('#view_category_12_37675 .w_category_third_item').hover(function () {
            $(this).children(".w_category_third_title").toggleClass("third_hover");

        });

        //因分割线与边框重叠 删除各级li里面最后一个item的分割线
        $("#view_category_12_37675 .w_category_first_title:last").children().css("border-right", "none");

        $("#view_category_12_37675 .w_category_second_title:last").children().css("border-bottom", "none");

        $("#view_category_12_37675 .w_category_second_item").each(function(){

            $(this).find(".w_category_third .w_category_third_item:last a").css("border-bottom", "none");
        });
        if ("False" == "False") {
            jQuery("#" + 'view_category_12_37675').css("z-index", "99999");
        }

        SetCategorySelectedStyle('view_category_12_37675');
    });


    view_category_12_37675.ShowResultPageList =  function (entityName,categoryId,categoryName,firstCategoryId,firstCategoryName,secondCategoryId,secondCategoryName) 
                    {
        if ("False".toLocaleLowerCase() != "true") {
            if ("True".toLocaleLowerCase() == "true") {
                if("True".toLocaleLowerCase()=="true"){
                    window.location.href = "/NewCategoryResultlist?EntityTypeName=" + entityName 
                        +"&categoryId=" + categoryId+"&categoryName=" + categoryName
                        +"&firstCategoryName=" + firstCategoryName+"&firstCategoryId="+firstCategoryId
                        +"&secondCategoryName=" + secondCategoryName+"&secondCategoryId="+secondCategoryId;                }else{
                    window.location.href = "/CategoryResultlist?EntityTypeName=" + entityName +"&categoryId=" + categoryId+"&categoryName=" + categoryName;
                }
                } else {
                if ("True".toLocaleLowerCase() != "true") {
                    //老版本当前页显示
                    TurnPageCategoryListSmartView("37675", "", "False", "1", "", "", entityName, categoryId);
                }
                else {
                    //新版本（精简）
                    TurnNewPageSmartView("37675", "", "False", "","false",categoryId,categoryName);
                }
                SetCategorySelectedById('view_category_12_37675', categoryId);
            }
        }
    }
</script>
</div>
</div>
</div></div>
</div>

        	</div>
        </div>
    </div>
    