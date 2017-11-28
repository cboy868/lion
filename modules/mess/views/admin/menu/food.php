<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\modules\mess\models\MessMenu;
\app\assets\SelectizeAsset::register($this);
\kartik\select2\ThemeDefaultAsset::register($this);
\kartik\select2\Select2Asset::register($this);

$all = MessMenu::find()->where(['<>', 'status', MessMenu::STATUS_DEL])->all();
$sel = ArrayHelper::map($all, 'id', 'name');
$price = json_encode(ArrayHelper::map($all, 'id', 'default_price'));


$staffs = \app\modules\user\models\User::staffs();
$users = ArrayHelper::map($staffs, 'id', 'username');

\app\assets\ExtAsset::register($this);
?>
<style>
    .select2-container--krajee .select2-selection{
        -webkit-border-radius:0;
        -moz-border-radius:0;
        border-radius:0;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12 mess-day-menu-index">

                <form method="post" action="<?=Url::toRoute(['food', 'id'=>Yii::$app->request->get('id')])?>">
                    <input name="_csrf" type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <input type="hidden" name="menu_id" value="<?=$menu->id?>">
                    <table class="table table-bordered menu-list-box">
                        <caption>
                            食材选择
                        </caption>
                        <tr>
                            <th>食材</th>
                            <th>数量</th>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::dropDownList('food_id[]',
                                    null,
                                    $foods,
                                    [
                                        'class'=>'selmenu form-control',
                                        'prompt'=>'请选择菜品'
                                    ])?>
                            </td>
                            <td width="100">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger btn-minus" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </span>
                                        <input data-id=""
                                               data-title=""
                                               data-price=""
                                               class="form-control mnum"
                                               name="num[]" type="text"
                                               style="padding:4px 3px;width:50px"
                                               value="0">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-plus" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-info pull-right" type="submit">保 存</button>

                </form>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<div>
<?php $this->beginBlock('img') ?>

$(function(){
    $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";

    $('.selmenu').select2();

    $('body').on('change', '.selmenu', function () {
        var price = JSON.parse('<?=$price?>');
        var id = $(this).val();

        var delid = $(this).closest('tr').attr('rid');
        try {
            var price = price[id];
        } catch (err) {
            var price = 0;
        }

        $(this).closest('tr').find('.price').text(price);
        $(this).closest('tr').attr('rid', id);

        if(delid){
            return ;
        }

        var selObj = $(this);

        selObj.select2('destroy');
        var copy =selObj.parents('tr').clone();
        $(this).parents('table').append(copy);
        selObj.select2();
        copy.find('.real_price').val('');
        copy.attr('rid',null);
        copy.find('.selmenu').select2();
    });


    var menuListBox = $('.menu-list-box');
    // 商品页面加减数量
    menuListBox.on('click', 'button.btn-minus,button.btn-plus', function(e){
        e.preventDefault();

        var $this = $(this);
        var menuItem = $this.parents('tr');
        var target = menuItem.find('.mnum');
        var val = parseInt(target.val());
        var old_val = val;
        if ($this.hasClass('btn-minus')) {
            if (val > 0) {
                target.val(--val);
            }
        } else{
            target.val(++val);
        }
        //target.trigger('change');
    });


   
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
