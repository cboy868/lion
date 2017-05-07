<link rel="stylesheet" type="text/css" href="/theme/m1/static/css/product.css">
<div class="main-wrap clearfix" style="*z-index:10;*position:relative;width:100%;margin-left:auto;margin-right:auto;;background-color:">
        <div class="main clearfix page_main" style="width:1000px;">
        	<div class="content yibuLayout_Body" style="min-height:100px;margin-left:auto;margin-right:auto;;background-color:;background-color:" id="yibuLayout_center">
        	    <div  id="view_productinfo_1_277331261" class="mainSamrtView yibuSmartViewMargin"   >
<div class='yibuFrameContent productinfo_ProductStyle3_Item0' style='height:500px;width:100%;border-style:none;'>
<div class="ibody" style="word-break: break-all;">
    <h1><?=$data['name']?></h1>
    <p class="img">
        <?php foreach ($thumbs as $k => $v): ?>
            <img id="img" alt="<?=$v['title']?>" src="<?=$v['url']?>" title="<?=$data['name']?>" />
        <?php endforeach ?>
        
    </p>
    <p class="info">添加时间：2015-11-26 16:49:15</p>
        <div>
            <p style="line-height: 1.75em; text-align: left; text-indent: 2em;">

            <?=$data['intro']?>

            </p>
        </div>
    <p class="last-next">
            <?php if (isset($pre['id'])): ?>
                <a class="last" href='/product/<?=$pre['id']?>'>上一个：<?=$pre['name']?></a>
            <?php endif ?>
            
            <?php if (isset($next['id'])): ?>
                <a class="next" href='/product/<?=$next['id']?>'>下一个：<?=$next['name']?></a>
            <?php endif ?>
            
    </p>
</div>

</div>
</div>

        	</div>
        </div>
    </div>