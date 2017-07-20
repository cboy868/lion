<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>


                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>


                    <?php  //echo  Html::a('<i class="fa fa-trash"></i> 清除不活跃用户', ['drop'], [
                                //'class' => 'btn btn-danger btn-sm new-menu',
                               // 'data-confirm'=>"此操作不可恢复，请慎重？",
                                //'data-method'=>"post"])
                    ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 user-index">

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
                'headerOptions' => ['width'=>'30', "data-type"=>"html"],
                'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 5, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            'id',
            'username',
            'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('foo') ?>
$(function(){
$('td.deltd').siblings('td').remove();

    $('.btn-delete').click(function(){
        var ids = $('#grid').yiiGridView('getSelectedRows');

        if (ids.length<1) {
            alert('请先选择要删除的账号');
            return;
        }
        if (!confirm("您确定要删除这些账号吗?,删除后不可恢复")){return false;}

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

