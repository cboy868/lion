<?php if ($deads): ?>
    <style type="text/css">
        .die{
            background: #faa;
        }
    </style>
    <div class="col-xs-12 tomb-view">
        <div class="item table-responsive" id="dead" loc="loc2">
            <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">使用人信息</span></div>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
        <tr>
                        <th>姓名</th>
                        <th>生日</th>
                        <th>祭日</th>
                        <th>是否健在</th>
                        <th>是否刻碑</th>
                        <th>使用人是客户的</th>
                        <th>安葬性质</th>
                        <th>预葬时间</th>
                        <th>安葬时间</th>
                    </tr>
                    <?php foreach ($deads as $k => $dead): ?>
                        <tr class="<?php if (!$dead->is_alive): ?>die<?php endif ?>">
                             <td><?=$dead->dead_name?></td>
                             <td><?=$dead->birth?></td>
                             <td><?=$dead->fete?></td>
                             <td><?=$dead->is_alive ? '是' : '否'?></td>
                             <td><?=$dead->is_ins ? '是' : '否'?></td>
                             <td><?=$dead->dead_title?></td>
                             <td><?=$dead->boneType?></td>
                             <td><?=$dead->pre_bury?></td>
                             <td><?=$dead->bury?></td>
                         </tr>
                    <?php endforeach ?>
                    </tbody>
            </table>
        </div>
    </div><!-- /.col -->
<?php endif ?>
