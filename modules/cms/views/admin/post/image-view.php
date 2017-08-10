<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\widgets\ListView;
use app\core\helpers\Url;
use app\core\helpers\StringHelper;

use app\core\widgets\Webup\Areaup;
use app\assets\ColorBoxAsset;
use yii\widgets\LinkPager;


ColorBoxAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Album */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title,'url' => ['index','mid'=>$module->id, 'type'=>'image']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
    .thumbnail.active{
        border:3px solid #8ce;
        background-color: #cde;
    }
    .thumbnail{
        border: 3px solid #ddd;
    }
    .form-group{
        border: 1px solid #999;
        width: 100%;
    }
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small> 上传图片, 拖拽排序</small>
            </h1>
        </div><!-- /.page-header -->

        <ul class="row" id="sortable">

            <?php foreach ($dataProvider->getModels() as $md): ?>
                <li class="col-md-2 col-sm-2 ui-state-default" rel="<?=$md->id?>">
                    <div class="thumbnail <?php if($model->thumb == $md->id):?>active<?php endif;?>">
                        <a href="<?=$md->getImg()?>" class="artimg" style="height: 120px;display: block;">
                            <img src="<?=$md->getImg('380x265')?>" alt="<?=$md->title?>" style="max-height:100%;" class="image">
                        </a>
                        <div class="caption">
                            <!-- <h4><?=StringHelper::truncate($md->title,20)?></h4> -->
                            <div class="dbox" rel = "<?=$md->id?>">
                                <input type="" class="form-group title" name="" value="<?=StringHelper::truncate($md->title,20)?>">
                                <textarea rows="3" class="form-group desc" placeholder="图片描述"><?=$md->desc?></textarea>
                            </div>
                            <p>
                                <a href="<?=Url::toRoute(['del-img', 'id'=>$md->id, 'mid'=>$module->id, 'post_id'=>$md->post_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此图片吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a>
                                <a href="<?=Url::toRoute(['cover', 'post_id'=>$model->id, 'mid'=>$module->id, 'id'=>$md->id])?>" class="btn btn-success cover"><i class="fa fa-flag"></i>封面</a>
                            </p>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            <div class="hr hr-18 dotted hr-double"></div>
        </ul><!-- /.row -->
        <div class="row" style="text-align: right;">
            <?php
            echo LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]);
            ?>
        </div>
        <div class="row">
            <?php echo Areaup::widget(['options'=>[
                    'res_name'=>'album',
                    'album_id'=>$model->id,
                    'server' => Url::toRoute('post-upload'),
                    'mid'=>$module->id]]);
            ?>
        </div>


    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>
    $(function(){
        $('.title, .desc').change(function(e){
            e.preventDefault();
            var box = $(this).closest('.dbox');

            var title = box.find('.title').val();
            var desc = box.find('.desc').val();
            var id = box.attr('rel');
            var csrf="<?=Yii::$app->request->csrfToken?>";
            $.post("<?=Url::toRoute(['/cms/admin/post/tit-des'])?>", {title:title, desc:desc, id:id, _csrf:csrf}, function(xhr){
                if (xhr.status) {
                    box.popover({ placement:'top', content:'修改成功'}).popover('toggle');
                } else {
                    box.popover({ placement:'top', content:'修改失败，请重试'}).popover('toggle');
                }
            }, 'json');

        });

        $(".image").click(function(e) {
            e.preventDefault();
            var title = $(this).attr('title');
            $(".artimg").colorbox({
                rel: 'artimg',
                maxWidth:'600px',
                maxHeight:'700px',
                next:'',
                previous:'',
                close:'',
                current:""
            });
        });

        $( "#sortable" ).sortable({
            update:function(event, ui){
                var ids = [];
                $('#sortable li').each(function(index){
                    var id = $(this).attr('rel');
                    ids.push(id);
                });

                var uri = "<?=Url::toRoute(['sort', 'post_id'=>$model->id])?>";
                var _csrf = $('meta[name=csrf-token]').attr('content');
                $.post(uri, {ids:ids, _csrf:_csrf},function(xhr){
                    if (xhr.status) {
//location.reload();
                    }
                },'json');

            }
        });

        $('.cover').click(function(e){
            e.preventDefault();
            var that = this;

            var url = $(this).attr('href');
            var _csrf = $('meta[name=csrf-token]').attr('content');
            $.post(url, {}, function(xhr){
                if (xhr.status) {
                    $('.thumbnail').removeClass('active');
                    $(that).closest('.thumbnail').addClass('active');
                }
            }, 'json');
        });



    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

