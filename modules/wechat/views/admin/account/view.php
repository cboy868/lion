<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\wechat\models\Wechat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '公众号列表', 'url' => ['index']];
?>
<link rel="stylesheet" href="/css/wechat.css">
<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">
        <?= $this->render('../default/left');?>
        <div class="right-content">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?>
                    <small>
                        详细信息查看
                        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger  btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-10 wechat-view">

                    <table class="table table-striped table-bordered">
                        <tr>
                            <th width="100">
                                公众号
                            </th>
                            <td>
                                <?=$model->name; ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                公众号类型
                            </th>
                            <td>
                                <?=$model->levelLabel; ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                AppId
                            </th>
                            <td>
                                <?=$model->appid; ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                AppSecret
                            </th>
                            <td>
                                <?=$model->appsecret; ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                服务器url
                            </th>
                            <td>
                                <?=Url::toRoute(['/home/wechat/default/index', 'id'=>$model->id], true); ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                Token
                            </th>
                            <td>
                                <?=$model->token; ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">
                                Encodingaeskey
                            </th>
                            <td>
                                <?=$model->encodingaeskey; ?>
                            </td>
                        </tr>
                    </table>


                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>
</div>
