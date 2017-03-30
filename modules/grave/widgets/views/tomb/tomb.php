<?php 
use app\core\helpers\Url;
use yii\helpers\Html;
use app\assets\PluploadAssets;
PluploadAssets::register($this);
?>

<div class="col-xs-12">
    <div class="item table-responsive" id="tomb" loc="loc0">
    	<div class="table-header">
            <i class="icon-credit-card"></i> 
           <span class="title_info"> 墓位信息(点击图片上传墓型图)</span>
        </div>
        <table class="table table-bordered table-condensed table-striped">
            <tbody>
                <tr>
                    <td rowspan="17" width="320">

                    <a href="javascript:;" id="filePicker-thumb" class="thumbnail filelist-thumb filePicker" 
                        rid="<?=$tomb->id?>" 
                        data-url="<?=Url::toRoute(["pl-upload"])?>" 
                        data-res_name="tomb"
                        data-use="thumb">
                              <img class="img-rounded" src="<?=$tomb->getImg('320x400')?>" >
                        </a>
                    </td>
                </tr>
                <tr>
                    <th width="120">墓号</th>
                    <td>
                        <?=$tomb->tomb_no?>
                    </td>
                    <td rowspan="11" width="280">
                        <div>
                            <img src="/admin/index/bindPng?user_id=61140">
                            <br>
                            <span style="margin-left:20px;font-size:20px">购买人微信扫码，绑定微信</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>墓价</th>
                    <td>￥<?=$tomb->price?></td>
                </tr>
                <tr>
                    <th>销售状态</th>
                    <td><?=$tomb->getStatusText()?></td>
                </tr>
                <tr>
                    <th>导购员</th>
                    <td><?=$tomb->guide ? $tomb->guide->username : ''?></td>
                </tr>
                <tr>
                    <th>业直</th>
                    <td><?=$tomb->agent ? $tomb->agent->username : '无'?></td>
                    
                </tr>
                <tr>
                    <th>购买时间</th>
                    <td><?=$tomb->sale_time?></td>
                </tr>

                <tr>
                    <th>墓位备注</th>
                    <td><?=$tomb->note?></td>
                </tr>
                <tr>
                    <th>墓证年限</th>
                    <td>
                    <?php if ($tomb->card): ?>
                        <strong><?=$tomb->card->start?> - <?=$tomb->card->end?></strong>
                                <ol class="small">
                                <?php if ($tomb->card->rels): ?>
                                    <?php foreach ($tomb->card->rels as $rel): ?>
                                        <li> <?=$rel->start?> - <?=$rel->end?> </li>
                                    <?php endforeach ?>
                                 <?php endif ?>  
                                </ol>
                    <?=  Html::a('<i class="fa fa-edit"></i> 编辑', ['/grave/admin/card/update','id'=>$tomb->id], ['class'=>'btn btn-primary btn-xs mEditButton',"onclick"=>"return false"]) ?>
                    <?php endif ?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['/grave/admin/card/create','id'=>$tomb->id], ['class'=>'btn btn-primary btn-xs mAddButton',"onclick"=>"return false"]) ?>
                    </td>
                </tr>
                <?php if (isset($tomb->customer)): ?>
                    <tr>
                        <th>客户信息 (<a href="<?=Url::toRoute(['/grave/admin/customer/update', 'id'=>$tomb->customer_id])?>" target="_blank">编辑</a>)</th>
                        <td>
                        <?=$tomb->user? '账号:' . $tomb->user->username . "<!-- <a href='/admin/tomb/access/user_id/61140'>以客户身份登录</a> --><br>":''?>
                        <?=$tomb->customer->name?> <?=$tomb->customer->mobile?> <a href="mailto:<?=$tomb->customer->email?>"><?=$tomb->customer->email?></a> <br>
                        地址:<?=$tomb->customer->address?> <?=$tomb->customer->addr?> <br>
                        单位:<?=$tomb->customer->units?>
                        </td>
                    </tr>
                <?php endif ?>

                <?php if ($tomb->memorial): ?>
                    <tr>
                        <th>纪念馆</th>
                        <td>
                            <a href="#"><?=$tomb->memorial->title?></a> <a href="#" class="btn btn-info btn-xs">编辑</a>
                        </td>
                    </tr>
                    
                <?php endif ?>
                
            </tbody>
        </table>
    </div>
</div>
