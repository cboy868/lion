<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel cms\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '模块管理';
$this->params['breadcrumbs'][] = $this->title;
Tabletree::register($this);

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加分类" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加分类</a>
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
                <table class="table table-hover table-borded" id="menu-table">
                    <thead>
                        <tr>
                            <th>模块名</th>
                            <th>模型id</th>
                            <th width="120">创建时间</th>
                            <th width="220"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cate as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><img src="<?=$v['cover']?>" width="36" height="36"> <?=$v['name']?></td>
                            <td><?=$v['res_name']?></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td> 
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]
                                ) ?> 
                                <?= Html::a('删除', ['delete', 'id' => $v['id']], [
                                        'class' => 'btn btn-danger btn-xs delete',
                                        'data' => [
                                            'confirm' => '确定要删除此菜单吗?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                <?= Html::a('分类管理', ['cate', 'pid' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs  modalEditButton', 'title'=>'更新',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]
                                ) ?>
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

    //$("#menu-table").treetable({ expandable: true });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>  

