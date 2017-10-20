<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


$this->title = '分类列表';
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
                    <?php if (Yii::$app->user->can('shop/category/create')):?>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton'
                       data-loading-text="页面加载中, 请稍后..." onclick="return false" title="添加分类">
                        <i class="fa fa-plus"></i>添加分类</a>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/type/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/type/index'])?>">
                            <i class="fa fa-cubes fa-2x"></i>  商品类型管理</a>
                    </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/goods/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/goods/index'])?>">
                            <i class="fa fa-shopping-basket fa-2x"></i>  商品管理</a>
                    </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/bag/index')):?>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/bag/index'])?>">
                            <i class="fa fa-shopping-bag fa-2x"></i>  打包品管理</a>
                    </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php 
            Modal::begin([
                'header' => '添加',
                'id' => 'modalAdd',
                // 'size' => 'modal'
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
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
            <div class="col-md-12">
                <table class="table table-hover" id="menu-table">
                    <thead>
                        <tr>
                            <th>分类名</th>
                            <th>封面</th>
                            <th width="120">创建时间</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cate as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><?=$v['name']?></td>
                            <td><img src="<?=$v['cover']?>" width="36" height="36"></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td>
                                <?php if (Yii::$app->user->can('shop/goods/update')):?>
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false" ]
                                ) ?>
                                <?php endif;?>
                                <?php if (Yii::$app->user->can('shop/goods/delete')):?>
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

                            <?php if (isset($v['children'])): ?>
                                <?php foreach ($v['children'] as $v2): ?>
                                    <tr data-tt-id=<?=$v2['id']?> data-tt-parent-id=<?=$v2['pid']?>>
                                        <td><?=$v2['name']?></td>
                                        <td><img src="<?=$v2['cover']?>" width="36" height="36"></td>
                                        <td><?=date('Y/m/d',$v2['created_at'])?></td>
                                        <td>
                                    <?php if (Yii::$app->user->can('shop/goods/update')):?>
                                            <?= Html::a('编辑', ['update', 'id' => $v2['id']],
                                                ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false" ]
                                            ) ?>
                                    <?php endif;?>
                                    <?php if (Yii::$app->user->can('shop/goods/delete')):?>
                                            <?= Html::a('删除', ['delete', 'id' => $v2['id']], [
                                                    'class' => 'btn btn-danger btn-xs delete',
                                                    'data' => [
                                                        'confirm' => '确定要删除此菜单吗?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                        <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php if (isset($v2['children'])): ?>
                                        <?php foreach ($v2['children'] as $v3): ?>
                                          <tr data-tt-id=<?=$v3['id']?> data-tt-parent-id=<?=$v3['pid']?>>
                                                <td><?=$v3['name']?></td>
                                                <td><img src="<?=$v3['cover']?>" width="36" height="36"></td>
                                                <td><?=date('Y/m/d',$v3['created_at'])?></td>
                                                <td>
                                            <?php if (Yii::$app->user->can('shop/goods/update')):?>
                                                    <?= Html::a('编辑', ['update', 'id' => $v3['id']],
                                                        ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false" ]
                                                    ) ?>
                                                <?php endif;?>
                                            <?php if (Yii::$app->user->can('shop/goods/delete')):?>
                                                    <?= Html::a('删除', ['delete', 'id' => $v3['id']], [
                                                            'class' => 'btn btn-danger btn-xs delete',
                                                            'data' => [
                                                                'confirm' => '确定要删除此菜单吗?',
                                                                'method' => 'post',
                                                            ],
                                                        ]) ?>
                                                <?php endif;?>
                                                </td>
                                            </tr>  
                                        <?php endforeach ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
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

