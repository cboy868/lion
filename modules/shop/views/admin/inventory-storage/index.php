<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\shop\models\InventoryStorage;

$this->title = '仓库列表';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增库房', ['create'], ['class' => 'btn btn-primary btn-sm modalAddButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]) ?>
                    <?= Html::a('初始化', '#', ['class'=>
                        'btn btn-sm btn-danger pull-right',
                        'data-toggle'=>"modal",
                        'data-target'=>"#myModal"
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">选择仓库</h4>
                    </div>

                    <form id="w0" action="<?=Url::toRoute(['sync'])?>" method="get">

                        <?php
                        $storages = InventoryStorage::find()->where(['status'=>InventoryStorage::STATUS_NORMAL])->all();
                        $s = \yii\helpers\ArrayHelper::map($storages, 'id', 'name');
                        ?>

                        <div class="modal-body">
                            <p style="color:green;">
                                1、本功能会把所有已添加的商品中数量不为0的商品同步到所选仓库 <br>
                                2、本功能会删除原有仓库中已有商品，请慎用。<br>
                                3、建议只在第一次使用系统时使用
                            </p>

                            <?=Html::dropDownList('storage', null, $s, ['class'=>'form-control'])?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary redcreate">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

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

            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget();?>
            </div>

            <?php if (isset($relDataProvider)):?>
            <div class="col-xs-4 inventory-storage-index">
            <?php else:?>
            <div class="col-xs-12 inventory-storage-index">
            <?php endif;?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'columns' => [
            [
                'label' => '仓库',
                'value' => function($model) {
                    return $model->name . '('.$model->pos.')';
                }
            ],
            [
                'label' => '管理员',
                'value' => function($model) {
                    return $model->op_name . '('.$model->mobile.')';
                }
            ],
            // 'thumb',
            // 'created_at',
            // 'status',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {index}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑','class'=>"modalEditButton", 'data-loading-text'=>"页面加载中, 请稍后...", 'onclick'=>"return false"] );
                    },
                    'index' => function($url, $model, $key) {
                        return Html::a('库存商品', $url, ['title' => '库存商品'] );
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            '#',
                            [
                                'title' => '删除库',
                                'data-toggle'=>"modal",
                                'data-target'=>"#delModal",
                                'data-id'=> $model->id
                            ]);
                    }
                ],
               'headerOptions' => ['width' => '240',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <?php if (isset($relDataProvider)):?>
            <div class="col-xs-8">
                <?= GridView::widget([
                    'dataProvider' => $relDataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        'storage.name',
                        [
                            'label' => '商品',
                            'value' => function($model){
                                return $model->sku->getFullName();
                            }
                        ],
                        'total',
                        'note:ntext',
                    ],
                ]); ?>
            </div>
            <?php endif;?>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->

        <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">此库删除后，库中商品需转移到其它仓库，请选择</h4>
                    </div>

                    <form id="w0" action="<?=Url::toRoute(['delete'])?>" method="post">
                        <?php
                        $storages = InventoryStorage::find()->where(['status'=>InventoryStorage::STATUS_NORMAL])->all();
                        $s = \yii\helpers\ArrayHelper::map($storages, 'id', 'name');
                        ?>

                        <div class="modal-body">
                            <?=Html::dropDownList('storage', null, $s,
                                ['class'=>'form-control selDel', 'prompt'=>'选择仓库'])?>
                        </div>
                        <input type="text" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                        <input type="text" name="id" class="oid">
                        <input type="text" name="current_id" value="<?=Yii::$app->request->get('id')?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary redcreate">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

<?php $this->beginBlock('cate') ?>
$(function () {
    $('#delModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);//
        var id = button.data('id');
        var modal = $(this)
        modal.find(".selDel option:selected").attr('selected',false);
        modal.find(".selDel option").show();
        modal.find(".selDel option[value='"+id+"']").hide();
        modal.find('.oid').val(id);
    })
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>
