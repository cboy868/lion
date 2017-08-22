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
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'remote', 'model'=>$memorial])?>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-box search-outline">
                            <?php  echo $this->render('_search_remote', ['model' => $searchModel]); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 remote-index">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                            // 'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'label' => '馆名',
                                    'value' => function($model){
                                        $url = Url::toRoute(['/memorial/home/hall/index', 'id'=>$model->memorial_id]);

                                        return Html::a($model->memorial->title, $url, ['target'=>"_blank"]);
                                    },
                                    'format' => 'raw'
                                ],
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
                                'user.username',
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
                                    'template' => '{remote-video}',
                                    'headerOptions' => ['width' => '140',"data-type"=>"html"],
                                    'buttons' => [
                                        'remote-video' => function($url, $model, $key) use($memorial){
                                            $url = Url::toRoute(['remote-video', 'id'=>$memorial->id, 'remote_id'=>$model->id]);
                                            return Html::a('查看视频',$url,['target'=>'_blank']);
                                        }
                                    ],
                                ]
                            ],
                        ]); ?>
                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.col -->
                </div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>