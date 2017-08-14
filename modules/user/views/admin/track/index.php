<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\TrackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '脚印';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                资源访问记录
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 track-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'id' => 'grid',
        'showFooter' => true,  //设置显示最下面的footer
        'columns' => [
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30'],
                'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 10, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            [
                'label'=>'来访人',
                'value'=>function($model){
                    $img = '<img src="'.$model->user->getAvatar('36x36').'">';
                    return $img . $model->user->username;
                },
                'format' => 'raw'
            ],
            'res_name',
            [
                'label' => '访问对象',
                'value' => function($model){
                    return Html::a($model->resUrl,$model->resUrl,['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            'y',
             'm',
             'ip',
             'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{update} {delete} {permission} {user}',
                'visibleButtons' =>[
                    'delete' =>Yii::$app->user->can('sys/auth-role/delete'),
                ]
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>
    $(function(){
        $('td.deltd').siblings('td').remove();

        $('.btn-delete').click(function(){
            var ids = $('#grid').yiiGridView('getSelectedRows');
            if (ids == ''){
                alert('请选择要删除的数据');
                return;
            }

            if (!confirm("您确定要删除这些来访记录吗?,删除后不可恢复")){return false;}
            var ids = $('#grid').yiiGridView('getSelectedRows');
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
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>