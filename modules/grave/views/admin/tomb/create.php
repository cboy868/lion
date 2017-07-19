<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Tomb */

$this->title = '添加墓位';
$grave_id = Yii::$app->request->get('grave_id');

$this->params['breadcrumbs'][] = ['label' => '墓区管理', 'url' => ['/grave/admin/default/index', 'id'=>$grave_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
                <?= Html::encode($this->title) ?>
                <!--
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
				</small>
				-->
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 tomb-create">
				<?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
            <?php if (isset($tombs) && $tombs):?>
                <div class="col-md-12" style="overflow:hidden;overflow:auto;">
                    <style type="text/css">
                        .table ul li.full {
                            margin:5px;
                            border: 1px solid #FFF;
                            background: #ccc;
                        }
                        .pic td{
                            width:40px;
                        }
                        .pic>thead>tr>th,.pic>tbody>tr>th{
                            text-align: center;
                            border: none;
                        }
                        .table td div.full{
                            padding:2px;
                            background: #2E6589;
                        }
                    </style>
                    <h2>已生成墓位示意<small>(<?=count($tombs)?>座墓)</small></h2>
                    <?php
                    $result = ArrayHelper::index($tombs, 'id', 'row');
                    ?>

                    <table class="table table-hover table-condensed table-bordered pic" style="width:auto;">
                        <thead>
                        <tr>
                            <th></th>
                            <?php
                            for ($i=$minCol;$i<=$maxCol;$i++):
                                if ($i==0) continue;?>
                                <th><?=$i?></th>
                            <?php endfor;?>

                        </tr>
                        </thead>
                        <?php foreach ($result as $k=>$models):?>
                            <tr>
                                <th><?=$k?></th>
                                <?php $col=$minCol;foreach ($models as $model): ?>
                                    <?php
                                    if ($col < $model->col):
                                        for(; $col< $model->col; $col++):
                                            if($col==0)continue;
                                            ?>
                                            <td>&nbsp;</td>
                                            <?php
                                        endfor;
                                    endif;
                                    $col++;
                                    ?>
                                    <td><div class="full">&nbsp</div></td>
                                <?php endforeach;?>
                                <?php if($col < $maxCol):for(;$col<=$maxCol; $col++):?>
                                    <td></td>
                                <?php endfor;endif; ?>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php endif;?>
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>