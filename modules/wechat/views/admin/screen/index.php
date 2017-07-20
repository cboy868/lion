<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = "大屏幕消息管理";
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                大屏幕消息管理
            </h1>
        </div><!-- /.page-header -->

        <div class="col-xs-12">

            <button type="button" class="btn btn-danger btn-sm btn-note" data-toggle="modal" data-target="#note">
                发送通知
            </button>

            <button type="button" class="btn btn-sm btn-success refresh">刷新大屏</button>
            <button type="button" class="btn btn-sm btn-primary stop-push">停止轮动</button>
            <button type="button" class="btn btn-sm btn-primary move-push">动态循环</button>
            <button type="button" class="btn btn-sm btn-primary static-push">消息推动</button>
            <div class="alert alert-success" role="alert">
                <p>状态说明:</p>
                <p>停止:大屏停止轮动，即使有人推送消息，仍然静止。</p>
                <p>动态循环:无论有无新消息，大屏幕始终轮动。</p>
                <p>消息推动:当有新推送消息时，大屏幕显示新消息为最后一条，平时静止。</p>
            </div>
            <!-- <hr /> -->
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 screen-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'id' => 'grid',
        'showFooter' => true,  //设置显示最下面的footer
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30'],
                'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 5, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            [
                'headerOptions' => ['width' => '180'],
                'label' => '发送人',
                'value' => function($model){
                    return '<img src="'.$model->headimgurl.'" width="45" height="45">' . $model->nickname;
                },
                'format' => 'raw'
            ],
             'content:ntext',
            [
                'headerOptions' => ['width' => '80'],
                'label' => '创建时间',
                'value' => function($model){
                    return date('m-d H:i', $model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '120'],
                'template' => '{delete} {msg} {option}',
                'buttons' => [
                    'msg' => function($url, $model, $key){
                            return Html::a('推送到大屏', $url, ['title' => '推送', 'class'=>'push-msg'] );
                    },
                    'option' => function($url, $model, $key){
                        return Html::a('推送并展开', $url, ['title' => '推送', 'class'=>'open-msg'] );
                    },

                ],
            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<!-- Modal -->
<div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">发送通知</h4>
            </div>
            <div class="modal-body">
                <textarea class="note form-control" id='announce' rows='10' placeholder="在此添加通知内容"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary push-announce">确定</button>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('tree') ?>
    $(function () {

$('td.deltd').siblings('td').remove();

        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";

        //批量推送到大屏幕
        $('.push-batch').click(function(e){
            e.preventDefault();
            var ids = [];
            $('.msg:checked').each(function(){
                ids.push($(this).attr('id'));
            });
            if (!ids) { return ;}
            $.post('<?=Url::toRoute(['msg'])?>', {id:ids, _csrf:csrf}, function(xhr){
                if (!xhr.status) {
                } else {
                }
                // alert(xhr.info);
            }, 'json');
        });

        //推送单条消息到大屏幕
        $('.push-msg').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            $.post(url, {_csrf:csrf}, function(xhr){
                if (!xhr.status) {
                }
                alert(xhr.info);
            }, 'json');
        })


        //批量删除
        $('.del-batch').click(function(e){
            e.preventDefault();
            var ids = [];
            $('.msg:checked').each(function(){
                ids.push($(this).attr('id'));
            });
            if (!ids) { return ;}
            var data = {action:'delete',id:ids};
            $.post('/admin/screen/option', data, function(xhr){
                if (xhr.status) {
                    $('.msg:checked').closest('tr').remove();
                }
            }, 'json');
        });

        //停止滚动，并停止接收推送
        $('.stop-push').click(function(e){
            e.preventDefault();
            var url="<?=Url::toRoute(['option'])?>";
            $.post(url, {action:'stop', _csrf:csrf}, function(xhr){
                // alert(xhr.info);
            }, 'json');
        });
        $('.static-push').click(function(e){
            e.preventDefault();
            var url="<?=Url::toRoute(['option'])?>";
            $.post(url, {action:'static',_csrf:csrf}, function(xhr){
                // alert(xhr.info);
            }, 'json');
        });

        //开始滚动并可接收推送
        $('.move-push').click(function(e){
            e.preventDefault();
            var url="<?=Url::toRoute(['option'])?>";
            $.post(url, {action:'start',_csrf:csrf}, function(xhr){
                // alert(xhr.info);
            }, 'json');
        });

        //刷新大屏
        $('.refresh').click(function(e){
            e.preventDefault();
            var url="<?=Url::toRoute(['option'])?>";
            $.post(url, {action:'refresh',_csrf:csrf}, function(xhr){
                // alert(xhr.info);
            }, 'json');
        });

        $('.open-msg').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var data = {action:'open',_csrf:csrf};

            $.post(url, data, function(xhr){

            }, 'json');
        });

        $('.push-announce').click(function(e){
            e.preventDefault()
            var announce = $("#announce").val();
            if (!announce) {alert('请填写公告内容!');return;}
            $.post('<?=Url::toRoute(['announce'])?>', {announce:announce, _csrf:csrf}, function(xhr){
                if (xhr.status) {
                    // location.reload();
                    $('#note').modal('toggle')
                };
            }, 'json');
        });

        $('.btn-delete').click(function(){
            if (!confirm("您确定要删除这些祝福吗?,删除后不可恢复")){return false;}
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
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>





















