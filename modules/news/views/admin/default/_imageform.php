<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\news\models\Category;
use yii\helpers\Url;
use app\core\widgets\Webup\Newsup;
use app\core\models\Attachment;

use app\assets\PluploadAssets;
PluploadAssets::register($this);
\app\assets\ColorBoxAsset::register($this);


?>
<style type="text/css">
.dbox input{
    border: 1px solid #ccc;
    margin-top: 2px;
    padding: 2px;
}
ul.img-box li{
    margin:0 5px;
}

ul.img-box{
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}
</style>
<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('资讯标题<font color="red">(*)</font>')->hint('请为您的资讯起个好听的名字吧') ?>

     <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true])->hint('副标题可以稍长一点') ?>


    <?php 
        $category = Category::find()->where(['status'=>Category::STATUS_NORMAL])->asArray()->all();

        $options = [];
        foreach ($category as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }
    ?>
    <?= $form->field($model, 'category_id')->dropDownList([0=>'默认分类'] + Category::selTree(['status'=>Category::STATUS_NORMAL]),['class'=>'new form-control', 'options' => $options, 'style'=>'width:60%']) ?>
    
    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'style'=>'width:60%'])->label('资讯作者')->hint('不填则默认添加人为作者') ?>

    <?= $form->field($model, 'pic_author')->textInput(['maxlength' => true, 'style'=>'width:60%'])->hint('这里如果不填，则默认图片作者为添加人') ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>


    <?php if (isset($imgs)): ?>
        <ul class="img-box" style="display: block;">
        <?php foreach ($imgs as $k => $img): ?>
            <li style="float:left;width: 150px;" rid="<?=$img->id?>">
                <a href="<?=$img->cover?>" class="artimg" style="height: 120px;display: block; width: 100%;">
                    <img src="<?=$img->getCover('150x120')?>" alt="<?=$img->title?>" style="height: 120px;width: 100%" class="image">
                </a>
                <div class="caption" style="width:100%">
                    <div class="dbox" rel="<?=$img->id?>">
                        <input type="" class="form-group title" name="" value="<?=$img->title?>" style="width:100%">
                        <textarea rows="3" class="form-group desc" placeholder="图片描述" style="width:100%"><?=$img->body?></textarea>
                    </div>
                    <p>
                    <a href="<?=Url::toRoute(['delimg', 'id'=>$img->id])?>" data-confirm="您确定要删除此图片吗？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
                    <?php if ($model->thumb == $img->id): ?>
                        <a href="<?=Url::toRoute(['cover', 'news_id'=>$model->id,'id'=>$img->id])?>" class="btn btn-danger disabled covered">当前封面</a>
                    <?php else: ?>
                        <a href="<?=Url::toRoute(['cover', 'news_id'=>$model->id,'id'=>$img->id])?>" class="btn btn-success cover"><i class="fa fa-flag"></i>设为封面</a>
                    <?php endif ?>
                    
                    </p>
                </div>
            </li>
        <?php endforeach ?>
            <div style="clear: both;"></div>
        </ul>
    <?php endif ?>


    <?php echo Newsup::widget(['options'=>['res_name'=>'news_photo', 'album_id'=>1, 'mod'=>1]]);?>
    
    <?= $form->field($model, 'summary')->textarea(['rows' => 6])->label('图片资讯概要') ?>


	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
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


     $('.title, .desc').change(function(e){
        e.preventDefault();
        var box = $(this).closest('.dbox');

        var title = box.find('.title').val();
        var desc = box.find('.desc').val();
        var id = box.attr('rel');
        var csrf="<?=Yii::$app->request->csrfToken?>";
        $.post("<?=Url::toRoute(['tit-des'])?>", {title:title, desc:desc, id:id, _csrf:csrf}, function(xhr){
            if (xhr.status) {
                box.popover({ placement:'top', content:'修改成功'}).popover('toggle');
            } else {
                box.popover({ placement:'top', content:'修改失败，请重试'}).popover('toggle');
            }
        }, 'json');

    });


    $('body').on('click', '.cover', function(e){
        e.preventDefault();
        var that = this;

        var url = $(this).attr('href');
        var _csrf = $('meta[name=csrf-token]').attr('content');
        $.post(url, {}, function(xhr){
            if (xhr.status) {
                $('.covered').removeClass('covered disabled btn-danger').addClass('cover btn-success').html('<i class="fa fa-flag"></i>设为封面');
                $(that).addClass('disabled covered btn-danger').removeClass('btn-success').html('当前封面');;
            }
        }, 'json');
    })

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  