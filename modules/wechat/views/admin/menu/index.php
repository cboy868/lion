<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\wechat\models\Menu;

$this->title = '微信菜单';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div id="myAlert" class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?php echo Yii::$app->session->getFlash('success')?>
    </div>
<?php endif ?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?= Html::a('同步微信菜单', ['sync'], ['class'=>'btn btn-danger btn-sm btn-sync']);?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 search-box">
                <div class="alert alert-info" style="padding:5px;">
                    一级菜单名称名字不多于4个汉字或8个字母, 最多3个<br>
                    二级菜单名称名字不多于8个汉字或16个字母,最多7个
                </div>
            </div>

            <div class="col-xs-12 merchant-index">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>菜单名称</th>
                        <th>类别</th>
                        <th>URL/编辑</th>
                        <th width="200">操作</th>
                    </tr>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?=$menu['name']?></td>
                            <td>
                                <small><?=$type[$menu['type']]?></small>
                            </td>
                            <td>
                                <?php if ($menu['type'] == Menu::TYPE_URL): ?>
                                    <?=$menu['url']?>
                                <?php else: ?>
                                    <a class="btn btn-white btn-minier" href="">
                                        <i class="fa fa-edit"></i>
                                        <span class="blue">编辑响应内容<span></span></span>
                                    </a>
                                <?php endif ?>
                            </td>
                            <td>
                                <!-- <a class="btn  btn-white" ylw-confirm="true" href="/admin/wxin/delmenu?id=1">
                                    <i class="fa fa-times"></i> 删除
                                </a> -->
                                <a class="btn btn-minier btn-white" ylw-remote-form="true" href="<?=Url::toRoute(['update', 'id'=>$menu['id']])?>">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                        <?php if (isset($menu['child'])): ?>
                            <?php foreach ($menu['child'] as $v): ?>
                                <tr>
                                    <td style="padding-left:3em;"><?=$v['name']?></td>
                                    <td>
                                        <small><?=$type[$v['type']]?></small>
                                    </td>
                                    <td>
                                        <?php if ($v['type'] == Menu::TYPE_URL): ?>
                                            <?=$v['url']?>
                                        <?php else: ?>
                                            <a class="btn btn-white btn-minier" href="">
                                                <i class="fa fa-edit"></i>
                                                <span class="blue">编辑响应内容<span></span></span>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        
                                        <a class="btn btn-minier btn-white" ylw-remote-form="true" href="<?=Url::toRoute(['update', 'id'=>$v['id']])?>">
                                            <i class="fa fa-edit"></i> 编辑
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


