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

$this->title = $modinfo->name . '管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .rmenu {
        position: absolute;
        top: 28px;
        right: 0px;
        list-style: none;
        z-index: 100;
        border: 1px solid #ccc;
        padding:0;
        display: none;
        background:#fff;
        /*padding-top: 30px;*/
    }

    .rmenu li{
        height: 30px;
        padding: 0 10px;
        line-height: 30px;
    }

    .rmenu hr{
        height: 1px;
        padding: 0;
        margin: 0;
        border-top: 1px solid #aaa;
    }
    table.table{
        margin-bottom: 5px;
    }
</style>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
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
<?php 
$mod = Yii::$app->getRequest()->get('mod');
$category_id = Yii::$app->getRequest()->get('category_id');
 ?>
            <div class="col-sm-12 col-md-2">
                 <ul class="nav nav-list">
                     <?=  Html::a('<i class="fa fa-plus"></i> 添加顶级分类', ['/cms/admin/category/create','res_name'=>'album'.$mod], ['class' => 'btn btn-primary btn-sm modalAddButton', 'style'=>'width:100%',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]) ?>
                     <li>
                         
                         <a href="<?=Url::toRoute(['index', 'mod'=>$mod, 'category_id'=>0])?>" class="dropdown-toggle">
                            <i class="menu-icon fa fa-circle"></i>
                            <span class="menu-text">默认分类</span>
                        </a>
                     </li>
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?>">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-bars"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                    <b class="arrow fa fa-angle-down rmu"></b>
                                     <!-- <b class="arrow fa fa-plus create"></b>
                                    <b class="arrow fa fa-minus delete" style="right:30px;"></b>
                                    <b class="arrow fa fa-minus delete" style="right:30px;"></b> -->
                                </a>
                                <ul class="rmenu">
                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/create', 'pid'=>$value['id'], 'res_name'=>'album'.$mod])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">添加</a></li>
                                    <?php if (!isset($value['child'])): ?>
                                        <hr>
                                        <li><a href="<?=Url::toRoute(['/cms/admin/category/delete', 'id'=>$value['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                    <?php endif ?>
                                    <hr>
                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/update', 'id'=>$value['id']])?>" class="modalEditButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">更新</a></li>
                                </ul>
                            <b class="arrow"></b>
                            <?php if (!isset($value['child'])) { continue; } ?>
                            <ul class="submenu" style="display:block;">
                                <?php foreach ($value['child'] as $k => $val): ?>
                                    <?php if (!isset($val['child'])): ?>
                                        <?php if (isset($val['url'])): ?>
                                            <li class="<?php if ($val['id'] == $current_cate) { echo 'active'; } ?>" rel="">
                                                <a href="<?=$val['url']?>">
                                                    <i class="menu-icon"></i>
                                                    <?=$val['name']?>
                                                    <b class="arrow fa fa-angle-down rmu"></b>
                                                </a>
                                                <ul class="rmenu">
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/create', 'pid'=>$val['id'], 'res_name'=>'album'.$mod])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">添加</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/create', 'id'=>$val['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/update', 'id'=>$val['id']])?>" class="modalEditButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">更新</a></li>
                                                </ul>
                                                <b class="arrow"></b>
                                            </li>
                                        <?php else: ?>
                                            <li class="<?php if ($val['id'] == $current_cate) { echo 'active'; } ?>" rel="">
                                                <a href="#">
                                                    <i class="menu-icon"></i>
                                                    <?=$val['name']?>
                                                    <b class="arrow fa fa-angle-down rmu"></b>
                                                </a>
                                                <ul class="rmenu">
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/create', 'pid'=>$val['id'], 'mod'=>'album'.$mod])?>" class="modalAddButton">添加</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/delete', 'id'=>$val['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['/cms/admin/category/update', 'id'=>$val['id'], 'res_name'=>'album'.$mod])?>" class="modalEditButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">更新</a></li>
                                                </ul>
                                                <b class="arrow"></b>
                                            </li>
                                        <?php endif ?>
                                        
                                    <?php else: ?>
                                        <li class="p-menu">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow fa fa-angle-down rmu"></b>
                                            </a>
                                            <ul class="rmenu">
                                                <li><a href="<?=Url::toRoute(['/cms/admin/category/create','pid'=>$val['id'], 'res_name'=>'album'.$mod])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">添加</a></li>
                                                <hr>
                                                <li><a href="<?=Url::toRoute(['/cms/admin/category/update', 'id'=>$val['id']])?>" class="modalEditButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">更新</a></li>
                                            </ul>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <li class="<?php if ($last['id'] == $current_cate) {echo 'active';}?>">
                                                        <a href="<?=$last['url'];?>">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                           <?=$last['name']?>
                                                           <b class="arrow fa fa-angle-down rmu"></b>
                                                        </a>
                                                        <ul class="rmenu">
                                                            <li><a href="<?=Url::toRoute(['/cms/admin/category/delete', 'id'=>$last['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                            <hr>
                                                            <li><a href="<?=Url::toRoute(['/cms/admin/category/update', 'id'=>$last['id']])?>" class="modalEditButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">更新</a></li>
                                                        </ul>
                                                        <b class="arrow"></b>
                                                    </li>
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
            <div class="col-xs-10 album-index">

            <div class="row">

            <?php foreach ($dataProvider->getModels() as $k => $model): ?>
                <div class="col-sm-4 col-md-3">
                    <div class="thumbnail">
                        <a href="<?=Url::toRoute(['view', 'mod'=>$mod, 'id'=>$model->id])?>" class="artimg">
                            <img src="<?=$model->getImg('380x265')?>" alt="<?=$model->title?>" class="image" style="height:165px;">
                        </a>
                        <div class="caption">
                            <h4><a href="<?=Url::toRoute(['view', 'mod'=>$mod, 'id'=>$model->id])?>"><?=StringHelper::truncate($model->title,20)?></a></h4>

                            <p><a href="<?=Url::toRoute(['delete', 'id'=>$model->id, 'mod'=>$mod])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
                            <a href="<?=Url::toRoute(['update', 'id'=>$model->id, 'mod'=>$mod])?>" class="btn btn-success modalEditButton" role="button"><i class="fa fa-pencil"></i></a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>

              <div class="col-sm-4 col-md-3">
                <div class="thumbnail" style="cursor: pointer;">
                <a href="<?=Url::toRoute(['create', 'mod'=>$mod])?>" class="modalAddButton">
                  <img src="/static/images/plus.png">
                </a>
                </div>
              </div>
            </div>

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

    $('input:checkbox').change(function(){
        var keys = $('#w1').yiiGridView('getSelectedRows');
        if (keys.length>0) {
            $('.bach-wrap').show();
        } else {
            $('.bach-wrap').hide();
        }
    });

    $('.move').change(function(){
        var category_id = $(this).val();
        var keys = $('#w1').yiiGridView('getSelectedRows');
        var mod = "<?=$mod?>";
        var csrf = $('meta[name=csrf-token]').attr('content');

        $.post("<?=Url::toRoute(['move', 'mod'=>$mod])?>", {category_id:category_id,ids:keys, _csrf:csrf},function(xhr){
            if (xhr.status) {
                location.reload();
            }
        },'json');
    });

    $('.delAll').click(function(){
        var keys = $('#w1').yiiGridView('getSelectedRows');
        var mod = "<?=$mod?>";
        var csrf = $('meta[name=csrf-token]').attr('content');

        $.post("<?=Url::toRoute(['drop', 'mod'=>$mod])?>", {ids:keys, _csrf:csrf},function(xhr){
            if (xhr.status) {
                location.reload();
            }
        },'json');
    });


    $('.rmu').mouseover(function(){
        $('.rmenu').hide()
        $(this).closest('li').children('.rmenu').show();
    });
    $('.rmenu').mouseleave(function(){
        $(this).hide();
    });


})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
