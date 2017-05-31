<?php

use app\core\helpers\Html;
use app\core\helpers\Url;


$this->title = '快捷按扭选择';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .btn img{
        width:48px;
        height: 48px;
    }
    .widget-main .btn-default{
        border-radius: 10px;
        margin: 5px;
        width: 78px;
    }
    .widget-box a.unsel{
        background: #64a6bc;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-md-12">
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
<!--                    <div class="widget-header">-->
<!--                        <h4 class="widget-title lighter">待选按扭</h4>-->
<!--                    </div>-->
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <?php foreach ($buttons as $v):?>
                                <?php if($v['is_leaf'] == 0) continue;?>
                            <a href="" class="btn btn-default <?php
                            if(array_search($v['auth_name'], $sels) !== false)
                            {echo'unsel';}else{echo "sel";}?>"
                               rel="<?=$v['auth_name']?>"
                               ico="<?=$v['ico']?>" rname="<?=$v['name']?>">
                                <img src="<?=$v['ico']?>" class="fa-app">
                                <small style="font-size: 10px;"><?=$v['name']?></small>
                            </a>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('auth') ?>
$(function(){
    $('body').on('click', '.sel, .unsel', function(e){
        e.preventDefault();
        var auth = $(this).attr('rel');
        var action = $(this).hasClass('sel') ? 'sel':'unsel';
        var csrf="<?=Yii::$app->getRequest()->getCsrfToken()?>";
        var ico = $(this).attr('ico');
        var panel = "<?=$panel?>";
        var name = $(this).attr('rname');
        var url = "<?=Url::toRoute(['sel-button'])?>";
        var that = this;
        $.post(url,{action:action,auth:auth,_csrf:csrf,ico:ico,panel:panel,name:name},function(xhr){
            if (xhr.status) {
                if (action == 'sel') {
                    $(that).removeClass('sel').addClass('unsel');
                } else {
                    $(that).removeClass('unsel').addClass('sel');
                }

            }
        });

    });
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>


