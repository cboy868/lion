<?php
use app\core\widgets\ActiveForm;
use app\modules\blog\models\Blog;
use app\core\widgets\Webup\Areaup;
use yii\helpers\Url;
use app\assets\ExtAsset;

ExtAsset::register($this);
?>
<style>
    .form-group{
        margin:10px 0;
    }
    .title{
        padding: 10px;
        width: 80%;
        font-size: 25px;
    }
    .has-error .help-block{
        color:red;
        font-size: 20px;
    }
    .form-group{
        font-size:20px;
    }

    table label{
        font-size:20px;
    }
    #wrapper{
        margin-left:0;
    }
    input.title{
        border: 1px solid #ccc;
    }
    p.title{
        display: none;
    }
    #uploader .filelist li .success{
        bottom:10px;
    }




</style>
<?php $form = ActiveForm::begin(); ?>

<?php


?>
<table style="width: 100%;">
    <tr>
        <td>
        <?= $form->field($model, "title")->dropDownList($albums,[
                'class'=>'selize-rel',
                'prompt' => '请选择相册名称，如新建，请直接输入标题'
            ])->label('相册标题')
            ->hint('如新增，请直接输入相册标题'); ?>
        </td>
    </tr>
    <tr style="display: none;" class="nb">
        <td>
            <div style="float:left;width:150px;margin-top:10px;"><label for="">是否公开</label></div>
            <div style="float:left:width:500px;">
                <?= $form->field($model, 'privacy')->radioList(Blog::privacys())->label(false); ?>
            </div>
        </td>
    </tr>
    <tr style="display: none;" class="nb">
        <td>
            <?php
            $memorials = \app\modules\memorial\models\Memorial::getMemorialsByUser(Yii::$app->user->id);
            $memorials = \yii\helpers\ArrayHelper::map($memorials, 'id', 'title');
            ?>
            <div style="float:left;width:150px;margin-top:10px;"><label for="">关联纪念馆</label></div>
            <div style="float:left:width:500px;">
            <?= $form->field($model, 'memorial_id')->dropDownList($memorials,['prompt'=>'关联纪念馆'])->label(false); ?>
            </div>
        </td>
    </tr>
    <tr style="display: none;" class="nb">
        <td>
            <div style="float:left;width:150px;margin-top:10px;"><label for="">简介</label></div>
            <div style="float:left:width:500px;">
                <?= $form->field($model, 'summary')->textArea(['style'=>'width:98%;height:100px'])->label(false); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo Areaup::widget([
                'options'=>[
                    'res_name'=>'album',
                    'album_id'=>0,
                    'reload'=>false,
                    'server' => Url::toRoute(['album-upload', 'reload'=>false]),
                    'mod'=>false
                ]
            ]);
            ?>
        </td>
    </tr>
    <tr>
        <td class="padding-hook">
            <div class="function-bar">
                <button id="submit-btn" class="cursor submit">发布</button>
<!--                <button id="save-draft-btn" class="cursor save-draft">保存为草稿</button>-->
            </div>
        </td>
    </tr>
</table>


<?php ActiveForm::end(); ?>

<?php $this->beginBlock('cate') ?>
$(function(){
    var albums = "<?=json_encode(array_keys($albums))?>";
    $('.selize-rel').each(function(index, item){
        $(item).selectize({
            create: true
        });
    });

    $('.selize-rel').change(function(){
        var album_id = $(this).val();
        if (albums.indexOf(album_id) == -1) {
            $('.nb').show();
            $('.album_id').val(0);
        } else {
            $('.album_id').val(album_id);
            $('.nb').hide();
        }
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>


