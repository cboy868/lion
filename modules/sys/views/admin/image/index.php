<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\widgets\ActiveForm;
use app\modules\sys\models\ImageConfig;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sys\models\ImageConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Image Configs';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-xs-12 image-config-index">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">

                <?php $i=1;foreach ($models as $k => $model): ?>
                    <li role="presentation" class="<?php if($i==1){echo 'active';}?>"><a href="#<?=$k?>" role="tab" data-toggle="tab"><?=$res[$k]?>图片</a></li>
                <?php $i++; endforeach ?>

                </ul>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="tab-content">

                        <?php $i=1;foreach ($models as $k=>$model): ?>
                            <div role="tabpanel" class="tab-pane <?php if($i==1){echo 'active';}?>" id="<?=$k?>">

                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'res_name')->hiddenInput(['value' => $k])->label(false) ?>

                            <?= $form->field($model, 'is_thumb')->radioList(['0'=>'否', '1'=>'是']) ?>

                            <?= $form->field($model, 'thumb_mode')->radioList(['1'=>'补白', '2'=>'居中']) ?>

                            <?= $form->field($model, 'thumb_config')->textarea(['rows' => 6])->hint('格式为 100x100;如需要多个缩略图，请换行输入，每行一条缩略规则') ?>

                            <?= $form->field($model, 'water_mod')->radioList(['1'=>'图片', '2'=>'文字']) ?>

                            <div class="form-group field-imageconfig-water_pos">
                                <label class="control-label col-sm-2">水印位置</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="ImageConfig[water_pos]" value="">
                                    <div id="imageconfig-water_pos">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label><input type="radio" <?php if($model->water_pos == -1){echo 'checked';}?> name="ImageConfig[water_pos]" value="-1"> 关闭</label>
                                                <label><input type="radio" <?php if($model->water_pos == 0){echo 'checked';}?> name="ImageConfig[water_pos]" value="0"> 随机</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" <?php if($model->water_pos == 1){echo 'checked';}?> name="ImageConfig[water_pos]" value="1"> #1</label>
                                                <label><input type="radio" <?php if($model->water_pos == 2){echo 'checked';}?> name="ImageConfig[water_pos]" value="2"> #2</label>
                                                <label><input type="radio" <?php if($model->water_pos == 3){echo 'checked';}?> name="ImageConfig[water_pos]" value="3"> #3</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" <?php if($model->water_pos == 4){echo 'checked';}?> name="ImageConfig[water_pos]" value="4"> #4</label>
                                                <label><input type="radio" <?php if($model->water_pos == 5){echo 'checked';}?> name="ImageConfig[water_pos]" value="5"> #5</label>
                                                <label><input type="radio" <?php if($model->water_pos == 6){echo 'checked';}?> name="ImageConfig[water_pos]" value="6"> #6</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" <?php if($model->water_pos == 7){echo 'checked';}?> name="ImageConfig[water_pos]" value="7"> #7</label>
                                                <label><input type="radio" <?php if($model->water_pos == 8){echo 'checked';}?> name="ImageConfig[water_pos]" value="8"> #8</label>
                                                <label><input type="radio" <?php if($model->water_pos == 9){echo 'checked';}?> name="ImageConfig[water_pos]" value="9"> #9</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            </div>

                            <?= $form->field($model, 'water_image')->fileInput() ?>

                            <?= $form->field($model, 'water_text')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'water_opacity')->textInput(['value'=>100]) ?>


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-3">
                                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
                                </div>
                            </div>
                            
                            <?php ActiveForm::end(); ?>

                              </div>
                        <?php $i++;endforeach ?>
                          
                        </div>
                    </div>
                </div>
                <!-- Tab panes -->
                







                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>