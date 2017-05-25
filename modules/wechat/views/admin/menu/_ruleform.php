<?php
use app\modules\wechat\models\MenuMain;
?>


    <div class="panel panel-info">
        <div class="panel-heading">菜单显示规则</div>
        <div class="panel-body">
            <div class="form-group field-menumain-language">
                <label class="control-label" for="">地区</label>
                <div class="">
                    <?php echo \app\core\widgets\Area\Select::widget(['zone_show'=>false]);?>
                </div>
                <div class="help-block"></div>
            </div>

            <?= $form->field($model, 'language')->dropDownList(MenuMain::languages()) ?>

            <?= $form->field($model, 'gender')->dropDownList(MenuMain::genders()) ?>

            <?= $form->field($model, 'client_platform_type')->dropDownList(MenuMain::platform()) ?>
        </div>
    </div>

