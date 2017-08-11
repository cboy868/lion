<?php
use app\core\helpers\Url;
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>
<style>
    input, select,textarea{
        font-size: 25px;
        padding: 5px;
    }
    label{
        font-size: 20px;
    }
    .field{
        margin-bottom:10px;
    }
</style>
<div id="main-content">
    <div class="setting">
        <h2>个人设置</h2>
        <!-- 个人设置导航 start -->
        <div class="tab-header">
            <ul class="tabs clearfix">
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/index'])?>">个人设置</a>
                </li>
                <li class="curr">
                    <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>">修改头像</a>
                </li>
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>">修改密码</a>
                </li>
            </ul>
        </div>




        <div class="setting-info">
            <div class="tab-panel" id="tab-css">
                <p id="swfContainer">
                    本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
                </p>
            </div>

        </div>

    </div>
</div>
<script type="text/javascript" src="/static/libs/avatareditor/scripts/swfobject.js"></script>
<script type="text/javascript" src="/static/libs/avatareditor/scripts/fullAvatarEditor.js"></script>

<?php $this->beginBlock('avatar') ?>
$(function(){
swfobject.addDomLoadEvent(function () {
var callback = function (json) {
};
var swf1 = new fullAvatarEditor('swfContainer', 600, 700,{
id: 'swfContainer',
upload_url: "<?=Url::toRoute(['avatar'])?>",
avatar_sizes:'200*200',//|100*100',//150*150|100*100|45*45
avatar_sizes_desc : '150*150像素|100*100像素',//'150*150像素|100*100像素|45*45像素',
}, function(msg){
switch(msg.code)
{
case 5 :
if(msg.type == 0)
{
if(msg.content.avatarUrls) {
$('#avatar-box').find('img').each(function(index, item){
var $this = $(item);
$this.attr('src', msg.content.avatarUrls[index]);
});
alert("头像已成功保存");
}
}
break;
}
});
});
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['avatar'], \yii\web\View::POS_END); ?>



