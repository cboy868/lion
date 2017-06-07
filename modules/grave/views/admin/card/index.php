<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '墓证';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!--
        <div class="page-header">
            <h1>
            </h1>
        </div>
        -->
        <!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 card-index">
                <div id="w1" class="grid-view">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <?php foreach ($dataProvider->getModels() as $k => $model): ?>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne<?=$model->id?>">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$model->id?>"
                               aria-expanded="true" aria-controls="collapseOne<?=$model->id?>">
                                墓位:<?=$model->tomb->tomb_no?>,开始<?=$model->start?>,截止:<?=$model->end?>,总年数:<?=$model->total?>
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOne<?=$model->id?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="<?=$model->id?>">
                            <table class="table table-striped table-hover table-bordered table-condensed t1">
                            <tr>
                                <th>开始</th>
                                <th>截止</th>
                                <th>总年数</th>
                                <th>添加时间</th>
                            </tr>
                            <?php foreach ($model->rels as $rel): ?>
                                <tr>
                                    <td><?=$rel->start?></td>
                                    <td><?=$rel->end?></td>
                                    <td><?=$rel->total?></td>
                                    <td><?=date('Y-m-d H:i', $rel->created_at)?></td>
                                </tr>
                            <?php endforeach ?>
                            </table>
                        </div>
                      </div>
                      <?php endforeach ?>
                    </div>
                </div>
                
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

