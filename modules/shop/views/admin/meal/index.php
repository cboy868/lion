<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\JqueryFormAsset;

/* @var $this yii\web\View */
/* @var $searchModel shop\models\GodosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


JqueryFormAsset::register($this);
$this->title = '菜品列表';
$this->params['breadcrumbs'][] = $this->title;


?>
<style type="text/css">
    li.list-group-item {
    margin-bottom: 0;
    border: 0 none;
    padding: 5px 5px;
    font-size: 20px;
    border-bottom: 1px solid #ccc;
}
    .nav-list>li>a.cate-plus{
        position: absolute;
        top: 0px;
        right: 0px;
    }
    .nav-list li.active>a.cate-plus:after {
        content: none;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- <div class="page-header">
            <h1>
                <small>
                <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div> --><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>


            <div class="col-xs-2">
              <div class="panel panel-default" style="border-radius:0px;">
                <ul class="nav nav-list">
                <?php foreach ($cates as $k => $cate): ?>
                    <?php $active = Yii::$app->getRequest()->get('FoodsSearch')['category_id'] == $cate->id ? 'active' : '' ?>
                    <li class="<?=$active?>">
                        <a href="<?=Url::toRoute(['index', 'Meal[category_id]'=>$cate->id])?>"><?=$cate->name?></a>
                        <a href="<?=Url::toRoute(['create', 'category_id'=>$cate->id])?>" class="btn btn-info btn-xs cate-plus"><i class="fa fa-plus"></i>增加</a>
                    </li>
                <?php endforeach ?>
                 
                </ul>
                  
                </div>  
            </div>

            <div class="col-xs-10 foods-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'rowOptions' =>function($data){return $data->is_recommend>0 ? ['class'=>'success'] :[];},
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '主图',
                'value' => function($data){
                    if (!$data->attach) {
                        return ;
                    }
                    return $data->attach->getImg('36x36');
                },
                'format' => 'image',
                'headerOptions' => ['width'=>'40'],
                'contentOptions'=> ['class'=>'cover']
            ],
            'name',
            'category.name',

            'price',
            [
                'label' => '图片',
                'value' => function($data){

                    $html = <<<HTML
<form enctype="multipart/form-data" method="post" action="%s" class="cover-form form-inline pull-right" style="margin-right:10px;">
<input type="hidden" value="%s" name="_csrf" />
<input type="hidden" name="id" value="$data->id">
<div class="form-group " style="margin:0px;">
<input type="file" class="form-control input-sm up-cover" name="thumb" value="" style="">
</div>
</form>
HTML;
                    $html = sprintf($html, Url::toRoute(['cover']), Yii::$app->getRequest()->getCsrfToken());
                    return $html;
                },
                'format' => 'raw',
                'contentOptions' => function($data){
                    return ['class'=>'cover' . $data->id];
                },
                'headerOptions' => ['width'=>'40'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view} {edit} {recommend} {un-recommend} {method}',
                'buttons' => [
                    'recommend' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-thumbs-up" style="color:green">推荐</span>', $url, ['title' => '推荐', 'class'=>'recommend'] );
                    },
                    'un-recommend' => function($url, $model, $key) {
                        return $model->is_recommend>0 ? Html::a('<span class="glyphicon glyphicon-thumbs-down" style="color:red">取消</span>', $url, ['title' => '取消推荐', 'class'=>'recommend'] ):'';
                    },
                    'method' => function($url, $model, $key) {
                        return Html::a('<span class="fa fa-cutlery" style="color:red">烹饪方法</span>', $url, ['title' => '烹饪方法', 'class'=>'method'] );
                    },
                ],
               'headerOptions' => ['width' => '240']
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('recommend') ?>  
      $(function(){
        
        $('.recommend').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            $.get(url,{},function(xhr){
                if(xhr.status) {
                    location.reload();
                } else {
                    alert(xhr.info);
                }
            },'json');
        });

        //上传封面
    $(".up-cover").change(function () {
        var tr = $(this).closest('tr');
        var _this = this;
        <!-- $(_this).closest('div').html('文件正在上传，请稍后'); -->
        $(this).closest('form').ajaxSubmit({
            dataType: 'json',
            success: function (data) {
                if ( data.status ) {
                    tr.find('td.cover').html('<img src="'+data.data.url+'" alt="">'); 
                } else {
                    alert(data.info);
                }
            },
            error: function (data) {
            }
        });
    });

      })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['recommend'], \yii\web\View::POS_END); ?>  

