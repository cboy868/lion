<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\wechat\models\Menu;
use yii\bootstrap\Modal;

$this->title = '微信菜单';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table td input, table td select{
        width:100%;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'],
                        [
                                'class' => 'btn btn-primary btn-sm modalAddButton',
                                'data-loading-text'=>"页面加载中, 请稍后...",
                                'onclick'=>"return false"
                            ]) ?>
                    <?= Html::a('同步微信菜单', ['sync'], ['class'=>'btn btn-danger btn-sm btn-sync']);?>
                </small>
            </h1>
        </div><!-- /.page-header -->
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
            <?php \app\core\widgets\Alert::widget(); ?>
            <div class="col-xs-12 search-box">
                <div class="alert alert-info" style="padding:5px;">
                    一级菜单名称名字不多于4个汉字或8个字母, 最多3个<br>
                    二级菜单名称名字不多于8个汉字或16个字母,最多7个
                </div>
            </div>

            <div class="col-xs-12 merchant-index">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <tbody>
                    <tr>
                        <th></th>
                        <th>菜单名称</th>
                        <th>类别</th>
                        <th>URL/编辑</th>
                        <th width="200">操作</th>
                    </tr>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td width="10"><?=$menu['id']?></td>
                            <td>
                                <input value="<?=$menu['name']?>" />
                            </td>
                            <td>
                                <select name="" id="">
                                    <option value=""><?=$type[$menu['type']]?></option>
                                    <option value="">扫码</option>
                                    <option value="">地图</option>
                                </select>
                            </td>
                            <td>
                                <?php if ($menu['type'] == Menu::TYPE_URL): ?>
                                    <input value="<?=$menu['url']?>" />
                                <?php else: ?>
                                    <a class="btn btn-white btn-minier" href="">
                                        <i class="fa fa-edit"></i>
                                        <span class="blue">编辑响应内容<span></span></span>
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php if (isset($menu['child'])): ?>
                            <?php foreach ($menu['child'] as $v): ?>
                                <tr>
                                    <td width="10"><?=$v['id']?></td>
                                    <td style="padding-left:3em;"><input value="<?=$v['name']?>" /></td>
                                    <td>
                                        <select name="" id="">
                                            <option value=""><?=$type[$v['type']]?></option>
                                            <option value="">扫码</option>
                                            <option value="">地图</option>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if ($v['type'] == Menu::TYPE_URL): ?>
                                            <input value="<?=$v['url']?>" />
                                        <?php else: ?>
                                            <a class="" href="">
                                                <i class="fa fa-edit"></i>
                                                <span class="blue">响应内容<span></span></span>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a href="<?=Url::toRoute(['update', 'id'=>$v['id']])?>" title="编辑" class='modalEditButton' data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                            <span class="glyphicon glyphicon-pencil"></span>编辑
                                        </a>
                                        <a href="<?=Url::toRoute(['delete', 'id'=>$v['id']])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>

                    </tbody>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('tree') ?>  
$(function(){

    $('.btn-sync').click(function(e){
        e.preventDefault();

        var url = $(this).attr('href');

        $.get(url, {}, function(xhr){
            if (xhr.status) {
                location.reload();
            }
        },'json');
    });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>  


