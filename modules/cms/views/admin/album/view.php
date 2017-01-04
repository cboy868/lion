<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\widgets\ListView;
use app\core\helpers\Url;
use app\core\helpers\StringHelper;

use app\core\widgets\Webup\Areaup;
use app\assets\ColorBoxAsset;

ColorBoxAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Album */

$this->title = $album->title;
$this->params['breadcrumbs'][] = ['label' => $modinfo->name, 'url' => ['index','mod'=>\Yii::$app->getRequest()->get('mod')]];
$this->params['breadcrumbs'][] = $this->title;

$mod = Yii::$app->getRequest()->get('mod');
?>
<style type="text/css">
    .thumbnail.active{
        border:3px solid #8ce;
        background-color: #cde;
    }
    #colorbox{
        z-index: 3;
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

        <?php foreach ($dataProvider->getModels() as $model): ?>
            <li class="col-sm-3 col-md-2 ui-state-default" rel="<?=$model->id?>">
                <div class="thumbnail <?php if($album->thumb == $model->id):?>active<?php endif;?>">
                    <a href="<?=$model->getImg()?>" class="c-img" style="height: 80px;display: block;">
                        <img src="<?=$model->getImg('380x265')?>" alt="<?=$model->title?>" style="max-height:150px;">
                    </a>
                    <div class="caption">
                        <h4><?=StringHelper::truncate($model->title,20)?></h4>
                        <p>
                        <a href="<?=Url::toRoute(['del-img', 'id'=>$model->id, 'mod'=>$mod, 'album_id'=>$model->album_id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此图片吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
                        <a href="<?=Url::toRoute(['cover', 'album_id'=>$album->id, 'mod'=>$mod, 'id'=>$model->id])?>" class="btn btn-success cover"><i class="fa fa-flag"></i>封面</a>
                        </p>
                    </div>
                </div>
            </li>
        <?php endforeach ?>
            <div class="hr hr-18 dotted hr-double"></div>
        </ul><!-- /.row -->

        <div class="row">
              <?php echo Areaup::widget(['options'=>['res_name'=>'album', 'album_id'=>$album->id, 'mod'=>Yii::$app->getRequest()->get('mod')]]);?>
        </div>


    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>  
$(function(){
    $( "#sortable" ).sortable({
        update:function(event, ui){
            var ids = [];
            $('#sortable li').each(function(index){
                var id = $(this).attr('rel');
                ids.push(id);
            });

            var uri = "<?=Url::toRoute(['sort', 'mod'=>$mod, 'album_id'=>$album->id])?>";
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

    $('.c-img').colorbox({slideshow:true,transition:'none',width:"75%", height:"75%"});
    
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  

