<?php
use app\core\widgets\ActiveForm;
use app\modules\blog\models\Blog;
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



</style>
<?php $form = ActiveForm::begin(); ?>

<?php


?>
<table style="width: 100%;">
    <tr>
        <td class="padding-hook">
            <?= $form->field($model, 'title')
                ->textInput(['maxlength' => true, 'class'=>'title form-control ','placeholder'=>'请输入博客标题'])
                ->label(false);
            ?>
        </td>
    </tr>
    <tr>
        <td class="padding-hook">
            <?= $form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',[
                'option' =>['res_name'=>'blog', 'use'=>'ue'],
                'value'=>$model->body,
                'jsOptions' => [
                    'toolbars' => [
                        [
                            'source', 'undo', 'redo', '|',
                            'fontsize',
                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                            'forecolor', 'backcolor', '|',
                            'lineheight', 'simpleupload', '|',
                            'indent', '|'
                        ],
                    ]
                ]
            ])->label(false);?>
        </td>
    </tr>
    <tr>
        <td>

            <div style="float:left;width:150px;margin-top:10px;"><label for="">是否公开</label></div>
            <div style="float:left:width:500px;">
                <?= $form->field($model, 'privacy')->radioList(Blog::privacys())->label(false); ?>
            </div>
        </td>
    </tr>
    <tr>
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
