<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;


\app\assets\ExtAsset::register($this);
$this->title = $tomb->tomb_no . '购买特殊商品';
$this->params['breadcrumbs'][] = ['label' => '墓位列表', 'url' => ['/grave/admin/tomb/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['current_menu'] = 'grave/mall/shop';
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
      <div class="col-xs-12 nav-create">
        <div class="nav-form">

            <form id="w0" class="form-horizontal" method="post">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
            <div class="form-group field-nav-name required">
              <label class="control-label" for="nav-name">商品名</label>
              <input type="text" class="form-control" name="sp[name]" maxlength="255" style="width:50%">
            </div>

            <div class="form-group field-nav-name required">
              <label class="control-label" for="nav-name">价格</label>
              <input type="text" class="form-control" name="sp[price]" maxlength="255" style="width:30%">
            </div>

            <div class="form-group field-nav-name required">
              <label class="control-label" for="nav-name">完成时间</label>
              <input type="text" class="form-control" name="sp[use_time]" maxlength="255" style="width:30%" dt="true">
            </div>

            <div class="form-group field-nav-name required">
              <label class="control-label" for="nav-name">任务类型</label>
              <select class="form-control" name="sp[task]">
                <?php foreach ($task as $k => $v): ?>
                  <option value="<?=$v->id?>"><?=$v->name?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group field-nav-name required">
              <label class="control-label" for="nav-name">备注</label>
              <textarea class="form-control" name="sp[note]" rows="6"></textarea>
            </div>

            <div class="form-group">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary btn-block">保 存</button>
                </div>
            </div>
            
            </form>
        </div>
        <div class="hr hr-18 dotted hr-double"></div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.page-content-area -->
</div>