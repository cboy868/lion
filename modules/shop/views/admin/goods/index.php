<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

use app\assets\FootableAsset;
use app\modules\shop\models\Category;


$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;

FootableAsset::register($this);
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
<?php if (Yii::$app->user->can('shop/goods/create')):?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i> 新增
            </button>
<?php endif;?>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">选择分类</h4>
                  </div>


                    <form id="w0" action="<?=Url::toRoute(['create'])?>" method="get">

                    <?php
                    $category = Category::find()->asArray()->all();
                    $options = [];
                    foreach ($category as $k => $v) {
                        if (!$v['is_leaf']) {
                            $options[$v['id']]['disabled'] = true;
                        }
                    }
                     ?>

                  <div class="modal-body">
                    <?=Html::dropDownList('category_id', null, Category::selTree(), ['class'=>'form-control', 'options' => $options])?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary redcreate">OK</button>
                  </div>
                    </form>
                </div>
              </div>
            </div>


            <small>
                <?php if (Yii::$app->user->can('shop/bag/index')):?>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/bag/index'])?>">
                        <i class="fa fa-shopping-bag fa-2x"></i>  打包品管理</a>
                </div>
                <?php endif;?>
                <?php if (Yii::$app->user->can('shop/category/index')):?>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/category/index'])?>">
                        <i class="fa fa-sitemap fa-2x"></i>  商品分类管理</a>
                </div>
                <?php endif;?>
            </small>
            </h1>
        </div><!-- /.page-header -->

        <?=\app\core\widgets\Alert::widget()?>

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

        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>


        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

<?php 
$category_id = Yii::$app->getRequest()->get('category_id');
?>
            <div class="col-xs-2">
                 <ul class="nav nav-list">
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?>">
                                

                            <?php if (!isset($value['child'])): ?>
                                <a href="<?=$value['url']?>" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-bars"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                    <b class="arrow fa <?php if (isset($value['child'])) { echo "fa-angle-down"; } ?>"></b>
                                </a>
                                <b class="arrow"></b>
                            <?php continue; else: ?>
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-bars"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                    <b class="arrow fa <?php if (isset($value['child'])) { echo "fa-angle-down"; } ?>"></b>
                                </a>
                                <b class="arrow"></b>
                            <?php endif ?>

                            <?php if (!isset($value['child'])) { continue; } ?>
                            <ul class="submenu" style="display:block;">
                                <?php foreach ($value['child'] as $k => $val): ?>
                                    <?php if (!isset($val['child'])): ?>
                                        <li class="<?php if ($val['id'] == $current_cate) { echo 'active'; } ?>" rel="">
                                            <a href="<?=$val['url']?>">
                                                <i class="menu-icon"></i>
                                                <?=$val['name']?>
                                                <b class="arrow fa fa-angle-down "></b>
                                            </a>
                                            <b class="arrow"></b>
                                        </li>
                                    <?php else: ?>
                                        <li class="p-menu">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow fa fa-angle-down rmu"></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $se):?>
                                                    <?php if (!isset($se['child'])): ?>
                                                        <li class="<?php if ($se['id'] == $current_cate) { echo 'active'; } ?>" rel="">
                                                            <a href="<?=$se['url']?>">
                                                                <i class="menu-icon"></i>
                                                                <?=$se['name']?>
                                                                <b class="arrow fa fa-angle-down "></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="p-menu">
                                                            <a href="#" class="dropdown-toggle">
                                                                <i class="menu-icon fa fa-caret-right"></i>
                                                                <?=$se['name']?>
                                                                <b class="arrow fa fa-angle-down rmu"></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                            <ul class="submenu" style="display:block;">
                                                                <?php foreach ($se['child'] as $last): ?>
                                                                    <li class="<?php if ($last['id'] == $current_cate) { echo 'active'; } ?>" rel="">
                                                                        <a href="<?=$last['url']?>">
                                                                            <i class="menu-icon"></i>
                                                                            <?=$last['name']?>
                                                                            <b class="arrow fa"></b>
                                                                        </a>
                                                                        <b class="arrow"></b>
                                                                    </li>
                                                                <?php endforeach ?>
                                                            </ul>
                                                        </li>

                                                    <?php endif ?>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                </ul><!-- /.nav-list -->
            </div>
            <div class="col-xs-10 goods-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'id' => 'grid',
        'showFooter' => true,  //设置显示最下面的footer
        'columns' => [
            // 'id',
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30', "data-type"=>"html"],
                'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 6, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            [
                // 'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '产品',
                'headerOptions' => ["data-type"=>"html",'width'=>''],
                // 'format'=> 'raw',
                'value' => function($model){
                    $recommend = $model->recommend ? '<font color="#f00">(推荐商品)</font>' : '';
                    return "<img src='".$model->getThumb('36x36')."'> " . $model->name . $recommend;
                },
                'format' => 'raw'
            ],
            // 'name',
            'category.name',
            'serial',
            // 'thumb',
            // 'intro:ntext',
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '商品介绍',
                'value' => function($model){
                    return $model->intro;
                },
                'format' => 'raw'
            ],
             'skill:ntext',
             'unit',
            'price',
