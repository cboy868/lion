<?php

use app\core\helpers\Html;
use app\core\helpers\Url;

$this->title = '为 【' . $model->real_title . '】 分配权限';
$this->params['breadcrumbs'][] = ['label' => '权限组', 'url' => ['admin/auth-group/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">

            <div class="col-md-12">
                <input type="hidden" class="role_name" value="<?=$model->name?>">
                <?php foreach ($classes as $key => $value):?>
                <div class="panel panel-default box">
                    <div class="panel-heading" style="color:#333">
                        <h4 class="panel-title"><?php echo $key;?>
                            <small>
                            <a href="#" class="btn btn-xs plus pull-right"><i class="fa-lg fa fa-plus-square-o"></i>全选 </a>
                            <a href="#" class="btn btn-xs minus pull-right"><i class="fa-lg fa fa-minus-square-o"></i>全删 </a>
                            </small>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($value as $ke => $val):?>
                            <dl class="col-md-12 col-sm-12 box">
                                <dt style="color:#666;padding-bottom:15px;">
                                <h4><?php echo $ke;?>
                                    <small>
                                    <a href="#" class="plus" style="color:#666"><i class="fa-lg fa fa-plus-square-o"></i>全选</a>
                                    <a href="#" class="minus" style="color:#666"><i class="fa-lg fa fa-minus-square-o"></i>全删</a>
                                    </small>
                                </h4>
                                </dt>
                                <?php foreach ($val as $k => $v):?>
                                    <dd class=" pull-left" style="min-width:300px; color:#888">
                                        <label class=''>
                                            <input name="action" value="<?=$v['name']?>" type="checkbox" <?php if($v['check']) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $k?>
                                            <?php echo $v['title']?> <?=$v['check']?>
                                        </span>
                                        </label>
                                    </dd>
                                <?php endforeach;?>
                            </dl>
                            <hr/>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->



<?php $this->beginBlock('per') ?>  
$(function(){

    var url = "<?=Url::toRoute('toggle-permission');?>";

    $('.minus, .plus').click(function(e){
        e.preventDefault();
        var obj = $(this).closest('.box');
        var permission = [];
        var role_name = $('.role_name').val();
        var check = $(this).hasClass('plus');
        var act = check ? obj.find('.action').not(':checked') : obj.find('.action:checked');

        act.each(function(index, element){
            permission.push($(element).val());
        })
        
        var data = {role_name:role_name,check:check,permission:permission};
        $.post(url, data, function(xhr){
            if (xhr.status) {
                obj.find('.action').each(function(index, element){
                    $(element).prop('checked', check);
                })
            };
        },'json');

    });


    $('.action').click(function(e){
        e.preventDefault();
        var permission = [$(this).val()];
        var check = $(this).is(':checked');
        var role_name = $('.role_name').val();
        var data = {role_name:role_name,check:check,permission:permission};
        var _this = this;
        $.post(url, data, function(xhr){
            if (xhr.status) {
                $(_this).prop('checked',check);
            };
        },'json');
    });
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>  

