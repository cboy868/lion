<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\bootstrap\Modal;
use app\assets\ContextMenuAsset;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '食材';
$this->params['breadcrumbs'][] = $this->title;
ContextMenuAsset::register($this);
?>

<style type="text/css">
ul.user-list {
    margin: 0px;
    padding: 0px;
    list-style: none;
    font-size: 14px;
    padding: 10px 20px;
    border: 1px #ccc dashed;
}
ul.user-list li {
    float: left;
    width: 5em;
    border: 1px solid white;
    margin: 5px;
    padding: 3px;
    cursor: pointer;
}
ul.user-list li.selected {
    background-color: #E0DF95;
}
.pinyin{cursor: pointer;}
ul, ol, li {
    list-style: none;
}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">

            <div class="col-xs-12">
                <small class="pull-right">
                    <a href="<?=Url::toRoute(['/admin/shop/mix-cate'])?>" class="btn bg-info">食材分类</a>
                </small>

                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>

            </div>

            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php foreach ($cates as $k => $v): ?>
                        <a href="#<?=$k?>"><?=$v?></a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="col-xs-12">
                <?php foreach($mix as $k=>$v): ?>
                    <h5 id="<?=$k?>"> <?=$cates[$k]?></h5>
                    <ul class="mix-list">
                        <?php foreach($v as $key=>$val): ?>
                        <span class="mix" rel="<?=$val['id']?>">
                            <?=$val['name']?>,
                        </span>
                        <?php endforeach;?>
                        <div>
                            <input placeholder="新增食材" class="add-mix" data-cate="<?=$k?>"/>
                            <button class="btn btn-info btn-add">确定</button>
                        </div>
                        
                        <div style="clear:both"></div>
                    </ul>
                    <hr>
                <?php endforeach;?>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('add') ?>  
$(function(){
    var csrf = $('meta[name="csrf-token"]').attr('content');

    $('.btn-add').click(function(e){
        e.preventDefault();
        var that = this;
        var cate = $(this).siblings('.add-mix').data('cate');
        var name = $(this).siblings('.add-mix').val();
        var csrf = $('meta[name="csrf-token"]').attr('content');
        var url = "<?=Url::toRoute(['add'])?>";
        $.post(url, {mix_cate:cate, name:name,_csrf:csrf},function(xhr){
            if (xhr.status) {
                var html = "<span class='mix' rel='"+xhr.data.id+"'>"+name+",</span>";
                $(that).closest('div').before(html);
            }
        },'json');
    });

    $.contextMenu({
        selector: '.mix',
        trigger: 'right',
        callback: function(key, options) {
            var id = $(this).attr('rel');
            if (key=='edit') {
                var val = $.trim($(this).text());
                val = val.substring(0, val.length-1);
                var html = '<input name="mix" value="'+val+'"><button class="btn btn-info btn-edit">确定</button>';
                $(this).html(html);
            }
            if (key=='delete') {
                var url = "<?=Url::toRoute(['del'])?>";
                var that = this;
                $.post(url, {id:id}, function(xhr){
                    if (xhr.status) {
                        $(that).remove();
                    }
                }, 'json');
            }
        },
        items: {
            "edit": {name: "编辑", icon: "edit"},
            "delete": {name: "删除", icon: "delete"},
        }
    });

    $('body').on('click', '.btn-edit', function(e){
        e.preventDefault();
        var name=$(this).siblings('input').val();
        var id = $(this).closest('span').attr('rel');
        var url = "<?=Url::toRoute(['edit'])?>";
        var that = this;
        $.post(url, {id:id,name:name,_csrf:csrf}, function(xhr){
            if (xhr.status) {
                $(that).closest('span').text(name);
            } else {
                alert(xhr.info);
                location.reload();
            }
        }, 'json');
    })
})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['add'], \yii\web\View::POS_END); ?>  

