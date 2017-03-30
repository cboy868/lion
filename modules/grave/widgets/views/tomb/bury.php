<?php 
use app\modules\grave\models\Bury;
?>

<?php if (isset($burys[Bury::STATUS_NORMAL])): ?>
    <div class="col-xs-12">
        <div class="item table-responsive" id="bury" loc="loc11">
            <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">预葬记录</span></div>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                    <tr>
                    <th>逝者名称</th>
                    <th>预葬时间</th>

                    </tr>
                    <?php foreach ($burys[Bury::STATUS_NORMAL] as $k => $bury): ?>
                        <tr>
                            <td>
                            <?php if ($bury->deads): $deads = $bury->deads;?>
                                <?php foreach ($deads as $k => $dead): ?>
                                    <?=$dead->dead_name?>(<?=$dead->genderText?>, <?=$dead->dead_title?>, <?=$dead->boneType?>)
                                <?php endforeach ?>
                            <?php endif ?>
                            <span style="color:green"> [序号:<?=$dead->serial?>] </span></td>
                            <td><?=$bury->pre_bury_date?></td>
                        </tr> 
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>

<?php if (isset($burys[Bury::STATUS_OK])): ?>
    <div class="col-xs-12">
        <div class="item table-responsive" id="bury" loc="loc11">
            <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">预葬记录</span></div>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                <tr>
                    <th>逝者名称</th>
                    <th>安葬时间</th>
                </tr>
                <?php foreach ($burys[Bury::STATUS_OK] as $k => $bury): ?>
                    <tr>
                        <td>
                        <?php if ($bury->deads): $deads = $bury->deads;?>
                            
                            <?php foreach ($deads as $k => $dead): ?>
                                <?=$dead->dead_name?>(<?=$dead->genderText?>, <?=$dead->dead_title?>, <?=$dead->boneType?>)
                            <?php endforeach ?>
                        <?php endif ?>
                        <span style="color:green"> [序号:<?=$dead->serial?>] </span></td>
                        <td><?=$bury->bury_date?></td>
                    </tr> 
                <?php endforeach ?>
                       
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>