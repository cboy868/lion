<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    修改详细信息
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 goods-update">
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
                        <div class="goods-form">
                            <?php $form = ActiveForm::begin()?>
                            <div class="tab-content">
                                <?php $i=1; foreach ($lg_models as $k=>$lg_model):?>
                                    <div role="tabpanel" class="tab-pane <?php if($i==1):?>active<?php endif;?>" id="<?=$k?>">
                                        <?= $this->render('_lgform', [
                                            'model' => $model,
                                            'lg_model' => $lg_model,
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
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
