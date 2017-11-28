<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\Html;
\app\assets\ExtAsset::register($this);

$this->title = '厨师工作台';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-header">

        <h1>
            <?=$mess[$now_mess]?><?=$types[$now_type]?>
            <span class="red">【日期：<?=$date?>】</span>
        </h1>
    </div>


    <?php
    Modal::begin([
        'header' => '点餐',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <?php
    Modal::begin([
        'header' => '点菜详情',
        'id' => 'modalEdit',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="editContent"></div>';

    Modal::end();
    ?>

    <div class="row">
        <div class="col-xs-10">
            <?=\app\core\widgets\Alert::widget()?>
        </div>
        <div class="col-xs-10">
            <div class="search-box search-outline">
                菜单日期
                <input type="text" dt="true" value="<?=$date?>" class="date_sel">
            </div>
            <div>
                <h5 style="font-weight:900;color:blue;">未订餐的人：</h5>
                <ul class="list-inline">
                    <?php foreach ($not as $v):?>
                    <li style="width:6em;"><?=$v->user->username;?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <hr>

            <?php if($receptions):?>
            <table class="table table-bordered table-condensed table-hover">
                <caption>
                    接待用餐
                </caption>
                <thead>
                <tr>
                    <th width="120">
                        接待人
                    </th>
                    <th>客户</th>
                    <th>来访时间</th>
                    <th>
                        <table style="margin:-1px 0px 0px 0px;" class="table table-condensed intable">
                            <thead>
                            <tr>
                                <th>                                用餐时间
                                </th>
                                <th>菜品</th>
                                <th width="50">数量</th>
                                <th width="50">单价</th>
                                <th width="50">合计</th>
                                <th width="50">操作</th>
                            </tr>
                            </thead>
                        </table>
                    </th>
                    <th width="70">总计</th>
                    <td width="50">操作</td>
                </tr>
                </thead>
                <tbody id="order-day-info">
                <?php foreach ($receptions as $reception):?>
                    <tr>
                        <td class="middle-center">
                            <?=$reception->user->username;?>
                        </td>
                        <td>
                            <?=$reception->reception_customer?>
                        </td>
                        <td>
                            <?=$reception->day_time?>
                        </td>
                        <td style="padding:0px;" class="sub-box">
                            <table style="margin:-1px 0px 0px 0px;" class="table table-condensed table-hover">
                                <tbody>
                                <?php $total=0;$fg=0;foreach ($reception_menus[$reception->id] as $mu):?>
                                    <?php
                                    if (!$mu->is_over) {
                                        $fg = 1;
                                    }
                                    ?>
                                    <tr class="<?=$mu->orderColor()?>" data-is-over="1">
                                        <td class="blue2"><?=$mu->menu->name?></td>
                                        <td width="50" class="blue text-center"><?=$mu->num?>份</td>
                                        <td width="50" class="green text-right">
                                            <?=$mu->real_price?>元
                                        </td>
                                        <td width="50" class="red text-right">
                                            <?=$t=$mu->real_price * $mu->num?>元
                                        </td>
                                        <td width="50" style="text-align: right">
                                            <a class="btn btn-default btn-xs drop"
                                               href="<?=Url::toRoute(['drop', 'id'=>$mu->id])?>">
                                                <i class="fa fa-times red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $total+=$t;endforeach;?>
                                </tbody>
                            </table>
                        </td>
                        <td class="middle-center"><strong><?=$total?>元</strong></td>
                        <td class="middle-center">
                            <?php if ($fg && $date==date('Y-m-d')):?>
                                <a class="btn btn-default btn-xs take-reception"
                                   href="<?=Url::toRoute(['take-reception','reception_id'=>$reception->id,
                                       'date'=>$date,
                                       'type'=>$now_type,
                                       'mess_id'=>$now_mess])?>">
                                    <i class="red fa fa-check-circle-o"></i>
                                    领 取
                                </a>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <?php endif;?>


            <table class="table table-bordered table-condensed table-hover">
                <caption>
                    用户订餐信息,可输入用户名、全拼、或首字母进行查找
                </caption>
                <thead>
                <tr>
                    <th width="120">
                        <input class="form-control input-sm py_search" type="text"
                               name="username" value=""
                               placeholder="可输入拼音或首字母">
                    </th>

                    <th>
                        <table style="margin:-1px 0px 0px 0px;" class="table table-condensed intable">
                            <thead>
                            <tr>
                                <th>菜品</th>
                                <th width="50">数量</th>
                                <th width="50">单价</th>
                                <th width="50">合计</th>
                                <th width="50">操作</th>
                            </tr>
                            </thead>
                        </table>
                    </th>
                    <th width="70">总计</th>
                    <td width="50">操作</td>
                </tr>
                </thead>
                <tbody id="order-day-info">
                <?php if (isset($menus[0])): ?>
                    
                
                <?php foreach ($menus[0] as $menu):?>
                    <?php $cuser = current($menu);?>
                <tr class="menu-tr"
                        data-pinyin="<?=$cuser->user->py?>"
                        data-title="<?=$cuser->user->username?>"
                >
                    <td class="middle-center">
                        <?=$cuser->user->username;?>
                    </td>
                    <td style="padding:0px;" class="sub-box">
                        <table style="margin:-1px 0px 0px 0px;" class="table table-condensed table-hover">
                            <tbody>
                            <?php $total=0;$fg=0;foreach ($menu as $mu):?>
                                <?php
                                $user_id = $mu->user_id;
                                if (!$mu->is_over) {
                                    $fg = 1;
                                }
                                ?>
                            <tr class="<?=$mu->orderColor()?>" data-is-over="1">
                                <td class="blue2"><?=$mu->menu->name?></td>
                                <td width="50" class="blue text-center"><?=$mu->num?>份</td>
                                <td width="50" class="green text-right">
                                    <?=$mu->real_price?>元
                                </td>
                                <td width="50" class="red text-right">
                                    <?=$t=$mu->real_price * $mu->num?>元
                                </td>
                                <td width="50" style="text-align: right">
                                    <a class="btn btn-default btn-xs drop"
                                       href="<?=Url::toRoute(['drop', 'id'=>$mu->id])?>">
                                        <i class="fa fa-times red"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $total+=$t;endforeach;?>
                            </tbody>
                        </table>
                    </td>
                    <td class="middle-center"><strong><?=$total?>元</strong></td>
                    <td class="middle-center">
                        <?php if ($fg && $date==date('Y-m-d')):?>
                        <a class="btn btn-default btn-xs take"
                           href="<?=Url::toRoute(['take','user_id'=>$user_id,
                               'date'=>$date,
                               'type'=>$now_type,
                               'mess_id'=>$now_mess])?>">
                            <i class="red fa fa-check-circle-o"></i>
                            领 取
                        </a>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php endif ?>

                <?php if (isset($menus[0])): ?>
                    <?php foreach ($menus[1] as $menu):?>
                        <?php $cuser = current($menu);?>
                        <tr class="menu-tr"
                            data-pinyin="<?=$cuser->user->py?>"
                            data-title="<?=$cuser->user->username?>"
                        >
                            <td class="middle-center">
                                <?=$cuser->user->username;?>
                            </td>
                            <td style="padding:0px;" class="sub-box">
                                <table style="margin:-1px 0px 0px 0px;" class="table table-condensed table-hover">
                                    <tbody>
                                    <?php $total=0;foreach ($menu as $mu):?>
                                        <tr class="<?=$mu->orderColor()?>" data-is-over="1">
                                            <td class="blue2"><?=$mu->menu->name?></td>
                                            <td width="50" class="blue text-center"><?=$mu->num?>份</td>
                                            <td width="50" class="green text-right">
                                                <?=$mu->real_price?>元
                                            </td>
                                            <td width="50" class="red text-right">
                                                <?=$t=$mu->real_price * $mu->num?>元
                                            </td>
                                            <td width="50" style="text-align: right">
                                                <a class="btn btn-default btn-xs drop"
                                                   href="<?=Url::toRoute(['drop', 'id'=>$mu->id])?>">
                                                    <i class="fa fa-times red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $total+=$t;endforeach;?>
                                    </tbody>
                                </table>
                            </td>
                            <td class="middle-center"><strong><?=$total?>元</strong></td>
                            <td class="middle-center"></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
        <div class="col-xs-2">
            <div class="btn-group-vertical" role="group" style="display: block">
                <?php foreach ($mess as $k => $m):?>
                    <?php foreach ($types as $key => $t):?>
                        <a class="btn btn-xs <?php if($k==$now_mess && $key==$now_type){echo 'btn-primary';} else{echo'btn-default';}?>"
                           href="<?=Url::toRoute(['index','mess_id'=>$k,'type'=>$key,'date'=>$date])?>">
                    <i class="fa fa-glass"></i><?=$m.$t?>
                        </a>
                    <?php endforeach;?>
                <?php endforeach;?>
            </div>

            <table class="table table-bordered table-condensed" style="margin-top:10px;">
                <tbody>
                <tr>
                    <td class="danger text-center"><small>未领取</small></td>
                </tr>
                <tr>
                    <td class="success text-center"><small>已领取</small></td>
                </tr>
                <tr>
                    <td class="info text-center"><small>临时订餐</small></td>
                </tr>
                </tbody>
            </table>

            <?=  Html::a('<i class="fa fa-plus"></i> <span class="h4" style="font-weight: 900">点 餐</span>',
                ['order', 'mess_id'=>$now_mess,'type'=>$now_mess,'date'=>$date],
                [
                    'class' => 'btn btn-info btn-block btn-lg modalAddButton',
                    'data-loading-text'=>"页面加载中, 请稍后...",
                    'onclick'=>"return false"
                ])
            ?>

            <style>
                ul.list-inline a{
                    color:#666;
                }
                .table > tbody > tr > td.middle-center{
                    text-align:center;
                    vertical-align:middle;
                }
                .intable > thead > tr > th{
                    border-bottom:0;
                }
            </style>
            <div style="padding:0.5em;">
                <ul class="list-inline">
                    <?php foreach ($result as $v):?>
                    <li>
                        <a href="<?=Url::toRoute(['view','mess_id'=>$now_mess,'date'=>$date,'type'=>$now_type,'menu_id'=>$v['menu_id']])?>"
                           class='modalEditButton'
                           data-loading-text="页面加载中, 请稍后..."
                           onclick="return false">
                            <span class="blue"><?=$v['menu_name']?>
                                <span class="red"><?=$v['cnt'] - $v['over']?>/<?=$v['cnt']?></span>份
                            </span>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('img') ?>
