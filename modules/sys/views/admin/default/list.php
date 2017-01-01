<?php

use yii\helpers\Html;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '网站设置列表';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>

                <?=  $this->title ?>
                <small>
                    <?=  Html::a('新增', ['create'], ['class' => 'btn btn-primary btn-xs new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 set-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'sname',
            'sintro',
            'stype',
            'smodule',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>