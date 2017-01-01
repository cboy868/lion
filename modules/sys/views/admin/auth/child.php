<?php
use yii;
use app\core\helpers\Html;
use app\core\helpers\Url;

$this->title = '添加删除子角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">角色</h3>
                    </div>
                    <div class="panel-body">
                        <select class="form-control" id="roleselect" size='18'>
                            <?php foreach ($roles as $k => $v):?>
                                <option value="<?=$v->name ?>"><?=$v->description?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">分配权限
                            <div class="pull-right">
                                <span class="badge badge-danger">添加<<>>删除</span>
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-5">
                            <select class="form-control" id="child" multiple="multiple" size='22'>

                            </select>
                        </div>
                        <div class="col-sm-1" style="margin-top:100px;">
                            <div class="btn-group btn-group-vertical">
                                <button class="btn btn-info handel" rel="add"><i class='fa fa-angle-double-left'></i></button>
                                <button class="btn btn-info handel" rel="del"><i class='fa fa-angle-double-right'></i></button>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" id="other" multiple="multiple" size='22'>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->


<?php $this->beginBlock('auth') ?>  
$(function(){
    $('#roleselect').change(function(){
        var role = $(this).val();
        selectRole(role)
    });

    $('.handel').click(function(){
        var rel = $(this).attr('rel');
        var url = "<?=Url::toRoute('/sys/rbac/role-child');?>";
        var role = $('#roleselect').val();
        var csrf = $('meta[name=csrf-token]').attr('content');
        if (rel=='add') {
            var val = $('#other').val();
        } else {
            var val = $('#child').val();
        };

        $.post(url, {method:rel, _csrf:csrf, child:val,role:role}, function(xhr){
            $('input[name=csrf]').val(xhr.csrf);
            if (xhr.status) {
                selectRole(role);
            };
        }, 'json');
        

    });
});

function selectRole(role){
    var url = "<?=Url::toRoute('/sys/rbac/get-child');?>" + '&rolename='+role;
    $.get(url, null, function(xhr){
        if (xhr.status) {
            $('#child').html(xhr.data.child);
            $('#other').html(xhr.data.other);
        };
    },'json');
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  



