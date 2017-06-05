<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use app\modules\wechat\models\MenuMain;
use kartik\popover\PopoverX;
use app\core\widgets\ActiveForm;
$this->title = '微信菜单管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="/css/wechat.css">

<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">

        <?= $this->render('../default/left');?>
        <div class="right-content">

            <div class="page-header">
                <h1>
                    <?=Html::encode($this->title)?>
                    <small>
                        请先创建普通菜单，再创建个性菜单
                    </small>

                    <div class="pull-right nc">
                        <?php
                        PopoverX::begin([
                            'header' => '添加菜单组',
                            'placement' => PopoverX::ALIGN_BOTTOM_RIGHT,
                            'footer' => Html::button('确定', [
                                'class'=>'btn btn-primary',
                                'onclick'=>'$("#normal").trigger("submit")'
                            ]),
                            'size' => PopoverX::SIZE_LARGE,
                            'toggleButton' => ['class'=>'btn btn-sm btn-info',
                                'label'=>'<i class="fa fa-list-ol fa-2x"></i> 添加普通菜单组'],
                        ]);
                        ?>
                        <?php $form = ActiveForm::begin(); ?>
                        <?php $form->options['id'] = 'normal' ?>
                        <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'?>
                        <?= $form->field($model, 'type')->hiddenInput(['value'=>MenuMain::TYPE_NORMAL])->label(false); ?>
                        <?= $form->field($model, 'name')->textInput(); ?>
                        <?php ActiveForm::end(); ?>
                        <?php
                        PopoverX::end();
                        ?>
                    </div>

                    <div class="pull-right nc">
                        <?php
                        PopoverX::begin([
                            'header' => '添加菜单组',
                            'placement' => PopoverX::ALIGN_BOTTOM_RIGHT,
                            'footer' => Html::button('确定', [
                                'class'=>'btn btn-primary btn-submit-taguser',
                                'onclick'=>'$("#personal").trigger("submit")'
                            ]),
                            'size' => PopoverX::SIZE_LARGE,
                            'toggleButton' => ['class'=>'btn btn-danger btn-sm',
                                'label'=>'<i class="fa fa-list-ol fa-2x"></i> 添加个性化菜单组'],
                        ]);
                        ?>
                        <?php $form = ActiveForm::begin(); ?>
                        <?php $form->options['id'] = 'personal' ?>
                        <?php $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'?>
                        <?= $form->field($model, 'type')->hiddenInput(['value'=>MenuMain::TYPE_PERSONAL])->label(false); ?>
                        <?= $form->field($model, 'name')->textInput(); ?>

                        <p class="text text-danger" style="text-align: center;">注意:以下限制至少需要选择一项</p>
                        <div class="form-group field-userform-username required">
                            <label class="control-label col-sm-2" for="userform-username">地区</label>
                            <div class="col-sm-10">
                                <?php echo \app\core\widgets\Area\Select::widget(['zone_show'=>false]);?>
                            </div>
                        </div>
                        <?= $form->field($model, 'language')->dropDownList(MenuMain::languages()) ?>

                        <?= $form->field($model, 'gender')->dropDownList(MenuMain::genders()) ?>

                        <?= $form->field($model, 'client_platform_type')->dropDownList(MenuMain::platform()) ?>
                        <?php ActiveForm::end(); ?>
                        <?php
                        PopoverX::end();
                        ?>
                    </div>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>

                <div class="col-xs-12 menu-main-index">
                    <div class="widget-box transparent ui-sortable-handle">
                        <div class="widget-header" style="border:none;">
                            <div class="no-border">
                                <ul class="nav nav-tabs">
                                    <li class="<?php if($type == MenuMain::TYPE_NORMAL):?>active<?php endif;?>">
                                        <a href="<?=Url::toRoute(['/wechat/admin/menu/index', 'type'=>MenuMain::TYPE_NORMAL])?>" aria-expanded="true">普通菜单</a>
                                    </li>
                                    <li class="<?php if($type == MenuMain::TYPE_PERSONAL):?>active<?php endif;?>">
                                        <a href="<?=Url::toRoute(['/wechat/admin/menu/index', 'type'=>MenuMain::TYPE_PERSONAL])?>" aria-expanded="true">个性菜单</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            'id',
                            'name',
                            'type',
                            'is_active',
//                        'gender',
                            // 'tag',
                            // 'client_platform_type',
                            // 'language',
                            // 'country',
                            // 'province',
                            // 'city',
                            'created_at:datetime',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=>'操作',
                                'template' => '{delete} {info}',
                                'buttons' => [
                                    'info' => function($url, $model, $key) {
                                        return Html::a('管理', $url, ['title' => '进入公众号'] );
                                    }

                                ],
                                'headerOptions' => ['width' => '240',"data-type"=>"html"]
                            ]
                        ],
                    ]); ?>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>
</div>
