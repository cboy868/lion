<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

$this->title = '多语言翻译';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .source-message-index textarea{
        width:100%;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <a href="<?=Url::to(['create'])?>" class='btn btn-primary btn-sm modalAddButton' title="添加源"
                       data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加源</a>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '新增源语言',
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
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-xs-12 source-message-index">
                <table class="table table-striped table-bordered">

                    <tr >
                        <th width="150">分类</th>
                        <th width="200">源语言</th>
                        <?php foreach ($languages as $k => $lg):?>
                            <th><?=$lg?></th>
                        <?php endforeach;?>
                        <th width="30">
                            操作
                        </th>
                    </tr>
                    <?php foreach ($dataProvider->getModels() as $k => $v): ?>
                        <tr>
                            <td><?=$v->category?></td>
                            <td><?=$v->message?></td>
                            <?php foreach ($languages as $k => $lg):?>
                                <td>
                                    <textarea class="lg"
                                              rows="3"
                                              lg="<?=$k?>"
                                              rid="<?=$v->id?>"
                                    ><?=isset($trans[$v->id][$k]['translation']) ?$trans[$v->id][$k]['translation']:'' ?></textarea>
                                </td>
                            <?php endforeach;?>
                            <td>
                                <a href="<?=Url::toRoute(['update', 'id'=>$v->id])?>" class="modalEditButton">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="<?=Url::toRoute(['delete', 'id'=>$v->id])?>"
                                   data-confirm="您确定要删除此项吗？"
                                   data-method="post">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <div>
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $dataProvider->getPagination(),
                    ]);
                    ?>
                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('auth') ?>
$(function(){
    $('.lg').change(function(){
        var csrf = "<?=Yii::$app->getRequest()->getCsrfToken()?>";
        var val = $(this).val();
        var rid = $(this).attr('rid');
        var lg = $(this).attr('lg');
        var url = "<?=Url::toRoute(['translate'])?>";

        $.post(url, {_csrf:csrf,id:rid,language:lg,translation:val},function(xhr){
            if (xhr.status) {

            } else {
                alert();
            }

        },'json');

    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>

