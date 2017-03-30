<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\sys\models\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '备注修改历史记录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>历史修改记录
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
          <div class="col-xs-12">
              <!-- PAGE CONTENT BEGINS -->
                 
                 <table class="table">
                   <tr>
                     <th>内容</th>
                     <th>修改人</th>
                     <th>修改时间</th>
                   </tr>
                   <?php foreach ($history as $k => $v): ?>
                     <tr>
                       <td><?=$v->content?></td>
                       <td><?=$v->user->username?></td>
                       <td><?=date('Y-m-d H:i', $v->created_at)?></td>
                     </tr>
                   <?php endforeach ?>
                 </table>
              <!-- PAGE CONTENT ENDS -->
          </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>



















