<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

app\assets\EchartsAsset::register($this);

?>

<?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearPercent'])?>
<?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearCompare'])?>
<?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideSelfMonth'])?>
<?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthPercent'])?>
<?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthCompare'])?>