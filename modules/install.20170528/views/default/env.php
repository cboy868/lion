<?php

use yii\helpers\Url;

/* @var $this source\core\front\FrontView */
$this->title='检测运行环境';
?>


<div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
          	<div class="panel-heading">
              <h3 class="panel-title">第一步:环境及目录检查</h3>
            </div>

				
				<div class="row">

					<div class="col-md-12">
						<h5 class="install_title">环境检查</h5>
						<table class="table table-striped table-bordered">
					        <tr class="install_sub_title">
					            <th width="25%" height="30">项目</th>
					            <th width="30%">所需配置</th>
					            <th width="30%">推荐配置</th>
					            <th width="15%">当前服务器</th>
					        </tr>
					        <tr>
					            <td height="24">附件上传</td>
					            <td>不限制</td>
					            <td>2M</td>
					            <td><?php echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"?></td>
					        </tr>
					        <tr>
					            <td height="24">GD 库</td>
					            <td>1.0</td>
					            <td>2.0</td>
					            <td><?php
											$tmp = function_exists('gd_info') ? gd_info() : array();
											@$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
											echo @$env_items[$key]['current'];
											unset($tmp);
									?></td>
					        </tr>
					    </table>
					</div>

					<div class="col-md-12">
						<h5 class="install_title">目录、文件权限检查</h5>
						<table class="table table-striped table-bordered">
					        <tr class="install_sub_title">
					            <th width="28%">目录文件</th>
					            <th width="10%">检测结果</th>
					            <th width="30%">依赖</th>
					            <th>备注</th>
					        </tr>
					        <?php foreach((array)$isWritable as $val):?>
					        <tr <?php if (!$val[2]): ?>class="alert-danger"<?php endif ?>>
					            <td><?php echo $val[0]; ?></td>
					            <td><?php echo $val[2] ? '通过' : '未通过'; ?></td>
					            <td><?php echo  $val[3]; ?></td>
					            <td><?php echo $val[4];?></td>
					        </tr>
					        <?php endforeach ?>
					    </table>
					</div>

					<div class="col-md-12">
						<h5 class="install_title">依赖扩展</h5>
						<table class="table table-striped table-bordered">
					        <tr class="install_sub_title">
					            <th width="28%">项目名称</th>
					            <th width="10%">检测结果</th>
					            <th width="30%">组件依赖</th>
					            <th>备注</th>
					        </tr>
					        <?php foreach($requirements as $requirement): ?>
					        <tr>
					            <td><?php echo $requirement[0]; ?></td>
					            <td class="<?php echo $requirement[2] ? 'passed' : ($requirement[1] ? 'failed' : 'warning'); ?>"><?php echo $requirement[2] ? '通过' : '未通过'; ?></td>
					            <td><?php echo $requirement[3]; ?></td>
					            <td><?php echo $requirement[4]; ?></td>
					        </tr>
					        <?php endforeach; ?>
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
				</div>


				<div class="panel-footer text-right">
	              	<form name="form" class="form" action="<?php echo Url::to(['db'])?>" >

					<?php if($requireResult == 0 || $writeableResult == 0):?>
		            	<button type="submit" class="btn btn-danger" disabled="disabled">环境检测未通过，请根据提示修正后再尝试安装</button>
		            <?php else:?>
		            	<button type="submit" class="btn btn-primary">下一步</button>
		            <?php endif?>
		            </form>

	              
	            </div>

			</div>
		</div>
	</div>
</div>

