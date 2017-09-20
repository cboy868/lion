<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\task\models\Info;

$this->params['current_menu'] = 'task/info/project';

$this->title = '任务设置';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?php if (Yii::$app->user->can('task/info/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create', 'pid'=>Yii::$app->request->get('pid')], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?php endif;?>
                </small>

                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/task/admin/info/project'])?>">
                        <i class="fa fa-list-ol fa-2x"></i>  项目管理</a>
                </div>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 info-index">
            <?=\app\core\widgets\Alert::widget()?>

                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>任务</th>
                        <th>处理人</th>

                        <th>备注</th>
                        <th>消息内容</th>
                        <th>提醒方式</th>
                        <th>任务时间</th>
                        <th>消息时间</th>
                        <th width="120">创建时间</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($info as $k => $v):?>
                        <tr>
                            <td>[<?=$v->parent->name?>] <?=$v->name?></td>
                            <td><?=$v->default->user->username?></td>

                            <td><?=$v->intro?></td>
                            <td><?=$v->msg?></td>
                            <td><?=$v->getMsgType()?></td>
                            <td><?=Info::getTimes($v->task_time)?></td>
                            <td><?=Info::getTimes($v->msg_time)?></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>

                            <td width="100">
                                <?php if (Yii::$app->user->can('task/info/update')):?>
                                    <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                        ['class' => 'btn btn-info btn-xs', 'title'=>'编辑']
                                    ) ?>
                                <?php endif;?>

                                <?php if (Yii::$app->user->can('task/info/delete')):?>
                                    <?= Html::a('删除', ['delete', 'id' => $v['id']], [
                                        'class' => 'btn btn-danger btn-xs delete',
                                        'data' => [
                                            'confirm' => '确定要删除此项任务设置吗?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
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

