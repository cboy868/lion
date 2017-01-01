<?php 
use app\core\helpers\Url;
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">安装向导---安装成功</h3>
        </div>
        <div class="panel-body">
          <h4 class="text-center">4.恭喜，系统安装成功</h4>
          <div class="row">
            <div class="col-md-12">
              <a href="<?=Url::toRoute(['/admin'])?>">进入后台</a>
              <a href="<?=Url::toRoute(['/'])?>">去首页</a>
            </div>

            <div class="col-md-12">
              <p>
                <br>
                
                <?=Yii::$app->getSession()->getFlash('notice'); ?>
              </p>
            </div>

          </div>
        </div>
        <div class="panel-footer text-center">
          <div class="text-info">版权</div>
        </div>
      </div>
    </div>
  </div>
</div>