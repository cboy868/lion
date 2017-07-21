<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\FootableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\client\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
FootableAsset::register($this);

$this->title = '客户管理';
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
                    <?php if (Yii::$app->user->can('client/default/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 client-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'id',
            'name',
            'genderText',
            'mobile',
            'from',
            [
                'label' => '接待员',
                'value' => function($model){
                    if (!$model->guide_id) {
                        return '';
                    }
                    return $model->guide->username;
                },
            ],
            [
                'label' => '座机',
                'headerOptions' => ["data-breakpoints"=>"all"],
                'value' => function($model){
                    return $model->telephone;
                },
                'format' => 'raw'
            ],
            [
                'label' => '年龄',
                'headerOptions' => ["data-breakpoints"=>"all"],
                'value' => function($model){
                    return $model->age;
                },
                'format' => 'raw'
            ],
            [
                'label' => '业务员',
                'value' => function($model){
                    if (!$model->agent_id) {
                        return '';
                    }
                    return $model->agent->username;
                },
                'headerOptions' => ["data-breakpoints"=>"all"],
            ],
            [
                'label' => '简述',
                'headerOptions' => ["data-breakpoints"=>"all"],
                'value' => function($model){
                    return $model->note;
                },
                'format' => 'raw'
            ],

            [
                'label' => '地址',
                'headerOptions' => ["data-breakpoints"=>"all"],
                'value' => function($model){
                    $addr = \app\core\models\Area::getText($model->province_id, $model->city_id, $model->zone_id);
                    $re = $addr .' '. $model->address;
                    return $re;
                },
                'format' => 'raw'
            ],
            [
                'label' => '添加人',
                'headerOptions' => ["data-breakpoints"=>"all"],
                'value' => function($model){
                    if (!$model->created_by) {
                        return '';
                    }
                    return $model->op->username;
                },
                'format' => 'raw'
            ],

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}  {recep}',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('client/default/update'),
                    'recep' =>Yii::$app->user->can('client/recep/index'),
                    'delete' =>Yii::$app->user->can('client/default/delete'),
                ],
                'buttons' => [
                    'recep' => function($url, $model, $key) {
                        return Html::a('联系记录', Url::toRoute(['/client/admin/recep/index', 'id'=>$model->id]), ['title' => '查看', 'target'=>'_blank'] );
                    },
                ],
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('foo') ?>  
  $(function(){
    $('.table').footable();
  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  
