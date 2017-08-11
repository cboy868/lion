<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\Tabletree;
use yii\bootstrap\Modal;


$this->params['breadcrumbs'][] = '个人中心首页';
Yii::$app->params['cur_nav'] = 'member_index';
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>欢迎回来，<?=Yii::$app->user->identity->username;?></h1>
        </div><!-- /.page-header -->




    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('tree') ?>
$(function(){

$("#menu-table").treetable({ expandable: true });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

