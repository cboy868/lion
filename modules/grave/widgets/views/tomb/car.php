<?php 
use app\modules\grave\models\CarRecord;
?>

<?php if (isset($records)): ?>
    <div class="col-xs-12">
        <div class="item table-responsive" id="car" loc="loc10">
             <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">派车记录</span></div>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                    <?php if (isset($records[CarRecord::CAR_FENG]) && $records[CarRecord::CAR_FENG]): ?>
                    <tr>
                        <th colspan="19">风行车</th>
                    </tr>
                    <tr>
                        <th>车牌号</th>
                        <th>司机</th>
                        <th>联系人</th>
                        <th>手机号码</th>
                        <th>地址</th>
                        <th>人数</th>
                        <th>是否返程</th>
                        <th>是否火化</th>
                        <th>订车时间</th>
                        <th>状态</th>
                        <th colspan="2">备注</th>
                    </tr>

                    <?php foreach ($records[CarRecord::CAR_FENG] as $k => $r): ?>
                        <tr>
                            <td><?=isset($r->car->code) ? $r->car->code:''?></td>
                            <td><?=isset($r->driver->username) ? $r->driver->username:''?></td>
                            <td><?=$r->contact_user?></td>
                            <td><?=$r->contact_mobile?></td>
                            <td><?=$r->addr?></td>
                            <td><?=$r->user_num?></td>
                            <td><?=$r->is_back? '是': '否'?></td>
                            <td><?=$r->use_date . $r->use_time?></td>
                            <td><?=$r->statusText?></td>
                        </tr>
                    <?php endforeach ?>
                    <?php endif ?>
                    
                    <?php if (isset($records[CarRecord::CAR_LING]) && $records[CarRecord::CAR_LING]): ?>
                        <tr><th colspan="19">迎灵车</th></tr>
                        <tr>
                            <th>车牌号</th>
                            <th>司机</th>
                            <th>逝者姓名</th>
                            <th>联系人</th>
                            <th>手机号码</th>
                            <th>殡仪馆</th>
                            <th>是否火化</th>
                            <th>订车时间</th>
                            <th colspan="2">备注</th>
                        </tr>
                        <?php foreach ($records[CarRecord::CAR_LING] as $k => $record): ?>
                            <tr>
                                <td><?=isset($r->car->code) ? $r->car->code:''?></td>
                                <td><?=isset($r->driver->username) ? $r->driver->username:''?></td>
                                <td><?=$r->dead_name?></td>
                                <td><?=$r->contact_user?></td>
                                <td><?=$r->contact_mobile?></td>
                                <td><?=isset($r->address->title) ? $r->address->title:''?></td>
                                <td><?=$r->is_cremation? '是': '否'?></td>
                                <td><?=$r->use_date . $r->use_time?></td>
                                <td colspan="2"><?=$r->note?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    
                            </tbody>
            </table>
        </div>
    </div>
<?php endif ?>
