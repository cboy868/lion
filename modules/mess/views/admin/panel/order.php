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

                <form method="post" action="<?=Url::toRoute(['order', 'type'=>$type,'mess_id'=>$mess_id,'date'=>$date])?>">
                    <input name="_csrf" type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <div class="form-group field-goods-serial">
                        <label class="control-label">订餐人</label>
                        <?=Html::dropDownList('user_id',
                            null,
                            $users,
                            [
                                'class'=>'seluser form-control',
                                'prompt'=>'请选择订餐账号'
                            ])?>
                    </div>
                    <table class="table table-bordered menu-list-box">
                        <caption>
                            菜单选择
                        </caption>
                        <tr>
                            <th>菜品</th>
                            <th>单价</th>
                            <th>数量</th>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::dropDownList('menu_id[]',
                                    null,
                                    $sel,
                                    [
                                        'class'=>'selmenu form-control',
                                        'prompt'=>'请选择菜品'
                                    ])?>
                            </td>
                            <td class="price">
                            0.00
                            </td>
                            <td width="100">
                                <?php if($date>=date('Y-m-d')):?>
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
                                <?php endif;?>
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
    $('.date_sel').change(function(){
        var date = $(this).val();
        location.href="<?=Url::toRoute(['index'])?>?date="+date;
    });

    $('.selmenu').select2();
    $('.seluser').select2();

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


    $('.mnum').change(function(){
        var num = $(this).val();
        var id = $(this).data('id');

<!--        $.post("--><?//=Url::toRoute(['create'])?><!--", {id:id,num:num,_csrf:csrf},function(xhr){-->
<!--            if(xhr.status){-->
<!--                $('.order-list').load("--><?//=Url::toRoute(['list', 'date'=>$date])?><!--");-->
<!--            } else {-->
<!--                alert(xhr.info);-->
<!--            }-->
<!---->
<!--        },'json');-->
    });

//    $('.real_price').change(function () {
//        var price = $(this).val();
//        var id = $(this).closest('tr').attr('rid');
//
//        if (!id || !price) {
//            return ;
//        }
//        var that = this;
//
//        $.post("<?//=Url::toRoute(['price'])?>//",{id:id,price:price,_csrf:csrf},function(xhr){
//            if (!xhr.status) {alert(xhr.info)}
//            else{$(that).closest('tr').find('.note_price').show();}
//
//        },'json');
//
//    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
