<?php
/* @var $this yii\web\View */
use app\core\helpers\Url;


$this->title = '数据表信息';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-10">
              <?php foreach($tables as $table):?>
                <div class="box box-solid" id="<?=$table->name;?>">
                   <div class="box-header">
                      <h3 class="box-title">表 [ <strong><?=$table->name;?></strong> ] </h3>
                      <div class="box-tools">
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                          <table class="table table-striped table-hover table-bordered table-condensed">
                          <thead>
                            <tr>
                              <th>列名</th>
                              <th>备注</th>
                              <th>类型</th>
                              <th>缺省</th>
                             </tr>
                          </thead>
                          <tbody>
                          <?php foreach($table->columns as $column):?>
                          <tr>
                            <th style="width:12em;"><code><?=$column->name?></code></th>
                            <th style="width:20em" class="text-success"><?=$column->comment?>

                            </th>
                            <td class="small"><?=$column->dbType?></td>
                            <td class="small"><?=$column->defaultValue?></td>
                          </tr>
                          <?php endforeach;?>
                          </tbody>
                        </table>
                    </div>
                </div>
              <?php endforeach;?>
              <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
            <div class="col-xs-2">
              <ul class="sui-nav nav-list">
                  <?php foreach($tables as $table):?>
                  <li><a href="#<?=$table->name;?>"><i class="fa fa-table"></i> <?=$table->name;?></a></li>
                  <?php endforeach;?>
              </ul>
              <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>














