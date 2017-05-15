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

                <?=\app\modules\grave\widgets\Analysis::widget(['name'=>'tomb'])?>

            </div>
            <div class="col-md-6">
                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'task'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'client'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'post', 'mod'=>5, 'limit'=>20])?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

