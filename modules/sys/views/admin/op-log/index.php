<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\libs\Ip\IpLocation;

$this->title = '系统操作日志';
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

            <div class="col-xs-12 op-log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '操作人',
                'value' => function($model) {
                    if ($model->user_id) {
                        return $model->user->username;
                    }
                    return '';
                }
            ],
            'table_name',
            'ac',
            'route',
            'description:ntext',
            'ip',
            [
                'label' => 'IP地址',
                'value' => function($model) {
                    $ip = new IpLocation();
                    $ipresult = $ip->getlocation($model->ip);

                    if (!$ipresult) {
                        return $model->ip;
                    } else {
                        return $model->ip . $ipresult['country']. $ipresult['area'];
                    }
                }
            ],
            'created_at:datetime',
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>