<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\cms\models\Category;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $modinfo->name . '管理';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create','mod'=>Yii::$app->request->get('mod')], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
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
<?php 
$mod = Yii::$app->getRequest()->get('mod');
$category_id = Yii::$app->getRequest()->get('category_id');
 ?>
            <div class="col-xs-2">
                 <ul class="nav nav-list">
                     <?=  Html::a('<i class="fa fa-plus"></i> 添加顶级分类', ['create-cate','mod'=>$mod], ['class' => 'btn btn-primary btn-sm modalAddButton', 'style'=>'width:100%']) ?>
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
                                    <li><a href="<?=Url::toRoute(['create-cate', 'category_id'=>$category_id, 'pid'=>$value['id'], 'mod'=>$mod])?>" class="modalAddButton">添加</a></li>
                                    <?php if (!isset($value['child'])): ?>
                                        <hr>
                                        <li><a href="<?=Url::toRoute(['delete-cate', 'id'=>$value['id'], 'mod'=>$mod, 'category_id'=>$category_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                    <?php endif ?>
                                    <hr>
                                    <li><a href="<?=Url::toRoute(['update-cate', 'category_id'=>$category_id, 'id'=>$value['id'], 'mod'=>$mod])?>" class="modalEditButton">更新</a></li>
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
                                                    <li><a href="<?=Url::toRoute(['create-cate', 'category_id'=>$category_id, 'pid'=>$val['id'], 'mod'=>Yii::$app->getRequest()->get('mod')])?>" class="modalAddButton">添加</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['delete-cate', 'id'=>$val['id'], 'mod'=>$mod, 'category_id'=>$category_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['update-cate', 'category_id'=>$category_id, 'id'=>$val['id'], 'mod'=>$mod])?>" class="modalEditButton">更新</a></li>
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
                                                    <li><a href="<?=Url::toRoute(['create-cate', 'category_id'=>Yii::$app->getRequest()->get('category_id'), 'pid'=>$val['id'], 'mod'=>Yii::$app->getRequest()->get('mod')])?>" class="modalAddButton">添加</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['delete-cate', 'id'=>$val['id'], 'mod'=>$mod, 'category_id'=>$category_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                    <hr>
                                                    <li><a href="<?=Url::toRoute(['update-cate', 'category_id'=>$category_id, 'id'=>$val['id'], 'mod'=>$mod])?>" class="modalEditButton">更新</a></li>
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
                                                <li><a href="<?=Url::toRoute(['create-cate', 'category_id'=>$category_id, 'pid'=>$val['id'], 'mod'=>$mod])?>" class="modalAddButton">添加</a></li>
                                                <hr>
                                                <li><a href="<?=Url::toRoute(['update-cate', 'category_id'=>$category_id, 'id'=>$val['id'], 'mod'=>$mod])?>" class="modalEditButton">更新</a></li>
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
                                                            <li><a href="<?=Url::toRoute(['delete-cate', 'id'=>$last['id'], 'mod'=>$mod, 'category_id'=>$category_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">删除</a></li>
                                                            <hr>
                                                            <li><a href="<?=Url::toRoute(['update-cate', 'category_id'=>$category_id, 'id'=>$last['id'], 'mod'=>$mod])?>" class="modalEditButton">更新</a></li>
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'created_by',
            'author',
            'category_id',
            'title',
            'thumb',
            // 'sort',
            // 'view_all',
            // 'com_all',
            // 'photo_num',
            // 'recommend',
            // 'created_at',
            // 'updated_at',
            // 'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {view}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/album/update', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑'] );
                    },
                    'view' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/album/view', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看'] );
                    },
                    'delete' => function($url, $model, $key) {
                        $url = Url::toRoute(['/admin/cms/album/delete', 'id'=>$model->id, 'mod'=>\Yii::$app->getRequest()->get('mod')]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除','aria-label'=>"删除", 'data-confirm'=>"您确定要删除此项吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    },
                ],
               'headerOptions' => ['width' => '240']
            ]
        ],
    ]); ?>


        <?php 
            $category = Category::find()->asArray()->all();
            $options = [];
            foreach ($category as $k => $v) {
                if (!$v['is_leaf']) {
                    $options[$v['id']]['disabled'] = true;
                }
            }
        ?>
        <div class="row">
            
            <div class="col-md-3 bach-wrap" style="display:none;">
                <?=Html::dropDownList('category_id', null, Category::selTree(), ['class'=>'form-control move', 'options' => $options, 'prompt'=>'选中项移动到'])?>
            </div>
            <div class="col-md-2 bach-wrap" style="display:none;padding:0">
                <button class="delAll btn btn-default" style="width:100%;"> <i class="fa fa-trash"></i> 选中项删除</button>
            </div>
        </div>
        
        
            <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>



<?php $this->beginBlock('cate') ?>  
$(function(){

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
