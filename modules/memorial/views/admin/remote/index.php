<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '远程祭祀记录';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\PluploadAssets::register($this);
\app\assets\PluploadVideoAssets::register($this);
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

        <?php
        Modal::begin([
            'header' => '编辑视频地址',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>
        <style>
            .preview{
                clear: both;
            }
        </style>

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
//                    $name = $model->goods->name == $model->sku->name ?
//                        $model->goods->name : $model->goods->name . $model->sku->name;

                    if (!$model->sku) {
                        return '';
                    }
                    $url = Url::toRoute(['/shop/admin/goods/view', 'id'=>$model->goods->id]);

                    return Html::a($model->sku->getName(), $url, ['target'=>'_blank']);
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
                    $str ='';

                    $str .= Html::a('上传视频', '#', [
                            'id' => 'filePicker-' . $model->id . 'a',
                            'class' => ' filelist-thumb videoPicker btn btn-info btn-xs',
                            'rid' => $model->id,
                            'data-url'=>Url::toRoute('video-upload'),
                            'data-res_name'=>"memorial",
                            'data-use'=>"thumb"
                        ]) . Html::tag('b', '',['class'=>'percent'.$model->id]) . ' ';


                    $str .= '<span class="preview'.$model->id.'">';
                    if ($model->video) {
                        $str .= Html::a('预览视频',Url::toRoute('/'.$model->video), ['target'=>'_blank']) . ' ';
                    }
                    $str .= '</span>';

                    return $str;

                },
                'format' => 'raw'
            ],
            [
                'label' => '视频封面',
                'value' => function($model){
                    $img = Html::img($model->getThumbImg('45x45'), [
                            'class'=>'img-rounded',
                            'style' => 'max-width:40px;max-height:40px;'
                        ]);
                    return Html::a($img, '#', [
                        'id' => 'filePicker-' . $model->id,
                        'class' => 'thumbnail filelist-thumb filePicker',
                        'rid' => $model->id,
                        'data-url'=>Url::toRoute('pl-upload'),
                        'data-res_name'=>"memorial",
                        'data-use'=>"thumb"
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
                'template' => '{update} {delete} {finish}',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('memorial/remote/update'),
                    'delete' =>Yii::$app->user->can('memorial/remote/delete'),
                    'finish' =>Yii::$app->user->can('memorial/remote/delete'),
                ],
                'buttons' => [
                    'finish' => function($url, $model, $key){
                        if ($model->status == \app\modules\memorial\models\Remote::STATUS_PAY) {
                            return Html::a('<font color="green"> 完成</font>', $url, ['title' => '完成'] );
                        }
                    },
                ],
                'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>