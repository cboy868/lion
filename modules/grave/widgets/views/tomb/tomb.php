<?php 
use app\core\helpers\Url;

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
                    <th>墓位价格</th>
                    <td>￥<?=$tomb->price?></td>
                </tr>
                <tr>
                    <th>销售状态</th>
                    <td><?=$tomb->getStatusText()?></td>
                </tr>
                <tr>
                    <th>客户账号</th>
                    <td><?=$tomb->user?$tomb->user->username:''?> 
                    <!-- <a href="/admin/tomb/access/user_id/61140">以客户身份登录</a> -->
                    </td>
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
                     <?=$tomb->card->start?> 至 <?=$tomb->card->end?>   
                     <?php if ($tomb->card->rels): ?><br/>
                     (
                        <?php foreach ($tomb->card->rels as $rel): ?>
                            <?=$rel->start?> 至 <?=$rel->end?> / 
                        <?php endforeach ?>
                     )                            
                     <?php endif ?>                                                              
                     <!-- <a ylw-remote-form="true" href="/admin/tomb/editcard?tomb_id=119"> 编辑</a> -->
                                          </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

