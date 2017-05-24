<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\wechat\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '粉丝管理';
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
                    <?=  Html::a('下拉粉丝数据', ['pull'], ['class' => 'btn btn-primary btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 user-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '头像',
                'value'=> function($model){
                    $img = "<img src='%s' width='36' height='36'>";
                    return sprintf($img, $model->headimgurl) . ' ' . $model->nickname;
                },
                'format' =>'raw'
            ],
            // 'remark',
            // 'sex',
            // 'language',
            // 'city',
            // 'province',
            // 'country',
            // 'subscribe',
             'subscribe_at:datetime',
//             'created_at:datetime',
            // 'realname',
            // 'mobile',
            // 'birth',
            // 'addr:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>