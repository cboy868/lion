<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '墓位列表';
$grave_id = Yii::$app->request->get('grave_id');
$this->params['breadcrumbs'][] = ['label' => '墓区管理', 'url' => ['/grave/admin/default/index', 'id'=>$grave_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= $this->title ?>
                <small>
<?php if (Yii::$app->user->can('grave/tomb/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增墓位', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
<?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?=\app\core\widgets\Alert::widget() ?>

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => 'modal-lg'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '业务操作',
            'id' => 'modalAdd',
            'size' => Modal::SIZE_LARGE,
            'footer' => '<button class="btn btn-info" data-dismiss="modal">取消</button>',
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
<?php
$sta = \Yii::$app->request->get('status');

?>
            <div class="col-xs-12 tomb-index">
                <div class="widget-box transparent ui-sortable-handle" >
                    <?php $status = \app\modules\grave\models\Tomb::getSta(); ?>
                    <div class="widget-header" style="z-index: 0">
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <li class="<?php if ($sta == null): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['index', 'grave_id'=>$grave_id])?>" aria-expanded="true">全部</a>
                                </li>
                                <?php foreach ($status as $k => $v): ?>
                                    <li class="<?php if ($sta == $k): ?>active<?php endif ?>">
                                        <a href="<?=Url::toRoute(['index', 'grave_id'=>$grave_id,'status'=>$k])?>" aria-expanded="true"><?=$v?></a>
                                    </li>
                                <?php endforeach ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    'id' => 'grid',
                    'showFooter' => true,  //设置显示最下面的footer
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class'=>yii\grid\CheckboxColumn::className(),
                            'name'=>'id',  //设置每行数据的复选框属性
                            'headerOptions' => ['width'=>'30'],
                            'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                                '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                            'footerOptions' => ['colspan' => 14, 'class'=>'deltd'],  //设置删除按钮垮列显示；
                        ],
                        'id',
                        [
                            'label' => '墓位号',
                            'value' => function($model){
                                $img = '<img src="'.$model->getCover('36x36', '/static/images/default.png').'">';
                                return '<a href="'.Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->id]).'" target="_blank">'.
                                        $img . $model->tomb_no.'</a>' ;
                            },
                            'format' => 'raw'

                        ],
                        [
                            'label' => '墓区',
                            'value' => function($model) {
                                return '<a href="'.Url::toRoute(['/grave/admin/default/index', 'id'=>$model->grave_id]).'" target="_blank">'.
                                    $model->grave->name.'</a>';
                            },
                            'format' => 'raw'
                        ],
                        'hole',
                         'price',
                         'user.username',
                         'customer.name',
                        ['label'=>'客户',  'attribute' => 'customer_name',  'value' => 'customer.name' ],//<=====加入这句
                         'agent.username',
//                         'agency_id',
                         'guide.username',
                        // 'sale_time',
                         'mnt_by',
                        [
                            'label' => '销售状态',
                            'value' => function($model){
                                if ($model->user_id) {
                                    return $model->statusText . '('.$model->user->username.')';
                                }
                                return $model->getStatusText();
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'操作',

                            'template' => '
{view} / {option}
<div class="btn-group">
  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    更多 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li>{update}</li>
    <li>{delete}</li>
    <li role="separator" class="divider"></li>
  </ul>
</div>',
                            'visibleButtons' =>[
                                'update' =>Yii::$app->user->can('grave/tomb/update'),
                                'view' =>Yii::$app->user->can('grave/tomb/view'),
                                'delete' =>Yii::$app->user->can('grave/tomb/delete'),
                                'option' =>Yii::$app->user->can('grave/tomb/option'),
                            ],
                            'buttons' => [
                                'view' => function($url, $model, $key){
                                    return Html::a('墓位明细',$url,['target'=>'_blank']);
                                },
                                'option' => function($url, $model, $key){
                                    return Html::a('办理业务',$url,[
                                        'class'=>"modalAddButton btn btn-default btn-xs",
                                        'data-loading-text'=>"等待...",
                                        'onclick'=>"return false"
                                    ]);
                                },
                                'update' => function($url, $model, $key) {
                                    return Html::a('编辑', $url, [
                                        'title' => '编辑',
                                        'class'=>'modalEditButton',
                                        "data-loading-text"=>"页面加载中, 请稍后...",
                                        "onclick"=>"return false"]);
                                },
                                'delete' => function($url, $model, $key) {
                                    return Html::a('删除', $url, [
                                        'title'=>"删除",
                                        'aria-label'=>"删除",
                                        'data-pjax'=>"0",
                                        'data-confirm'=>"您确定要删除此项吗？",
                                        'data-method'=>"post"
                                    ]);
                                }
                            ],
                            'headerOptions' => ['width' => '200',"data-type"=>"html"]
                        ]
                    ],
                ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>
    $(function(){
    $('td.deltd').siblings('td').remove();
        $('.btn-delete').click(function(){
            if (!confirm("您确定要删除这些墓位?,删除后不可恢复")){return false;}
            var ids = $('#grid').yiiGridView('getSelectedRows');
            var url = "<?=Url::toRoute(['batch-del'])?>";

            $.post(url, {ids:ids},function(xhr){
                if (xhr.status){
                    location.reload();
                } else {
                    alert(xhr.info);
                }
            },'json');

        });

        $('td.deltd').siblings('td').remove();

    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>