<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '消费记录';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= $this->title ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 mess-user-order-menu-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        'mess.name',
                        'menu.name',
                        'day_time',
                        'real_price',
                        'num',
                        'type',
                        [
                            'label' => '类别',
                            'value' => function($model) use($types){
                                return $types[$model->type];
                            }
                        ],
                        [
                            'label' => '是否已使用',
                            'value' => function($model){
                                return $model->is_over ? '已使用' : '预定状态';
                            }
                        ],
                    ],
                ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>