<?php if ($tasks): ?>
<div class="col-xs-12">
  <div class="item table-responsive" id="task">
  <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
      <table class="table table-bordered table-condensed table-striped">
          <tbody>
  <tr>
                  <th>任务标题</th>
                  <th>处理人</th>
                  <th width="200">任务内容</th>
                  <th>任务状态</th>
                  <th>任务时间</th>
              </tr>

              <?php foreach ($tasks as $k => $cate): ?>
                <?php foreach ($cate as $k => $task): ?>
                  <tr class="main">
                     <td width="160">
                         <a href="/admin/notice/detail/id/122297" target="_blank"><?=$task->title?></a>
                       </td>
                     <td width="80"><?=$task->op->username?></td>
                     <td><?=$task->content?></td>
                     <td width="80"><?=$task->statusText?></td>
                     <td width="100"><?=$task->pre_finish?></td>
                </tr>
                <?php endforeach ?>
              <?php endforeach ?>
          </tbody>
  </table>

  </div>
</div>
<?php endif ?>