//            [
//                'label' => '是否推荐',
//                'value' => function($model){
//                    return $model->recommend ? '是': '否';
//                }
//            ],
            // 'status',
             'created_at:datetime',
            // 'updated_at',

            // [   'headerOptions' => ["data-type"=>"html"],
            //     'class' => 'yii\grid\ActionColumn',
            //     'header' => '操作',

            // ],

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',

                'template' => '
<div class="btn-group">
  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    更多 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">{default}</a></li>
    <li><a href="#">{recommend}</a></li>
    <li><a href="#">{update-lg}</a></li>
    <li role="separator" class="divider"></li>
  </ul>
</div>
{update} {delete} {view}
',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('shop/goods/update-cate'),
                    'recommend' =>Yii::$app->user->can('shop/goods/recommend'),
                    'update-lg' =>Yii::$app->user->can('shop/goods/update-lg'),
                    'delete' =>Yii::$app->user->can('shop/goods/delete'),
                    'view' =>Yii::$app->user->can('shop/goods/view'),
                ],
                'buttons' => [
                    'default' => function($url, $model, $key) {
                        return Html::a('前台查看', Url::toRoute(['/shop/home/default/view', 'id'=>$model->id]), ['title' => '查看', 'target'=>'_blank'] );
                    },
                    'recommend' => function($url, $model, $key) {
                        $name = $model->recommend ? '取消推荐' : '推荐';

                        return Html::a($name, Url::toRoute(['recommend', 'id'=>$model->id]),
                            ['title' => $name, 'target'=>'_blank', 'class'=>'recommend'] );
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('修改', Url::toRoute(['/shop/admin/goods/update-cate', 'id'=>$model->id]), ['title' => '修改', 'class'=>'modalEditButton'] );
                    },

                    'update-lg' => function($url, $model, $key) use($i18n_flag) {
                        if($i18n_flag) {
                            return Html::a('编辑多语言', $url, ['title' => '编辑多语言'] );
                        }
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

<?php if($i18n):?>
    <div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">操作选择</h4>
                </div>
                <div class="modal-body">
                    <?php if (isset($model)): ?>
                    <a href="<?=Url::toRoute(['update-lg', 'id'=>$model->id])?>" class="btn btn-info">编辑多语言</a>
                    <a href="<?=Url::toRoute(['create', 'category_id'=>$model->category_id])?>" class="btn btn-info">继续添加</a>
                    <?php endif;?>
                    <a href="<?=Url::toRoute(['index'])?>" class="btn btn-info">不做任何操作</a>
                </div>
            </div>
        </div>
    </div>
    <?php $this->beginBlock('i18n') ?>
    $(function(){
    $('#msgModal').modal();
    })
    <?php
    $this->endBlock();
    $this->registerJs($this->blocks['i18n'], \yii\web\View::POS_END);
endif;
?>

<?php $this->beginBlock('foo') ?>  
  $(function(){
$('td.deltd').siblings('td').remove();
    $('.table').footable();



    $('body').on('click', '.recommend', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url,function(xhr){
            if (!xhr.status){
                alert(xhr.info);
            } else {
                location.reload();
            }

        },'json');
    });

   // $('.redcreate').click(function(){
        //var category_id = $('select[name=category_id]').val();
       // location.href="<?=Url::toRoute(['create'])?>category_id=" + category_id;
   // });


$('.btn-delete').click(function(){
    var ids = $('#grid').yiiGridView('getSelectedRows');

    if (ids.length<1) {
        alert('请先选择要删除的商品');
        return;
    }
    if (!confirm("您确定要删除这些商品吗?,删除后不可恢复")){return false;}

    var url = "<?=Url::toRoute(['batch-del'])?>";

    $.post(url, {ids:ids},function(xhr){
        if (xhr.status){
            location.reload();
        } else {
            alert(xhr.info);
        }
    },'json');

});

  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  

