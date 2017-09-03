<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;

$this->params['current_menu'] = 'news/default/index';

$this->title = '资讯分类列表';
$this->params['breadcrumbs'][] = $this->title;
Tabletree::register($this);

?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?php if (Yii::$app->user->can('news/category/create')):?>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-default btn-sm modalAddButton' title="添加分类" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus fa-2x"></i> 添加分类</a>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('news/default/create')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/news/admin/default/create', 'type'=>'text'])?>" target="_blank">
                            <i class="fa fa-file-text fa-2x"></i>  添加文本资讯</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/news/admin/default/create', 'type'=>'image'])?>" target="_blank">
                            <i class="fa fa-file-image-o fa-2x"></i>  添加图文资讯</a>
                    </div>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/news/admin/default/create', 'type'=>'video'])?>" target="_blank">
                            <i class="fa fa-file-video-o fa-2x"></i>  添加视频资讯</a>
                    </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

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
            <div class="col-md-6">
                <table class="table table-hover" id="menu-table">
                    <thead>
                        <tr>
                            <th>分类</th>
                            <th width="120">创建时间</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cate as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><img src="<?=$v['cover']?>" width="36" height="36"><?=$v['name']?></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td>
                            <?php if (Yii::$app->user->can('news/category/update')):?>
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]
                                ) ?>
                                <?php endif;?>
                                <?php if (Yii::$app->user->can('news/category/delete')):?>
                                <?= Html::a('删除', ['delete', 'id' => $v['id']], [
                                        'class' => 'btn btn-danger btn-xs delete',
                                        'data' => [
                                            'confirm' => '确定要删除此菜单吗?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                            <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('tree') ?>  
$(function(){

    $("#menu-table").treetable({ expandable: true });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>  

