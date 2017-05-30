<?php

use app\core\helpers\Html;

use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\cms\models\Message;


use app\assets\FootableAsset;
FootableAsset::register($this);

$this->title = '留言咨询';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- <div class="page-header">
            <h1>
                <small>
                </small>
            </h1>
        </div> -->
        <!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 message-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'id' => 'grid',
        'showFooter' => true,
        'columns' => [
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30', "data-type"=>"html"],
                'footer' => '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 5, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            'title',
//            [
//                'headerOptions' => ["data-type"=>"html"],
//                'label' => '商品名',
//                'value' => function($model){
//                        $goods_name = isset($model->goods) ? $model->goods->name : '';
//                        return '<a href="'.Url::toRoute(['/home/product/view', 'id'=>$model->goods_id]).'" target="_blank">'.$goods_name.'</a>';
//                },
//                'format' => 'raw'
//            ],
//            'term',
//            'company',
            'username',
            'mobile',
            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => 'Email',
                'value' => function($model){
                    return $model->email;
                },
                'format' => 'email'
            ],
            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => '处理人',
                'value' => function($model){
                    if ($model->op_id) {
                        return $model->user->username;
                    }

                    return '';
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'QQ',
                'value' => function($model){
                    return $model->qq;
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'Skype',
                'value' => function($model){
                    return $model->skype;
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '主内容',
                'value' => function($model){
                    return $model->intro;
                },
                'format' => 'raw'
            ],

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {deal}',
                'buttons' => [
                    'deal' => function($url, $model, $key) {
                        if ($model->status == Message::STATUS_NORMAL) {
                            return Html::a('处理完成', $url, ['title' => '处理完成', 'aria-label'=>'处理完成', "class"=>"deal"] );
                        }

                        return null;
                    }
                ],
            ],

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('foo') ?>  
  $(function(){
    $('.table').footable();

    $('.deal').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var that = this;
        $.post(url, null, function(xhr){
            if (xhr.status) {
                $(that).remove();
            } 
        },'json');
    });

    $('.btn-delete').click(function(){
        var ids = $('#grid').yiiGridView('getSelectedRows');

        if (ids.length<1) {
            alert('请先选择要删除的商品');
            return;
        }
        if (!confirm("您确定要删除这些商品吗?,删除后不可恢复")){return false;}

        var url = "<?=Url::toRoute(['batch-del'])?>";

        $.post(url, {ids:ids},function(xhr){
            if (xhr.status){
                location.reload();
            } else {
                alert(xhr.info);
            }
        },'json');

    });
  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?> 