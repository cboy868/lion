<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->params['current_menu'] = 'cms/post/index';


$this->title = '添加' . $module->title . '文章';
$this->params['breadcrumbs'][] = ['label' => $module->title . '模块', 'url' => ['index','mid'=>$module->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- <div class="page-header">
            <h1> -->
        <!--   <?= Html::encode($this->title) ?> -->
        <!--
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small>
        -->
        <!-- </h1>
    </div> -->
        <!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 post-create">
                <?php
                $view = '_' . Yii::$app->request->get('type') . 'form';
                ?>
                <?= $this->render($view, [
                    'model' => $model,
                    'attach'=> $attach,
                    'module' => $module
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>