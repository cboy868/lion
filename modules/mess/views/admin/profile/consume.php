<?php

use app\core\helpers\Url;
use app\core\widgets\GridView;

$this->title = '消费记录';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/user/admin/profile/index']];
$this->params['breadcrumbs'][] = ['label' => '我的食堂', 'url' => ['/mess/admin/profile/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['profile_nav'] = 'mess';

?>

<div class="page-content">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-18">
                <?=$this->render('@app/modules/user/views/admin/profile/nav');?>
                <a href="<?=Url::toRoute(['/mess/admin/profile/recharge'])?>"
                   class="radius4 btn btn-xs btn-white pull-right">
                    <i class="fa fa-list"></i>
                    我的充值记录</a>
                <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>"
                   class="radius4 btn btn-xs btn-white pull-right">
                    <i class="fa fa-list"></i>
                    我的食堂主页</a>

            </ul>

            <div class="tab-content padding-12">
                <div class="tab-pane active">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>消费记录</h4>
                            <div class="search-box search-outline">
                                <?php  echo $this->render('_search_consume', ['model' => $searchModel]); ?>
                            </div>
                        </div>
                        <!-- table start -->
                        <div class="col-xs-12 task-index">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    'mess.name',
                                    'menu.name',
                                     'day_time',
                                     'real_price',
                                     'num',
                                     'type',
                                    [
                                        'label' => '类别',
                                        'value' => function($model) use($types){
                                            return $types[$model->type];
                                        }
                                    ],
                                    [
                                        'label' => '是否已使用',
                                        'value' => function($model){
                                            return $model->is_over ? '已使用' : '预定状态';
                                        }
                                    ],
                                ],
                            ]); ?>

                            <div class="hr hr-18 dotted hr-double"></div>
                        </div><!-- /.col -->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>