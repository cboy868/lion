<?php

use app\core\helpers\Html;
use app\core\helpers\Url;

$this->title = '权限管理 在此页面添加名修改权限项注释';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .nopad{padding-left: 0}
    .panel-default>.panel-heading{
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-color: #ddd;
    }

</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a data-loading-text="数据更新中, 请稍后..." href="<?=Url::toRoute('sync')?>" class="btn btn-danger auth-sync">权限初始化</a>
                </small>

                <?= $this->render('@app/modules/sys/views/admin/layout/_nav.php') ?>
            </h1>

        </div><!-- /.page-header -->
        <div class="row">

            <div class="col-md-12">
                <?php foreach ($classes as $key => $value):?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <?=$key;?>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($value as $ke => $val):?>
                            <dl class="col-md-12 col-sm-12 nopad">
                                <dt><?php echo $ke;?> </dt>
                                <?php foreach ($val as $k => $v):?>
                                    <dd class="col-md-3 nopad">
                                        <span class="lbl ">
                                            <?php echo $k?>
                                            <input value="<?= $v['title']?>" class="action_des input-small form-control" key="<?=$v['name']?>" />
                                        </span>
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


    $('.auth-sync').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');

        $.get($(this).attr('href'),null,function(xhr){
            if (xhr.status) {
                location.reload();
            };
            btn.button('reset');
        },'json');
    });

    $('.action_des').change(function(e){
        e.preventDefault();
        var url = "<?=Url::toRoute('title')?>";
        var csrf = $('meta[name=csrf-token]').attr('content');
        var data = {name:$(this).attr('key'), title:$(this).val(), _csrf:csrf};
        $.post(url, data, function(xhr){
            if (!xhr.status) {
                alert(xhr.info);
            };
        },'json');
    });
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
























