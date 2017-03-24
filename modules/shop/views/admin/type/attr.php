<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\assets\ZtreeAsset;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\search\Attr */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type->title.'属性管理';
$this->params['breadcrumbs'][] = ['label' => '类型列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
<div class="page-header">
            <h1>
                <small>
                    <a href="<?=Url::to(['attr-create', 'type_id'=>Yii::$app->request->get('id')])?>" class='btn btn-primary btn-sm modalAddButton' title="添加属性"><i class="fa fa-plus"></i>添加属性</a>
                    <a href="<?=Url::toRoute(['spec', 'id'=>Yii::$app->request->get('id')])?>" class="btn btn-default pull-right">规格管理</a>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>
       

       <div class="row">
           <div class="col-md-12">
               <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

               <?php foreach ($dataProvider->getModels() as $model): ?>
                   <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$model->id?>" aria-expanded="true" aria-controls="collapse<?=$model->id?>">
                          <?=$model->name?> <small><?=$model->body?></small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?=$model->id?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <table class="table table-striped table-hover table-bordered table-condensed">
                          <tr>
                              <td colspan="3" style="text-align:right;">
                                <a class="modalEditButton btn btn-info btn-xs" href="<?=Url::toRoute(['/shop/admin/type/spec-update', 'id'=>$model->id])?>" title="编辑"><span class="fa fa-edit"></span>编辑属性 <?=$model->name?></a> 
                                <a href="<?=Url::toRoute(['/shop/admin/type/spec-delete', 'id'=>$model->id])?>" class="btn btn-danger  btn-xs" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post"><span class="fa fa-trash"></span>删除此属性</a> 
                                <a href="<?=Url::toRoute(['/shop/admin/type/spec-create-val', 'id'=>$model->id])?>" class="modalAddButton btn btn-info  btn-xs" title="添加属性值"><span class="fa fa-plus"></span>添加属性值</a>
                              </td>
                        </tr>
                      <?php foreach ($model->vals as $val): ?>
                        <tr>
                            <td width="50"><img src="<?=$val->getThumb('36x36')?>"> </td>
                            <td><?=$val->val?></td>
                            <td width="80">
                            <a class="modalEditButton" href="<?=Url::toRoute(['/shop/admin/type/spec-update-val', 'id'=>$val->id])?>" title="编辑"><span class="glyphicon glyphicon-pencil"></span></a> 
                            <a href="<?=Url::toRoute(['/shop/admin/type/spec-delete-val', 'id'=>$val->id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post"><span class="glyphicon glyphicon-trash"></span></a> 
                            </td>
                        </tr>
                      <?php endforeach ?>
                      

                      </table>

                    </div>
                  </div>
               <?php endforeach ?>
                </div>
           </div>
          
       </div>   
    </div><!-- /.page-content-area -->
</div>