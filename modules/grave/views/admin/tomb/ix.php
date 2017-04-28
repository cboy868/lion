<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\TombSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '墓位管理';
$this->params['breadcrumbs'][] = ['label' => '墓区管理', 'url' => ['/grave/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style type="text/css">
    .table ul {
    margin-top: 5px;
    margin-right: 10px;
    margin-bottom: 5px;
    margin-left: 40px;
    list-style-image: none;
    list-style-type: none;
    white-space: nowrap;
    padding: 0px;
}
.table ul li {
    margin: 0px;
    padding: 0px;
    display: block;
    width: 40px;
    float: left;
}
.table ul li span {
    padding: 0px;
    display: block;
    height: 14px;
    width: 40px;
    margin-top: 0px;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    line-height: 14px;
    text-align: center;
    color: #000000;
    font-size: 12px;
}
.table ul li img {
    padding: 0px;
    display: block;
    height: 24px;
    width: 24px;
    margin-top: 0px;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    border: 1px solid #FFF;
}
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  isset($grave) ? Html::encode($grave->name) : '' ?> 墓位管理
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_ixsearch', ['model' => $searchModel, 'parents'=>$parents, 'grave'=>$grave]); ?>
                </div>
            </div>
            <div class="col-xs-12 tomb-index">
                <div class="tfram">
                    
                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

