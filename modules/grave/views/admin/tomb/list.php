<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\TombSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


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


<?php 
    $models = $dataProvider->getModels();
    $result = ArrayHelper::index($models, 'id', 'row');
 ?>
 <?php if (!$models): ?>
     <p>此墓区不存在墓位</p>
 <?php endif ?>

 <table class="table">
    <?php foreach ($result as $k=>$models):?>
     <tr>
         <td>
            <div class="pull-left"><?=$k?>排</div>
             <ul>
                <?php foreach ($models as $model): ?>
                 <li>
                     <div>
                         <a href="#">
                             <img src="/static/images/t.gif" width="26" height="26" title="<?=$model->tomb_no?>">
                         </a>
                         <span><?=$model->col?>号</span>
                     </div>
                 </li>
                <?php endforeach ?>
             </ul>
         </td>
     </tr>
    <?php endforeach ?>
 </table>

    <div class="hr hr-18 dotted hr-double"></div>
