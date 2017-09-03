<?php

use app\core\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\cms\models\Post;
$this->params['current_menu'] = 'cms/post/index';

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $module->title, 'url' => ['index', 'mid'=>$module->id]];
$this->params['breadcrumbs'][] = '修改';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    多语言编辑
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 news-update">

                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="widget-toolbar" style="z-index: 2">
                            <button class="btn btn-xs btn-light">
                                智能翻译
                            </button>
                        </div>
                        <div class="no-border">

                            <ul class="nav nav-tabs" role="tablist">
                                <?php $i=1; foreach ($languages as $k=>$v):?>
                                    <li role="presentation" class="<?php if($i==1):?>active<?php endif;?>">
                                        <a href="#<?=$k?>" aria-controls="<?=$k?>" role="tab" data-toggle="tab"><?=$v?></a>
                                    </li>
                                    <?php $i++; endforeach;?>
                            </ul>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="news-form">
                            <?php $form = ActiveForm::begin()?>
                            <?php $tpl = '_lg'.Post::types($model->type).'_form';?>
                            <div class="tab-content">
                                <?php $i=1; foreach ($lg_models as $k=>$v):?>
                                    <div role="tabpanel" class="tab-pane <?php if($i==1):?>active<?php endif;?>" id="<?=$k?>">
                                        <?= $this->render($tpl, [
                                            'model' => $model,
                                            'lg_model' => $v,
                                            'form' =>$form
                                        ]) ?>
                                    </div>
                                    <?php $i++; endforeach;?>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block btn-ajax']) ?>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <?php ActiveForm::end(); ?>
                            <div class="hr hr-18 dotted hr-double"></div>

                        </div>
                    </div>
                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php if(isset($i18n) && $i18n):?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">操作选择</h4>
            </div>
            <div class="modal-body">
                <a href="<?=Url::toRoute(['update', 'id'=>Yii::$app->request->get('id')])?>" class="btn btn-info">编辑其它语言</a>
                <a href="<?=Url::toRoute(['create'])?>" class="btn btn-info">继续添加</a>
                <a href="<?=Url::toRoute(['index'])?>" class="btn btn-info">返回列表页</a>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('cate') ?>
$(function(){
    $('#myModal').modal();
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>
<?php endif;?>