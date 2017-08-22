<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;

$this->title = '远程祭祀记录';
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

            <div class="col-xs-12 remote-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '墓位',
                'value' => function($model) {
                    $url = Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->tomb_id]);
                    return Html::a($model->tomb->tomb_no, $url, ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            [
                'label' => '所购商品',
                'value' => function($model) {
                    $name = $model->goods->name == $model->sku->name ?
                        $model->goods->name : $model->goods->name . $model->sku->name;

                    $url = Url::toRoute(['/shop/admin/goods/view', 'id'=>$model->goods->id]);

                    return Html::a($name, $url, ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            'order_rel_id',
            'start',
            'end',
            [
                'label' => '视频地址',
                'value' => function($model){
                    return $model->video;

                },
                'format' => 'url'
            ],
            [
                'label' => '视频封面',
                'value' => function($model){
                    $img = Html::img($model->getThumbImg('45x45'), [
                            'class'=>'img-rounded',
                            'style' => 'max-width:40px;max-height:40px;'
                        ]);
                    return Html::a($img, '#', [
                        'class' => 'thumbnail',
                    ]);
                },
                'format' => 'raw'
            ],
            'note:ntext',
            // 'price',
            // 'status',
             'created_at:dateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{view}',
                'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>