<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tab">
<?php if (Yii::$app->getSession()->hasFlash('success')): ?>
     <p class="bg-main" style="padding:15px 20px">
        提示: <?=Yii::$app->getSession()->getFlash('success')?>
    </p>
<?php endif ?>
<?php if (Yii::$app->getSession()->hasFlash('error')): ?>
     <p class="bg-dot" style="padding:15px 20px">
        提示: <?=Yii::$app->getSession()->getFlash('error')?>
    </p>
<?php endif ?>
    <div class="tab-head">
        <strong>个人设置</strong> <span class="tab-more"></span>
        <ul class="tab-nav">
            <li class="active"><a href="#tab-start">基本信息</a> </li>
            <li><a href="#tab-css">头像上传</a> </li>
            <li><a href="#tab-pass">修改密码</a> </li>
        </ul>
    </div>
    <div class="tab-body">
        <div class="tab-panel active" id="tab-start">
            <?= $this->render('_form', [
                'model' => $model,
                'attach' => $attach,
                'addition' => $addition,
            ]) ?>
        </div>
        <div class="tab-panel" id="tab-css">
            <p id="swfContainer">
                本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
            </p>
        </div>

         <div class="tab-panel" id="tab-pass">
             <?= $this->render('_pwd', [
                'model' => $pwd,
            ]) ?>
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



