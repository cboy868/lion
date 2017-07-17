<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Portrait;
use yii\bootstrap\Modal;


\app\assets\ExtAsset::register($this);
\app\assets\FootableAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '瓷像管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 portrait-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [   'headerOptions' => ["data-type"=>"html"],
                'label' => '初始照片',
                'value' => function($model){
                    $img = '<img src="%s" />';
                    return sprintf($img, $model->getOriginalImg('50x50'));
                },
                'format' => 'raw'
            ],
            [   'headerOptions' => ["data-type"=>"html", 'width'=>'100px'],
                'label' => 'PS照片',
                'value' => function($model){
                    $url = Url::toRoute(['pl-upload']);
                    $html = <<<HTML
<a href="javascript:;" 
    class=" filelist-{$model->id} filePicker thumbnail" 
    id="filePicker-{$model->id}" 
    rid="{$model->id}"
    data-res_name="portrait"
    data-use="ps"
    data-url="{$url}"
    >
 <img src="{$model->getProcessedImg('50x50')}" class="img-rounded "> 
</a>
HTML;

                    return $html;
                },
                'format' => 'raw'
            ],
            'tomb.tomb_no',
            'title',
            
            // [
            //     'label' => '商品',
            //     'value' => function($model){
            //         return $model->sku->getName();
            //     }
            // ],
            [
                'label' => '使用人',
                'value' => function($model) {
                    $dead = $model->getDeads();
                    return implode(ArrayHelper::getColumn($dead, 'dead_name'),',');
                }
            ],

            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '导购',
                'value' => function($model){
                    return $model->guide->username;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '账号',
                'value' => function($model){
                    return $model->user->username;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'PS图',
                'value' => function($model){
                    return $model->photo_processed;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '确认图',
                'value' => function($model){
                    return $model->photo_confirm;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '备注',
                'value' => function($model){
                    return $model->note;
                },
                'format' => 'ntext'
            ],

            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => '瓷像状态',
                'value' => function($model){
                    return '<span class="status-text">' . $model->statusText . '</span>';
                },
                'format' => 'raw',
                'options' => ['class'=>'abc']
            ],
            'use_at:date',
            'statusText',

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {view} {complete}',
                'buttons' => [
                    'complete' => function($url, $model, $key) {
                        return $model->status == Portrait::STATUS_MAKE ? Html::a('完成', $url, ['title' => '完成', 'class'=>'cmp btn btn-default btn-sm'] ) : '';
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton'] );
                    }

                ],
            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('table') ?>  
  $(function(){
    $('.table').footable();
    $('.cmp').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var that = this;
        $.post(url, {}, function(xhr){
            if (xhr.status) {
                $(that).closest('tr').find('.status-text').text('完成');
                $(that).remove();
            }
        },'json');
    });
  })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['table'], \yii\web\View::POS_END); ?>  