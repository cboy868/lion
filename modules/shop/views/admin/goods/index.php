<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

use app\assets\FootableAsset;
use app\modules\shop\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\Goods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;

FootableAsset::register($this);
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->

            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  添加商品
</button>

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


<!-- 
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
                </small> -->
            </h1>
        </div><!-- /.page-header -->


        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
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
        'columns' => [
            // 'id',
            [
                // 'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'thumb',
                // 'format'=> 'raw',
                'value' => function($model){
                    return "<img src='".$model->getThumb('36x36')."'>" . $model->name;
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
                'label' => 'intro',
                'value' => function($model){
                    return $model->intro;
                },
                'format' => 'raw'
            ],
            // 'skill:ntext',
            // 'unit',
            'price',
            // 'is_recommend',
            // 'status',
            // 'created_at',
            // 'updated_at',

            [   'headerOptions' => ["data-type"=>"html"],
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',

            ],

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'100'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {view}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('查看', Url::toRoute(['/home/product/view', 'id'=>$model->id]), ['title' => '查看', 'target'=>'_blank'] );
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

   // $('.redcreate').click(function(){
        //var category_id = $('select[name=category_id]').val();
       // location.href="<?=Url::toRoute(['create'])?>category_id=" + category_id;
   // });

  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  

