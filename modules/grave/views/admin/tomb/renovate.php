<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

\app\assets\ExtAsset::register($this);
$this->title = '改墓';
$this->params['breadcrumbs'][] = ['label' => '墓位列表', 'url' => ['/grave/admin/tomb/index']];
$this->params['breadcrumbs'][] = $this->title . '【' . $model->tomb_no . '】';
?>
<div class="page-content">
  <!-- /section:settings.box -->
  <div class="page-content-area">
    <div class="page-header">
      <h1>
          <?=$this->title?>                
      </h1>
    </div><!-- /.page-header -->

    <div class="row">
      <div class="col-xs-6 nav-create">
        <div class="nav-form">

            <form id="w0" class="form-horizontal" method="post">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
            


            <div class="form-group field-nav-name required">
              <label class="control-label col-sm-1" for="nav-name">预计完成时间</label>
              <div class="col-sm-11">
              <input type="text" class="form-control" name="sp[use_time]" maxlength="255" style="width:30%" dt="true">
              <div class="help-block"></div>
              </div>
            </div>
            <div class="form-group field-nav-name required">
              <label class="control-label col-sm-1" for="nav-name">金额</label>
              <div class="col-sm-11">
              <input type="text" class="form-control" name="sp[price]" maxlength="255" style="width:30%">
              <div class="help-block"></div>
              </div>
            </div>

            <div class="form-group field-nav-name required">
              <label class="control-label col-sm-1" for="nav-name">改墓内容</label>
              <div class="col-sm-11">

                <textarea class="form-control" name="sp[intro]" rows="6"></textarea>
              <div class="help-block"></div>
              </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button type="submit" class="btn btn-primary btn-block">保 存</button>        </div>
            </div>
            
            </form>
        </div>
        <div class="hr hr-18 dotted hr-double"></div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.page-content-area -->
</div>