<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '业务办理';

?>
<style>
.well{
    padding:10px;
    background-color: #fff;
    border:2px solid #e5e5e5;
    border-radius: 4px;
}
.widget-body .table{
    border:none;
}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">

            <div class="col-xs-12 tomb-index">
                <!--客户信息-->
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">1、墓位信息</h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <p>
                                位置:颐安二十一1排1号, 墓价:2890元
                            </p>
                            <p>
                                备注:这里是一些备注的内容
                            </p>
                        </div>
                    </div>
                </div>

                <?php $tomb_id=Yii::$app->request->get('tomb_id');?>

                <?=\app\modules\grave\widgets\Pro::widget([
                        'method'=>'customer',
                        'tomb_id'=>$tomb_id
                ])?>

                <?=\app\modules\grave\widgets\Pro::widget([
                    'method'=>'dead',
                    'tomb_id'=>$tomb_id
                ])?>


                <?=\app\modules\grave\widgets\Pro::widget([
                    'method'=>'ins',
                    'tomb_id'=>$tomb_id
                ])?>



                <!--使用人信息-->
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">5、瓷像信息</h4>

                        <div class="widget-toolbar no-border">

                            <a href="#collapsePortrait"
                               data-toggle="collapse"
                               aria-expanded="false"
                               aria-controls="collapsePortrait">
                                <i class="ace-icon fa fa-chevron-down"></i>
                                编辑
                            </a>

                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <p>
                                小音乐(父亲 1984-09-01 ~ 2017-09-01) 灵位(自带红布)
                            </p>
                            <p>
                                大音乐(母亲 1984-09-01 ~ 2017-09-01) 骨灰(自带盒)
                            </p>
                        </div>

                        <div class="collapse" id="collapsePortrait">
                            <div class="well">
                                姓名: <input type="text">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">6、安葬信息</h4>

                        <div class="widget-toolbar no-border">

                            <a href="#collapseBury"
                               data-toggle="collapse"
                               aria-expanded="false"
                               aria-controls="collapseBury">
                                <i class="ace-icon fa fa-chevron-down"></i>
                                编辑
                            </a>

                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <p>
                                小音乐(父亲 1984-09-01 ~ 2017-09-01) 灵位(自带红布)
                            </p>
                            <p>
                                大音乐(母亲 1984-09-01 ~ 2017-09-01) 骨灰(自带盒)
                            </p>
                        </div>

                        <div class="collapse" id="collapseBury">
                            <div class="well">
                                姓名: <input type="text">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">7、订单信息</h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <p>
                                小音乐(父亲 1984-09-01 ~ 2017-09-01) 灵位(自带红布)
                            </p>
                            <p>
                                大音乐(母亲 1984-09-01 ~ 2017-09-01) 骨灰(自带盒)
                            </p>
                        </div>
                    </div>

                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-3">

            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('foo') ?>
$(function(){

 $('.remote').click(function (e) {
     //$('#collapseTomb').load("<?=Url::toRoute(['/grave/admin/process/index', 'tomb_id'=>13,'step'=>1])?>");
 });
})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
