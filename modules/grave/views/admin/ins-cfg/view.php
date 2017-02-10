<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\InsCfg */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ins Cfgs', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?= Html::a('配置列表', ['index', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('<i class="fa fa-plus"></i> 添加配置', ['create-case', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('<i class="fa fa-plus"></i> 批量添加配置', ['batch-case', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-xs-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                          <th width="150">前(人数)/后(字数)</th>
                          <th width="100">宽度</th>
                          <th width="100">高度</th>
                          <th>样图</th>
                          <th width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>

                <?php foreach ($all as $k => $v): ?>
                    <tr>
                      <td><?=$v['num']?></td>
                      <td><?=$v['width']?></td>
                      <td><?=$v['height']?></td>
                      <td><image width="72"  src="<?=$v['img']?>"/></td>
                      <td>
                          <a href="/admin/greate?case_id=<?=$v['id']?>">编辑</a>
                          <a href="/admin/inscfg/copy?case_id=<?=$v['id']?>" class="copy">复制</a>
                          <a href="/admin/inscfg/delete?case_id=<?=$v['id']?>" class="delete">删除</a>
                      </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                </table>
              </div>











            <div class="col-xs-10 ins-cfg-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'shape',
            'is_god',
            'is_front',
            'note:ntext',
            'sort',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>