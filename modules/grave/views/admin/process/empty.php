<?php
use yii\helpers\Url;
$step = Yii::$app->request->get('step');
$tomb_id = Yii::$app->request->get('tomb_id');
?>
<div class="page-content" id="ins-container">
    <!-- /section:settings.box -->
    <div class="page-content-area">
    	<div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
    </div>

    <div class="row">
        <div class="col-md-12" style="text-align: center;font-size: 30px;margin-top: 20px;margin-bottom: 20px;color: #f44;">
            没有要刻碑的使用人,请选择以下操作
        </div>

        <div class="col-sm-12" style="text-align:center;">



            <a href="<?=Url::toRoute(['/grave/admin/process/index', 'step'=>$step-1,'tomb_id'=>$tomb_id])?>"
               class="btn btn-info btn-lg" style="padding: 10px 36px">上一步 <small>(使用人信息)</small></a>
            <a href="<?=Url::toRoute(['/grave/admin/process/index', 'step'=>$step+1,'tomb_id'=>$tomb_id])?>"
               class="btn btn-info btn-lg" style="padding: 10px 36px">下一步 <small>(瓷像制作)</small></a>
        </div>
    </div>

		
</div>
