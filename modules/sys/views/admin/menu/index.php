<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\bootstrap\Modal;
use app\modules\sys\models\Menu;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */
$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\JqueryFormAsset::register($this);
\app\assets\Tabletree::register($this);
?>
<style>
    table.treetable{
        font-size:1em;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?php if (Yii::$app->user->can('sys/menu/create')):?>
                    <a id="modalButton" href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm new-menu modalAddButton' title="新增菜单" data-loading-text="页面加载中, 请稍后..." onclick="return false">新增菜单</a>
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
            <div class="col-md-12">
                <table class="table table-hover" id="menu-table">
                    <thead>
                        <tr>
                            <th>菜单</th>
                            <th width="120">创建时间</th>
                            <th width="200">菜单类型</th>
                            <th width="60">大图标</th>
                            <th width="120">上传大图标</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $panels = Menu::panels();
                        $panels = \yii\helpers\ArrayHelper::getColumn($panels, 'name');
                        ?>
                        <?php foreach ($menu as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><span class="<?=$v['icon']?> fa-lg"></span> <?=$v['name']?></td>

                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td>
                                <?=Html::dropDownList('panel', $v['panel'], $panels,[
                                        'prompt'=>'选择菜单类型',
                                        'class'=>'form-control sel-menu',
                                        'rid' => $v['id']
                                    ])?>
                            </td>
                            <td class="ico"><img src="<?=$v['ico']?>" width="45" height="45"></td>
                            <td>
                                <form enctype="multipart/form-data" method="post" action="<?=Url::toRoute(['cover'])?>" class="cover-form form-inline">
                                    <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf" />
                                    <input type="hidden" name="id" value="<?=$v['id']?>">
                                    <div class="form-group " style="margin:0px;">
                                        <input type="file" class="form-control input-sm up-cover" name="ico" value="" style="">
                                    </div>
                                </form>
                            </td>
                            <td>
                            <?php if (Yii::$app->user->can('sys/menu/update')):?>
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs modalEditButton', 'title'=>'更新菜单',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]
                                ) ?>
                                <?php endif;?>
                                <?php if (Yii::$app->user->can('sys/menu/delete')):?>
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

<?php $this->beginBlock('auth') ?>  
$(function(){
    $("#menu-table").treetable({ expandable: true,initialState:'expanded' });

    $('.sel-menu').change(function(){
        var panel = $(this).val();
        var menu_id = $(this).attr('rid');
        var url = "<?=Url::toRoute(['set-panel'])?>";
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
        $.post(url,{menu:menu_id,_csrf:csrf,panel:panel},function(xhr){
            if(!xhr.status) {
                alert(xhr.info);
            }
        },'json');
    });

    $(".up-cover").change(function () {
        var tr = $(this).closest('tr');
        var _this = this;
        //$(_this).closest('div').html('文件正在上传，请稍后');
        $(this).closest('form').ajaxSubmit({
            dataType: 'json',
            success: function (data) {
                if ( data.status ) {
                    tr.find('td.ico').html('<img src="'+data.data.url+'" width="45" height="45">');
                } else {
                    alert(data.info);
                }
            },
            error: function (data) {}
        });
    });
}); 
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
