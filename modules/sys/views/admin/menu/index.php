<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\grid\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */
$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;

Tabletree::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a id="modalButton" href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm new-menu modalAddButton' title="新增菜单">新增菜单</a>
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
            <div class="col-md-12">
                <table class="table table-hover" id="menu-table">
                    <thead>
                        <tr>
                            <th>菜单</th>
                            <th width="120">创建时间</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menu as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><?=$v['name']?></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td> 
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs modalEditButton', 'title'=>'更新菜单']
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

<?php $this->beginBlock('auth') ?>  
$(function(){
    $("#menu-table").treetable({ expandable: false });
}); 
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
