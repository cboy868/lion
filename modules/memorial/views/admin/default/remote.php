<?php

use app\core\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '远程祭祀记录';
$this->params['breadcrumbs'][] = $this->title;

$this->params['current_menu'] = 'memorial/default/index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'remote', 'model'=>$memorial])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>

                <div class="row masonry">
                    <?php $remotes = $dataProvider->getModels()?>
                    <?php foreach ($remotes as $k => $remote):?>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                            <div class="item panel panel-default wrapper-sm">
                                <div class="pos-rlt">
                                    <a style="height: 200px;display: inline-block" href="<?=Url::toRoute(['remote-video', 'id'=>$remote->memorial_id,'remote_id'=>$remote->id])?>">
                                        <img style="max-width:100%;max-height:100%;" class="album-img" alt="" src="<?=$remote->getThumbImg('690x430')?>">
                                    </a>
                                </div>
                                <div class="padder-h text-center">
                                    <h4 class="h4 m-b-sm">
                                        <?=$remote->goods->name == $remote->sku->name ?
                                            $remote->goods->name : $remote->goods->name . $remote->sku->name;
                                        ?>
                                    </h4>

                                    <i class="fa fa-clock-o"></i>
                                    <?=$remote->start?> ~ <?=$remote->end?>

                                    <i class="fa fa-clock-o"></i>
                                    <?=$remote->statusText?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                            'nextPageLabel' => '>',
                            'prevPageLabel' => '<',
                            'lastPageLabel' => '尾页',
                            'firstPageLabel' => '首页',
                            'options' => [
                                'class' => 'pull-right pagination'
                            ]
                        ]);
                        ?>
                    </div>
                </footer>

                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>

    </div><!-- /.page-content-area -->
</div>