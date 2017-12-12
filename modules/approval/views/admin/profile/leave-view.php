<?php
use app\modules\approval\models\ApprovalLeave;
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 approval-leave-view">
                <table class="table table-bordered">
                    <tbody><tr>
                        <th>状态</th>
                        <td class="leave-reject"><?=$model->statusText?></td>
                        <th>类型</th>
                        <td><?=$model->typeLabel?></td>
                    </tr>
                    <tr>
                        <th>开始时间</th>
                        <td><?=$model->start_day?> <?=$model->start_time?></td>
                        <th>结束时间</th>
                        <td><?=$model->end_day?> <?=$model->end_time?></td>
                    </tr>
                    <tr>
                        <th>总时长</th>
                        <td><?=$model->hours?>小时</td>
                        <th>报到时间</th>
                        <td><?=$model->finish_at?></td>
                    </tr>
                    <tr>
                        <th>事由</th>
                        <td colspan="3"><?=$model->desc?></td>
                    </tr>
                    <tr>
                        <th>申请者</th>
                        <td><?=$model->user->username?></td>
                        <th>审核者</th>
                        <td><?=$model->reviewed_by ? $model->op->username : ''?></td>
                    </tr>
                    <tr>
                        <th>申请时间</th>
                        <td><?=$model->created_dtime?></td>
                        <th>审核时间</th>
                        <td><?=$model->reviewed_dtime?></td>
                    </tr>
                    </tbody>
                </table>


                <?php
                $res_name = $model->genre == ApprovalLeave::GENRE_LEAVE ? 'leave' : 'overtime';

                $list = \app\modules\sys\models\SysLog::rlist($res_name, $model->id);?>
                <table>
                    <caption>历史操作记录</caption>
                    <?php foreach ($list as $model):?>
                    <tr>
                        <td><?=$model->dt?>, 由 <strong><?=$model->op_name?></strong> <?=$model->type?>。</td>
                    </tr>
                    <?php endforeach;?>

                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>