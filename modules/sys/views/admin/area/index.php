<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sys\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '地区库管理';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?php //echo Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 生成js地区库', ['generate-js'], ['class' => 'btn btn-info btn-sm pull-right']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="col-xs-12">
            <?php if(Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success" style="word-break: break-all;word-wrap: break-word;">
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 area-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'level',
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>