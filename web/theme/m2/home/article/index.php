<?php
use yii\helpers\Url;
?>
<div style="height: 40px;">
    <a href="<?=Url::toRoute(['/cms/home/default/index', 'mid'=>4])?>">点这里</a>
    <a href="<?=Url::toRoute(['/cms/home/default/index', 'mid'=>4, 'cid'=>1])?>">点这里带分类</a>
    <a href="<?=Url::toRoute(['/cms/home/default/view', 'mid'=>4, 'id'=>1])?>">点这里 看详细 </a>
</div>
