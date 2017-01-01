<?php

use app\core\helpers\Html;
use app\core\helpers\Url;

$this->title = '为 【' . $model->description . '】 分配权限';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['role']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a href="<?=Url::toRoute('index')?>" class="btn btn-primary">权限项管理</a>
                </small>
            </h1>

        </div><!-- /.page-header -->
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">

            <div class="col-md-12">
                <input type="hidden" class="role_name" value="<?=$model->name?>">
                <?php foreach ($classes as $key => $value):?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?php echo $key;?></h4>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($value as $ke => $val):?>
                            <dl class="col-md-12 col-sm-12">
                                <dt><?php echo $ke;?> </dt>
                                <?php foreach ($val as $k => $v):?>
                                    <dd class=" pull-left" style="min-width:300px;">
                                        <label class=''>
                                            <input name="action" value="<?=$v['name']?>" type="checkbox" <?php if($v['check']) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $k?>
                                            <?php echo $v['title']?>
                                            <!--
                                            <input value="<?php echo $v['description']?>" class="action_des input-small" />
                                            暂时隐藏起来
                                            -->
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


<?php $this->beginBlock('auth') ?>  
$(function(){
    var url = "<?=Url::toRoute('toggle-auth');?>";
    $('.action').click(function(e){
        e.preventDefault();
        var auth_name = $(this).val();
        var check = $(this).is(':checked');
        var role_name = $('.role_name').val();
        var data = {role_name:role_name,check:check,auth_name:auth_name};
        var _this = this;
        $.post(url, data, function(xhr){
            if (xhr.status) {
                $(_this).prop('checked',check);
            };
        },'json');
    });
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  