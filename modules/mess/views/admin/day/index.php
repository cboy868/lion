<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\modules\mess\models\MessMenu;
\app\assets\SelectizeAsset::register($this);
\kartik\select2\ThemeDefaultAsset::register($this);
\kartik\select2\Select2Asset::register($this);

$all = MessMenu::find()->where(['<>', 'status', MessMenu::STATUS_DEL])->all();
$sel = ArrayHelper::map($all, 'id', 'name');
$price = json_encode(ArrayHelper::map($all, 'id', 'default_price'));

\app\assets\ExtAsset::register($this);
$this->title = '每日菜单管理';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .select2-container--krajee .select2-selection{
        -webkit-border-radius:0;
        -moz-border-radius:0;
        border-radius:0;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    菜单日期
                    <input type="text" dt="true" value="<?=$date?>" class="date_sel">
                </small>
            </h1>
        </div><!-- /.page-header -->


        <?php
        Modal::begin([
            'header' => '添加新菜单',
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
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="z-index: 0">
                        <div class="no-border">
                            <?php
                            $tomorrow =date('Y-m-d',strtotime('+1 day'));
                            $next =date('Y-m-d',strtotime('+2 day'));
                            $next2 = date('Y-m-d',strtotime('+3 day'));
                            $current = Yii::$app->request->get('date');
                            ?>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!$current) echo 'active'?>">
                                    <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">今天</a>
                                </li>
                                <li class="<?php if($current==$tomorrow) echo 'active'?>">
                                    <a href="<?=Url::toRoute(['index','date'=>$tomorrow])?>" aria-expanded="true">明天</a>
                                </li>
                                <li class="<?php if($current==$next) echo 'active'?>">
                                    <a href="<?=Url::toRoute(['index','date'=>$next])?>" aria-expanded="true">后天</a>
                                </li>
                                <li class="<?php if($current==$next2) echo 'active'?>">
                                    <a href="<?=Url::toRoute(['index','date'=>$next2])?>" aria-expanded="true">大后天</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12 mess-day-menu-index">
                <?php foreach ($mess as $k=>$v):?>
                <div class="col-xs-6" >
                    <div>
                        <h3 class="header smaller lighter red"><?=$v?></h3>

                        <?php foreach ($types as $key=>$type):?>
                        <table class="table table-bordered table-hover" data-mess_id="<?=$k?>" data-type="<?=$key?>">
                            <caption class="text-left">
                                <strong><?=$type?></strong>
                            </caption>
                            <thead>
                                <tr>
                                    <th style="width:200px;">菜单名称</th>
                                    <th>单价</th>
                                    <th>操作</th>
                                </tr>
                            </thead>

                            <?php
                                if (isset($menus[$k][$key])):
                                    foreach ($menus[$k][$key] as $menu):
                                        if($date >= date('Y-m-d')):
                            ?>
                            <tr rid="<?=$menu->id?>">
                                <td>
                                    <?=Html::dropDownList('MessDayMenu[menu_id]',
                                        $menu->menu_id,
                                        $sel,
                                        [
                                            'class'=>'selmenu form-control',
                                            'prompt'=>'请选择菜品'
                                        ])?>
                                </td>
                                <td class="red">
                                    <input type="text" name="MessDayMenu[real_price]"
                                           class="real_price"
                                           value="<?=$menu->real_price?>">
                                    <span class="note" style="color:green;display: none;">菜单修改成功</span>
                                    <span class="note_price" style="color:green;display: none;">菜价修改成功</span>
                                </td>
                                <td>
                                    <a href="<?=Url::toRoute(['delete', 'id'=>$menu->id])?>"
                                       title="删除" aria-label="删除"
                                       data-confirm="您确定要删除此项吗？"
                                       data-method="post" data-pjax="0">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                                        <?php else:?>
                            <tr>
                                <td><?=$menu->menu->name?></td>
                                <td class="red">¥<?=$menu->real_price?></td>
                            </tr>
                            <?php
                                        endif;
                                    endforeach;
                                endif;
                            ?>

                            <?php if($date >= date('Y-m-d')):?>
                            <tr >
                                <td>
                                    <?=Html::dropDownList('MessDayMenu[menu_id]',
                                        null,
                                        $sel,
                                        [
                                            'class'=>'selmenu form-control',
                                            'prompt'=>'请选择菜品'
                                        ])?>
                                </td>
                                <td class="red">
                                    <input type="text" name="MessDayMenu[real_price]" class="real_price">
                                    <span class="note" style="color:green;display: none;">菜单保存成功</span>
                                    <span class="note_price" style="color:green;display: none;">菜价修改成功</span>
                                </td>
                                <td>
                                    <a href="#"
                                       title="删除" aria-label="删除"
                                       data-confirm="您确定要删除此项吗？"
                                       class="delete"
                                       style="display: none"
                                       data-method="post" data-pjax="0">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php endif;?>

                        </table>

                    <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<div>
<?php $this->beginBlock('img') ?>
$(function(){
    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
    $('.date_sel').change(function(){
        var date = $(this).val();
        location.href="<?=Url::toRoute(['index'])?>?date="+date;
    });

    $('.selmenu').select2();

    $('body').on('change', '.selmenu', function () {
        var price = JSON.parse('<?=$price?>');
        var id = $(this).val();
        var delid = $(this).closest('tr').attr('rid');
        try {
            var price = price[id];
        } catch (err) {
            var price = 0;
        }
        $(this).closest('tr').find('.real_price').val(price);
        var mess_id = $(this).closest('table').data('mess_id');
        var type = $(this).closest('table').data('type');

        var data = {
            mess_id:mess_id,
            type:type,
            menu_id:id,
            real_price:price,
            day_time:"<?=$date?>",
            _csrf:csrf
        };
        if(delid){
            data.delid=delid;
        }
        var selObj = $(this);
        var that = this;
        $.post("<?=Url::toRoute(['add'])?>",data,function (xhr) {
            if (xhr.status) {
                if(!delid){
                    selObj.select2('destroy');
                    var copy =selObj.parents('tr').clone();
                    $(that).parents('table').append(copy);
                    selObj.select2();
                    copy.find('.real_price').val('');
                    copy.find('.selmenu').select2();
                }
                var href = selObj.closest('tr').find('.delete').attr('href');
                selObj.closest('tr').find('.delete')
                    .show()
                    .attr('href','<?=Url::toRoute(['delete'])?>'+'?id='+xhr.data);
                selObj.closest('tr').find('.note').show();
                $(that).closest('tr').attr('rid', xhr.data);
            } else {
                alert(xhr.info);
            }
        },'json');

    });

    $('.real_price').change(function () {
        var price = $(this).val();
        var id = $(this).closest('tr').attr('rid');

        if (!id || !price) {
            return ;
        }
        var that = this;

        $.post("<?=Url::toRoute(['price'])?>",{id:id,price:price,_csrf:csrf},function(xhr){
            if (!xhr.status) {alert(xhr.info)}
            else{$(that).closest('tr').find('.note_price').show();}

        },'json');

    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
