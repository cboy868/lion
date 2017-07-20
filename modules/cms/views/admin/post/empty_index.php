<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\assets\FootableAsset;

$this->title = '图文模块内容管理';
$this->params['breadcrumbs'][] = $this->title;
FootableAsset::register($this);

?>

<style>
    .nc{
        margin-right:10px;
    }
     .parallelogram {
         -webkit-transform:skew(-15deg);
         -moz-transform:skew(-15deg);
         -o-transform:skew(-15deg);
         -ms-transform:skew(-15deg);
         transform:skew(-15deg);
         -webkit-border-radius:5px;
         -moz-border-radius:5px;
         border-radius:5px;
     }
</style>

<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?php
                foreach ($modules as $v): ?>
                    <a href="<?=Url::toRoute(['/cms/admin/post/index', 'mid'=>$v['id']])?>"
                       class="btn btn-default btn-lg parallelogram"><?=$v['title']?></a>
                <?php endforeach;?>
                <small>
                    <img src="/static/images/hand.gif" alt="">点这里
                </small>
            </h1>
        </div>
    </div>
</div>
