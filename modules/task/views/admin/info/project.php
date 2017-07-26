<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\task\models\Info;

$this->title = '任务项目管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?php if (Yii::$app->user->can('task/info/create-pro')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create-pro'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 info-index">
            <?=\app\core\widgets\Alert::widget()?>

                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>项目</th>
                        <th>备注</th>
                        <th>触发方式</th>
                        <th width="120">创建时间</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($info as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><?=$v['name']?></td>
                            <td><?=$v->intro?></td>
                            <td><?=Info::trig($v->trigger);?></td>

                            <td><?=date('Y/m/d',$v['created_at'])?></td>

                            <td width="260">

                                <?php if (Yii::$app->user->can('task/info/trigger')):?>
                                <?=Html::a('触发条件', Url::toRoute(['trigger', 'id'=>$v->id]), ['title' => '触发条件', 'class'=>'btn btn-default btn-xs'] );?>
                                <?php endif;?>


                                <?php if (Yii::$app->user->can('task/info/update')):?>
                                    <?= Html::a('编辑', ['update-pro', 'id' => $v['id']],
                                        ['class' => 'btn btn-info btn-xs', 'title'=>'编辑']
                                    ) ?>
                                <?php endif;?>

                                <?php if (Yii::$app->user->can('task/info/delete')):?>
                                    <?= Html::a('删除', ['delete-pro', 'id' => $v['id']], [
                                        'class' => 'btn btn-danger btn-xs delete',
                                        'data' => [
                                            'confirm' => '确定要删除此项目吗?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                <?php endif;?>

                                <?php if (Yii::$app->user->can('task/info/index') && !$v->pid):?>
                                    <?=Html::a('任务设置', Url::toRoute(['index', 'pid'=>$v->id]), ['title' => '任务设置', 'class'=>'btn btn-default btn-xs'] );?>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

