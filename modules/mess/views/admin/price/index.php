<?php

use app\core\helpers\Html;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
$this->title = '食堂账户';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 勾选食堂用户', ['create'], ['class' => 'btn btn-info btn-sm pull-right']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '添加新菜单',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '账户充值',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-xs-12" >
                <div style="border: 1px solid green;border-radius: 5px;padding: 5px;">
                    <h5 style="color:red;">以下账号余额不足，提醒充值</h5>
                    <ul class="list-inline">

                        <?php foreach ($note_user as $user):?>
                        <li style="width:10em;">
                          <span style="width:4em;">
                             <a class="modalEditButton"
                                href="<?=\yii\helpers\Url::toRoute(['recharge', 'user_id'=>$user->user_id])?>"
                                data-loading-text="页面加载中, 请稍后..."
                                onclick="return false"
                             ><?=$user->user->username?></a>
                          </span>
                          <span style="color:red;"><?=$user->price?>元</span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 mess-user-price-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'user.username',
            'price',
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{recharge} {record}',
                'buttons' => [
                    'recharge' => function($url, $model, $key) {
                        $url = \yii\helpers\Url::toRoute(['recharge','user_id'=>$model->user_id]);
                        return Html::a('充值', $url, ['title' => '充值',
                            'class'=>'modalEditButton',
                            "data-loading-text"=>"页面加载中, 请稍后...",
                            "onclick"=>"return false"] );
                    },
                    'record' => function($url, $model, $key) {
                        $url = \yii\helpers\Url::toRoute(['record','user_id'=>$model->user_id]);
                        return Html::a('<i class="fa fa-eye"></i>充值记录', $url, ['title' => '充值记录'] );
                    }
                ],
                'headerOptions' => ['width' => '120',"data-type"=>"html"]
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>