<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\helpers\Url;
use app\modules\mess\models\MessMenu;
use yii\helpers\ArrayHelper;

$this->title = $model->reception_customer . '用餐安排';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = ['label' => '接待记录', 'url' => ['/mess/admin/reception/index']];
$this->params['breadcrumbs'][] = $this->title;

$all = MessMenu::find()->where(['<>', 'status', MessMenu::STATUS_DEL])->all();
$sel = ArrayHelper::map($all, 'id', 'name');
$price = json_encode(ArrayHelper::map($all, 'id', 'default_price'));

\app\assets\ExtAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    接待人:<?=$model->user->username;?>,
                    客户:<?=$model->reception_customer?>,
                    人数<?=$model->reception_number?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-sm-3">
                <div style="color: #999;padding-top: 8px;padding-bottom: 8px;">菜单日期</div>
                <div class="search-box search-outline">
                    <input type="text" dt="true" value="<?=$date?>" class="date_sel form-control">
                </div>
            </div>
            <div class="col-sm-9 order-list">
                <table class="table table-bordered table-condensed">
                    <caption class="red text-left"><strong>今 日 订 餐 [ 2017-11-22 ]</strong></caption>
                    <thead>
                    <tr>
                        <th>食堂</th>
                        <th>类型</th>
                        <th>菜品</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>合计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="order-list">
                        <?php $total=0;foreach ($self_menus as $m):?>
                            <tr class="<?=$m->id?>">
                                <td><?=$m->mess->name?></td>
                                <td><?=$types[$m->type]?></td>
                                <td class="blue"><?=$m->menu->name?></td>
                                <td class="green"><?=$m->num?></td>
                                <td class="red"><?=$m->real_price?></td>
                                <td><?php echo $m->num * $m->real_price?></td>
                            </tr>

                            <?php $total+=$m->num*$m->real_price;endforeach;?>
                    </div>
                    <tr>
                        <td colspan="5">合 计</td>
                        <td><code>¥<?=$total?></code></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <?php foreach ($mess as $k=>$v):?>
                <div class="col-xs-6 menu-list-box" >
                    <h3 class="header smaller lighter red"><?=$v?></h3>

                    <?php foreach ($types as $key=>$type):?>
                        <table class="table table-bordered table-hover" data-mess_id="<?=$k?>" data-type="<?=$key?>">
                            <caption class="text-left">
                                <strong><?=$type?></strong>
                            </caption>
                            <thead>
                            <tr>
                                <th style="width:200px;">菜单名称</th>
                                <th>单价</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <?php
                            if (isset($menus[$k][$key])):
                                foreach ($menus[$k][$key] as $menu):
                                    ?>
                                    <tr>
                                        <td><?=$menu->menu->name?></td>
                                        <td class="red">¥<?=$menu->real_price?></td>
                                        <td width="100">
                                            <?php if($date>=date('Y-m-d')):?>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger btn-minus" type="button">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </span>
                                                    <input data-id="<?=$menu->id?>"
                                                           data-title="<?=$menu->menu->name?>"
                                                           data-price="<?=$menu->real_price?>"
                                                           class="form-control mnum"
                                                           name="value" type="text"
                                                           value="<?=isset($self[$k][$key][$menu->id]->num) ? $self[$k][$key][$menu->id]->num : 0?>"
                                                           style="padding:4px 3px;width:50px" value="0">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn-plus" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </table>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
            <div class="hr hr-18 dotted hr-double"></div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('img') ?>
    $(function(){
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
        $('.date_sel').change(function(){
            var date = $(this).val();
            location.href="<?=Url::toRoute(['view','id'=>$model->id])?>&date="+date;
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
            target.trigger('change');
        });



        $('.mnum').change(function(){
            var num = $(this).val();
            var id = $(this).data('id');

            $.post("<?=Url::toRoute(['create-menu', 'id'=>$model->id])?>", {id:id,num:num,_csrf:csrf},function(xhr){
                if(xhr.status){
                    $('.order-list').load("<?=Url::toRoute(['list', 'date'=>$date, 'id'=>$model->id])?>");
                } else {
                    alert(xhr.info);
                }
            },'json');
        });

    })
    <?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>