$(function(){
    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
    $('.date_sel').change(function(){
        var date = $(this).val();
        location.href="<?=Url::toRoute(['index'])?>?date="+date;
    });

    $('.drop').click(function(e){
        e.preventDefault();
        if (!confirm('确定要删除此菜单吗?')) {return false;}

        var href = $(this).attr('href');
        var that = this;
        $.post(href,{_csrf:csrf},function(xhr){
            if(xhr.status) {
                location.reload();
               //$(that).closest('tr').remove();
            } else {
                alert(xhr.info);
            }
        },'json')
    });

    $('.take').click(function(e){
        e.preventDefault();
        if (!confirm('确定领取吗?')) {return false;}

        var href = $(this).attr('href');
        var that = this;
        $.post(href,{_csrf:csrf},function(xhr){
            if(xhr.status) {
                location.reload();
                //$(that).remove();
            } else {
                alert(xhr.info);
            }
        },'json')
    });

    $('.take-reception').click(function(e){
        e.preventDefault();
        if (!confirm('确定领取吗?')) {return false;}

        var href = $(this).attr('href');
        var that = this;
        $.post(href,{_csrf:csrf},function(xhr){
            if(xhr.status) {
                location.reload();
            } else {
                alert(xhr.info);
            }
        },'json')
    });


    var pyh;
    var trs = $('tr.menu-tr');
    $('.py_search').keyup(function(e){ //拼音查找
        var $this = $(e.target);
        var pystr = $.trim($this.val());

        if (pystr == '') {
            trs.fadeIn(100);
            return;
        }
        if (typeof pyh != undefined ) {
            clearTimeout( pyh );
        }
        pyh = setTimeout(function(){
            trs.each(function(i, item){
                var trElem = $(item);
                var pinyin = trElem.data('pinyin');
                var title = trElem.data("title");
                try {
                    if (pinyin.indexOf(pystr) !=-1 || title.indexOf(pystr) != -1) {
                        trElem.fadeIn(100);
                    } else {
                        trElem.fadeOut(100);
                    }
                } catch (err) {
                    trElem.hide();
                }
            });
        }, 500);
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
