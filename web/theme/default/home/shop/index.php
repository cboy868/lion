<?php
$this->title = "产品展示";
?>
<div class="inside-focus">
    <img src="http://www.hennissy.com/Uploads/201607/5779d52297d22.jpg" alt="">
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置：
            <a href="/">网站首页</a> &gt;
            <a href="<?=url(['/shop/home/default/index'])?>">产品展示</a>
        </span>
    </div>
</div>
<div class="inside-title">
    <h2 class="en">PRODUCT DISPLAY</h2>
    <h2 class="cn">产品展示</h2>
</div>

<?php $cates = productCateTree()?>

<div class="product1">
    <ul>
        <?php foreach ($cates as $cate):?>
        <li class="clearfix">
            <div class="product1-pic">
                <img src="<?=$cate['cover']?>" alt="">
                <div class="product1-pic-hover" style="display: none; opacity: 1;">
                    <div class="text">
                        <?php if (isset($cate['children'])):?>
                            <?php foreach ($cate['children'] as $v):?>
                        <p>
                            <a target="_blank" href="<?=url(['/shop/home/default/index', 'id'=>$v['id']])?>"><?=$v['name']?></a>
                        </p>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="wrap">
                <div class="product1-text">
                    <h2><?=$cate['name']?></h2>
                    <h3><?=$cate['seo_title']?></h3>
                    <p>
                        <?php
                        $content = nl2br($cate['body'])
                        ?>
                        <?=$content?>
                    </p>

                    <a target="_blank" href="<?=url(['/shop/home/default/index', 'id'=>$v['id']])?>" class="see-details">查看详情 &gt;&gt;</a>
                </div>
            </div>
        </li>
        <?php endforeach;?>
    </ul>
</div>