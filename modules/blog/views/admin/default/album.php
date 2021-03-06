<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '相册';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 album-index">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'label' => '封面',
                            'value' => function($model){
                                return '<img src="'.$model->getThumbImg('45x45').'">'.$model->title;
                            },
                            'format' => 'raw'
                        ],
                        'num',
                        'body:ntext',
                        // 'sort',
                        // 'recommend',
//                         'is_customer',
                        // 'is_top',
                        // 'memorial_id',
                         'privacyText',
                        // 'view_all',
                        // 'com_all',
                        // 'created_by',
                        // 'ip',
                         'created_at:datetime',
                        // 'updated_at',
                        // 'status',
                    ],
                ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>