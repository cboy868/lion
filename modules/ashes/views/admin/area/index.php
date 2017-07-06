<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = '架区管理';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\Tabletree::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?>

                <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加架区"
                   data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加架区</a>

                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/ashes/admin/default/index'])?>">
                        <i class="fa fa-th-large fa-2x"></i>  存盒取盒操作</a>
                </div>
            </h1>
        </div><!-- /.page-header -->
        <?=\app\core\widgets\Alert::widget()?>

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
            <div class="col-md-12">
                <table class="table table-hover" id="areas-table">
                    <thead>
                    <tr>
                        <th>架区名称</th>
                        <th width="120">行数</th>
                        <th width="200">列数</th>
                        <th width="60">备注</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($areas as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><?=$v['title']?></td>

                            <td><?=$v['row']?></td>
                            <td><?=$v['col']?></td>
                            <td><?=$v['intro']?></td>
                            <td>
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs modalEditButton', 'title'=>'更新菜单',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]
                                ) ?>
                                <?= Html::a('删除', ['delete', 'id' => $v['id']], [
                                    'class' => 'btn btn-danger btn-xs delete',
                                    'data' => [
                                        'confirm' => '确定要删除此菜单吗?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
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
<?php $this->beginBlock('areas') ?>

$(function(){
    $("#areas-table").treetable({ expandable: true,initialState:'expanded' });
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['areas'], \yii\web\View::POS_END); ?>
