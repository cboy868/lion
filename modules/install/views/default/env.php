<?php

use yii\helpers\Url;

/* @var $this source\core\front\FrontView */
$this->title='检测运行环境';
?>


<div class="row well" style="margin:auto 0;">
    <div class="col-xs-3">
        <div class="progress" title="安装进度">
            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                40%
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                安装步骤
            </div>
            <ul class="list-group">
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-copyright-mark"></span> &nbsp; 许可协议</a>
                <a href="javascript:;" class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-eye-open"></span> &nbsp; 环境监测</a>
                <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-cog"></span> &nbsp; 参数配置</a>
                <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> &nbsp; 安装</a>
                <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> &nbsp; 成功</a>
            </ul>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="panel panel-default">
            <div class="panel-heading">环境检查</div>
            <table class="table table-striped">
                <tbody><tr>
                    <th style="width:150px;">参数</th>
                    <th>值</th>
                    <th></th>
                </tr>
                <tr class="warning">
                    <td>服务器操作系统</td>
                    <td><?=php_uname()?></td>
                </tr>
                <tr class="">
                    <td>Web服务器环境</td>
                    <td><?=$_SERVER['SERVER_SOFTWARE']?></td>
                    <td></td>
                </tr>
                <tr class="">
                    <td>程序安装目录</td>
                    <td><?=dirname($_SERVER['DOCUMENT_ROOT'])?></td>
                    <td></td>
                </tr>
                <tr class="">
                    <td>上传限制</td>
                    <td>64M</td>
                    <td></td>
                </tr>
                <tr>
                    <td height="24">GD 库</td>
                    <td><?php
                        $tmp = function_exists('gd_info') ? gd_info() : array();
                        @$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
                        echo @$env_items[$key]['current'];
                        unset($tmp);
                        ?></td>
                    <td></td>
                </tr>

                </tbody></table>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">依赖扩展 必须满足下列所有条件，否则系统或系统部份功能将无法使用</div>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th style="width:150px;">选项</th>
                    <th style="width:180px;">要求</th>
                    <th style="width:50px;">状态</th>
                    <th>说明及帮助</th>
                </tr>

                <?php foreach($requirements as $requirement): ?>
                    <tr class="<?php if($requirement[2]) echo "success"; else echo 'danger'?>">
                        <td><?php echo $requirement[0]; ?></td>
                        <td class="<?php echo $requirement[2] ? 'passed' : ($requirement[1] ? 'failed' : 'warning'); ?>"><?php echo $requirement[2] ? '通过' : '未通过'; ?></td>
                        <td><?php echo $requirement[3]; ?></td>
                        <td><?php echo $requirement[4]; ?></td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">目录权限监测 安装目录必须可写, 才能使用微擎所有功能。</div>
            <table class="table table-striped">
                <tbody><tr>
                    <th style="width:150px;">目录</th>
                    <th style="width:180px;">要求</th>
                    <th style="width:50px;">状态</th>
                    <th>说明及帮助</th>
                </tr>

                <?php foreach((array)$isWritable as $val):?>
                    <tr class="<?php if($val[2]) echo "success"; else echo 'danger'?>">
                        <td><?php echo $val[0]; ?></td>
                        <td><?php echo $val[2] ? '通过' : '未通过'; ?></td>
                        <td><?php echo  $val[3]; ?></td>
                        <td><?php echo $val[4];?></td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-12 text-center">
            <?php if($requireResult >0 && $writeableResult >0): ?>
                <p class="text-success">恭喜！您的服务器配置符合本系统安装要求。 </p>
            <?php elseif(($requireResult < 0 || $writeableResult <0) ): ?>
                <p class="text-danger">请注意：您的服务器有部分配置不满足需求，如需相应功能，请调整。 </p>
            <?php else: ?>
                <p class="text-danger">您的服务器配置未能满足本系统的安装要求。 </p>
            <?php endif; ?>
        </div>
        <form name="form" class="form" action="<?php echo Url::to(['db'])?>" >
            <input type="hidden" name="do" id="do">
            <ul class="pager">
                <li class="previous">
                    <button class="btn btn-default" onclick="history.go(-1)"><span class="glyphicon glyphicon-chevron-left"></span>返回</button>
                </li>
                <?php if($requireResult == 0 || $writeableResult == 0):?>
                    <button type="submit" class="btn btn-danger" disabled="disabled">环境检测未通过，请根据提示修正后再尝试安装</button>
                <?php else:?>
                <li class="previous">
                    <button class="btn btn-default">继续<span class="glyphicon glyphicon-chevron-right"></span></button>
                </li>
                <?php endif?>
            </ul>
        </form>
    </div>
</div>
