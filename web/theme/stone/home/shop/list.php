<?php
$this->title = $cate['name'] . '产品展示';
?>
<!-- 内容区 -->
<div class="inside-focus">
    <img src="<?=$cate['cover']?>" alt="" style="max-height:500px"/>
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b><span>当前位置：
            <a href="/">网站首页</a> &gt;
            <a href="<?=url(['/shop/home/default/index'])?>">产品展示</a> &gt;
            <a href="<?=url(['/shop/home/default/index', 'cid'=>$cate['id']])?>"><?=$cate['name']?></a>
        </span>
    </div>
</div>
<div class="inside-title">
    <h2 class="en">PRODUCT DISPLAY</h2>
    <h2 class="cn">产品展示</h2>
</div>
<div class="product2">
    <div class="product2-toggle">
        <div class="product2-body wrap">
            <ul class="clearfix">
                <?php foreach ($list as $v):?>
                <li>
                    <a target="_blank" href="<?=url(['/shop/home/default/view','id'=>$v['id']])?>">
                        <img src="<?=$v['cover']?>" alt="<?=$v['name']?>" />
                        <div class="product2-hover">
                            <div class="text">
                                <p><?=$v['name']?></p>
                            </div>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>