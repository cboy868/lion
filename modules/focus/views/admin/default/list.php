<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\core\helpers\StringHelper;


use yii\widgets\LinkPager;

\app\assets\ColorBoxAsset::register($this);

$this->params['current_menu'] = 'focus/default/index';

$this->title = '焦点图图片管理【' . $category->title .'】';
$this->params['breadcrumbs'][] = ['label' => '列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . '拖拽排列显示顺序';
?>


<style type="text/css">
    .thumbnail>a.img{
        height: 120px;
        display: inline-block;
        overflow: hidden;
    }
    .thumbnail.active{
        border:3px solid #8ce;
        background-color: #cde;
    }
    .thumbnail{
        border: 3px solid #ccc;
    }
    ol, ul {
        list-style: none;
        padding: 0;
    }
</style>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

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
            
            <div class="col-xs-10 album-index">


            <ul class="row" id="sortable">
                <div class="col-sm-3 col-md-3">
                    <div class="thumbnail" style="cursor: pointer;">
                    <a href="<?=Url::toRoute(['create', 'category_id'=>$category->id])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                      <img src="/static/images/plus.png">
                    </a>
                    </div>
                  </div>
            <?php foreach ($dataProvider->getModels() as $k => $model): ?>
                 <li class="col-sm-3 col-md-3 ui-state-default" rel="<?=$model->id?>">
                    <div class="thumbnail <?php if($category->thumb == $model->image):?>active<?php endif;?>">
                        <a href="<?=$model->image?>" class="img artimg">
                            <img src="<?=$model->image?>" alt="<?=$model->title?>" class="image">
                        </a>
                        <div class="caption">
                            <p><a href="#" title="<?=$model->intro?>"><?=StringHelper::truncate($model->title,20)?></a></p>
                            <p><a href="<?=Url::toRoute(['delete', 'id'=>$model->id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
                            <a href="<?=Url::toRoute(['update', 'id'=>$model->id])?>" class="btn btn-success modalEditButton" role="button" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-pencil"></i></a>
                            <a href="<?=Url::toRoute(['cover', 'category_id'=>$model->category_id, 'focus_id'=>$model->id])?>" class="btn btn-success cover"><i class="fa fa-flag"></i>封面</a>

                            </p>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>

              
            </ul>

            <?php 
                echo LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]);
             ?>

            <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>  
$(function(){

    $(".image").click(function(e) {
         e.preventDefault();
         var title = $(this).attr('title');
         $(".artimg").colorbox({
             rel: 'artimg',
             maxWidth:'600px',
             maxHeight:'700px',
             next:'',
             previous:'',
             close:'',
             current:""
         });
     });

    $( "#sortable" ).sortable({
        update:function(event, ui){
            var ids = [];
            $('#sortable li').each(function(index){
                var id = $(this).attr('rel');
                ids.push(id);
            });

            var uri = "<?=Url::toRoute(['sort', 'id'=>$category->id])?>";
            var _csrf = $('meta[name=csrf-token]').attr('content');
            $.post(uri, {ids:ids, _csrf:_csrf},function(xhr){
                if (xhr.status) {
                    //location.reload();
                }
            },'json');

        }
    });

    $('.cover').click(function(e){
        e.preventDefault();
        var that = this;

        var url = $(this).attr('href');
        var _csrf = $('meta[name=csrf-token]').attr('content');
        $.post(url, {}, function(xhr){
            if (xhr.status) {
                $('.thumbnail').removeClass('active');
                $(that).closest('.thumbnail').addClass('active');
            }
        }, 'json');
    });

    
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
