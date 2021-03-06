<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use kartik\popover\PopoverX;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\wechat\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '粉丝管理';
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
    .taguser label{
        margin-right:20px;
    }

</style>

<link rel="stylesheet" href="/css/wechat.css">

<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">

        <?= $this->render('../default/left');?>
        <div class="right-content">

            <div class="page-header">
                <h1>
                    <!--
                <?=  Html::a($this->title, ['index']) ?>
            -->
                    <small>
                        <?=  Html::a('下拉粉丝数据', ['pull'], ['class' => 'btn btn-primary btn-sm']) ?>
                    </small>
                </h1>
            </div><!-- /.page-header -->
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
                    <?=\app\core\widgets\Alert::widget()?>
                </div>
                <div class="col-xs-12">
                    <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>

                <div class="col-xs-10 user-index">
                    <div class="panel panel-info">
                        <div class="panel-heading" style="text-align: right;padding: 5px 10px;">
                            <?php if ($tag):?>
                                <label for="">标签名
                                    <input type="text" name="tagname">
                                </label>
                                <a href="#" class="btn btn-info">删除</a>
                            <?php endif;?>
                            <?php if ($tags):
                                PopoverX::begin([
                                    'header' => '打标签',
                                    'placement' => PopoverX::ALIGN_BOTTOM,
                                    'footer' => Html::button('确定', ['class'=>'btn btn-primary btn-submit-taguser']),
                                    'size' => PopoverX::SIZE_LARGE,
                                    'toggleButton' => ['class'=>'btn btn-primary btn-info', 'label'=>'打标签'],
                                ]);
                                ?>
                                <div class="taguser">
                                    <?php foreach ($tags as $v):?>
                                        <label>
                                            <input type="checkbox" value="<?=$v->tag_id?>" name="usertag[]">
                                            <?=$v->name?>
                                        </label>
                                    <?php endforeach;?>
                                </div>
                                <?php
                                PopoverX::end();
                            endif;
                            ?>


                            <?php if ($tags):
                                PopoverX::begin([
                                    'header' => '删除标签',
                                    'placement' => PopoverX::ALIGN_BOTTOM,
                                    'footer' => Html::button('确定', ['class'=>'btn btn-primary btn-submit-taguser']),
                                    'size' => PopoverX::SIZE_LARGE,
                                    'toggleButton' => ['class'=>'btn btn-primary btn-info', 'label'=>'删除标签'],
                                ]);
                                ?>
                                <div class="taguser">
                                    <?php foreach ($tags as $v):?>
                                        <label>
                                            <input type="checkbox" value="<?=$v->tag_id?>" name="usertag[]">
                                            <?=$v->name?>
                                        </label>
                                    <?php endforeach;?>
                                </div>
                                <?php
                                PopoverX::end();
                            endif;
                            ?>












                            <a href="<?=Url::toRoute(['sync-tag'])?>" class="btn btn-info">同步标签</a>
                            <a href="<?=Url::toRoute(['sync-tag-user'])?>" class="btn btn-info">同步粉丝标签</a>
                        </div>
                        <div class="panel-body">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                                // 'filterModel' => $searchModel,
                                'id' => 'grid',
//        'showFooter' => true,  //设置显示最下面的footer
                                'columns' => [
                                    [
                                        'class'=>yii\grid\CheckboxColumn::className(),
                                        'name'=>'id',  //设置每行数据的复选框属性
                                        'headerOptions' => ['width'=>'30', "data-type"=>"html"],
                                        'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                                            '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 5, 'class'=>'deltd'],  //设置删除按钮垮列显示；
                                    ],
                                    [
                                        'label' => '昵称',
                                        'value'=> function($model){
                                            $img = "<img src='%s' width='36' height='36'>";
                                            return sprintf($img, $model->headimgurl) . ' ' . $model->nickname;
                                        },
                                        'format' =>'raw'
                                    ],
                                    [
                                        'label' => '标签',
                                        'value' => function($model) {
                                            $html = '<button class="btn btn-info btn-xs">%s</button> ';

                                            $tags = $model->tags;
                                            $str = '';
                                            if ($tags) {
                                                foreach ($tags as $v) {
                                                    $str .= sprintf($html, $v->name);
                                                }
                                            }

                                            return $str;

                                        },
                                        'format' => 'raw'
                                    ],
                                    // 'remark',
                                    // 'sex',
                                    // 'language',
                                    // 'city',
                                    // 'province',
                                    // 'country',
                                    // 'subscribe',
                                    'subscribe_at:datetime',
//             'created_at:datetime',
                                    // 'realname',
                                    // 'mobile',
                                    // 'birth',
                                    // 'addr:ntext',

                                    ['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
                <div class="col-xs-2">
                    <div class="wechat-tag-list">
                        <dl>
                            <dt class="tag-item">
                                <a href="<?=Url::toRoute(['index'])?>">全部用户（4）</a>
                                <a href="<?=Url::toRoute(['create-tag'])?>" class="pull-right btn btn-default modalAddButton"><i class="fa fa-plus"></i></a>
                            </dt>

                            <?php foreach ($tags as $tag):?>
                                <dd class="fans-group-item <?php if($tagid == $tag->id):?>active<?php endif;?>">
                                    <a href="<?=Url::toRoute(['index', 'tagid'=>$tag->tag_id])?>">
                                        <?=$tag->name?> (<?=$tag->count?>)
                                    </a>
                                </dd>
                            <?php endforeach;?>
                        </dl>
                    </div>
                </div>
            </div><!-- /.row -->

        </div>
    </div>
</div>


<style>
    .wechat-tag-list{width:100%;float:left;border-left:1px solid #e7e7eb;border-bottom:1px solid #e7e7eb;}
    .wechat-tag-list dt{font-weight:400}
    .wechat-tag-list dt a{padding-left:10px;float:left;color: #252424;}
    .wechat-tag-list dd a{padding-left:40px}
    .wechat-tag-list .fans-group-item{line-height:32px;
        clear: both;}
    .wechat-tag-list .fans-group-item a{color:#252424;display:block}
    .wechat-tag-list .fans-group-item.active,.wechat-tag-list .head .navbar-left>li.fans-group-item:hover,.head .wechat-tag-list .navbar-left>li.fans-group-item:hover,.wechat-tag-list .panel-menu .fans-group-item.tag-item:not(.list-group-more):hover,.panel-menu .wechat-tag-list .fans-group-item.tag-item:not(.list-group-more):hover{background-color:#f4f5f9}
</style>

<?php $this->beginBlock('foo') ?>
$(function(){

$('.btn-submit-taguser').click(function(){
    var ids = $('#grid').yiiGridView('getSelectedRows');
    var tags = [];

    $('input[name="usertag[]"]:checked').each(function(){
        tags.push($(this).val());
    });

    if (ids.length<1) {
        alert('请选择要加标签的粉丝');
        return;
    }
    if (tags.length<1) {
        alert('请选择标签');
        return;
    }

    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
    var data = {users:ids,tags:tags,_csrf:csrf};


    $.post('<?=Url::toRoute(['user-tag'])?>',data,function(xhr){
        if (xhr.status) {
            location.reload();
        } else {
            alert(xhr.info);
        }
    },'json');

});

$('.btn-delete').click(function(){
    var ids = $('#grid').yiiGridView('getSelectedRows');

    if (ids.length<1) {
        alert('请先选择要删除的账号');
        return;
    }
    if (!confirm("您确定要删除这些账号吗?,删除后不可恢复")){return false;}

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
