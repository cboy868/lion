<?php
use app\modules\wechat\models\MenuMain;
use app\modules\wechat\models\Tag;
?>


    <div class="panel panel-info">
        <div class="panel-heading">菜单显示规则</div>
        <div class="panel-body">

            <?= $form->field($model, 'tag')->dropDownList(Tag::tags($this->context->wid), ['prompt'=>'按标签分组菜单'])
                                            ->label('所属标签组')
            ?>

            <div class="form-group field-menumain-language">
                <label class="control-label" for="">地区</label>
                <div class="">
                    <?php echo \app\core\widgets\Area\Select::widget([
                            'zone_show'=>false,
                            'pro_name' => 'MenuMain[province]',
                            'city_name'=> 'MenuMain[city]',
                            'pro' => $model->province,
                            'city' => $model->city

                    ]);?>
                </div>
                <div class="help-block"></div>
            </div>

            <?= $form->field($model, 'language')->dropDownList(MenuMain::languages()) ?>

            <?= $form->field($model, 'gender')->dropDownList(MenuMain::genders()) ?>

            <?= $form->field($model, 'client_platform_type')->dropDownList(MenuMain::platform()) ?>
        </div>
    </div>

