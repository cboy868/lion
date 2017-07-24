<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;


\app\assets\ExtAsset::register($this);


$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="page-content">
    <!-- /section:settings.box -->

<!-- Modal -->


    <div class="page-content-area">
        <div class="row">
            <div class="col-md-6">
                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'buttons'])?>


            </div>
            <div class="col-md-6">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideSelfMonth'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'task'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'client'])?>

                <?php //echo \app\modules\grave\widgets\Bench::widget(['name'=>'post', 'mod'=>1, 'limit'=>20])?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

