<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\approval\models\Approval;

$this->title = $model->title;
$this->params['breadcrumbs'][] = '审批详情';
?>
<style>
    .attach{
        margin-bottom:5px;
    }
    .attachfile{
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 3px;
        margin-right: 10px;
    }
    .attachfile a{
        margin-left: 10px;
        font-size: 15px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?php if ($nowstep):?>
                        <div class="pull-right" style="line-height:30px; margin-right:10px">
                            <b style="color:green">
                                <a href="<?=Url::toRoute(['deal', 'id'=>$nowstep->id, 'pro'=>2])?>"
                                   class="modalEditButton btn btn-success"
                                   data-loading-text="页面加载中, 请稍后..."
                                   onclick="return false"
                                >审批通过</a>
                            </b>

                            <b style="color:red">
                                <a href="<?=Url::toRoute(['deal', 'id'=>$nowstep->id, 'pro'=>-1])?>"
                                   class="modalAddButton btn btn-danger"
                                   data-loading-text="页面加载中, 请稍后..."
                                   onclick="return false"
                                >打回</a>
                            </b>
                        </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '打回备注',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '通过备注',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-8 approval-view">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>所属流程</th>
                        <td><?=$model->process->title?></td>
                        <th>审批状态</th>
                        <td><?=$model->pro?></td>
                        <th>提交人</th>
                        <td><?=$model->user->username?></td>
                        <th>提交时间</th>
                        <td><?=date('Y-m-d H:i',$model->created_at)?></td>
                    </tr>
                    <?php if ($model->attachs):?>
                        <tr>
                            <th>附件</th>
                            <td colspan="7">
                                <?php foreach ($model->attachs as $attach):?>
                                    <span class="attachfile">
                                        <?=Html::a($attach->title, [$attach->url],
                                            ['download'=>$attach->title.'.'.$attach->ext])?>
                                        <?php if($model->create_user == Yii::$app->user->id && $model->progress == Approval::PRO_BACK):?>
                                        <a href="<?=Url::toRoute(['del-attach', 'id'=>$attach->id])?>"
                                           class="delAttach" title="删除">x</a>
                                        <?php endif;?>
                                    </span>
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php endif;?>

                    <?php if ($model->total > 0):?>
                        <tr>
                            <th>总金额</th>
                            <td><?=$model->total?></td>
                            <th>已结金额</th>
                            <td><?=$model->yet_money?></td>
                        </tr>
                    <?php endif;?>
                    <tr style="text-align: center">
                        <td colspan="8">
                            <h3><?=$model->title?></h3>
                            <div class="detail" style="text-align: left;">
                                <?=$model->intro?>
                            </div>
                        </td>
                    </tr>
                </table>


                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-md-4">
                <?php $steps = $model->steps;?>
                <table class="table table-bordered table-striped table-hover">
                    <tr style="text-align: center">
                        <td colspan="4">审批历史</td>
                    </tr>
                    <?php foreach ($steps as $step):?>
                        <?php if ($step->progress == 1) continue;?>
                        <tr>
                            <td>
                                <?=$step->step_name . ' ' . $step->pro?>
                                (<?=$step->user->username?> 于 <?=date('Y-m-d H:i', $model->created_at)?>)
                                <?=$step->note?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('tree') ?>
    $(function(){
        $('.delAttach').click(function(e){

            if (!confirm('确定要删除此附件吗?')) {
                return false;
            }
            e.preventDefault();
            var url = $(this).attr('href');
            var that = this;
            $.post(url, {}, function(xhr){
                if(xhr.status) {
                    $(that).closest('.attachfile').remove();
                } else {
                    alert(xhr.info);
                }
            },'json');

        });
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>
