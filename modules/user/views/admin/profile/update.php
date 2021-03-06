<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;
$this->params['profile_nav'] = 'user';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12 user-index">

            	<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#profile" role="tab" data-toggle="tab">个人信息</a></li>
  <li role="presentation"><a href="#avatar" role="tab" data-toggle="tab">修改头像</a></li>
  <!-- <li role="presentation"><a href="#messages" role="tab" data-toggle="tab">Messages</a></li>
  <li role="presentation"><a href="#settings" role="tab" data-toggle="tab">Settings</a></li> -->
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="profile">
   	<div class="row">
   		<?= $this->render('_form', [
	        'model' => $model,
	        'attach' => $attach,
	    	  'addition' => $addition,
	    ]) ?>
   	</div>
    <div class="hr hr-18 dotted hr-double"></div>
  </div>
  <div role="tabpanel" class="tab-pane" id="avatar">
    
    <p id="swfContainer">
        本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
    </p>

  </div>
  <!-- <div role="tabpanel" class="tab-pane" id="messages">...</div>
  <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
</div>


            	
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
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
            avatar_sizes:'200*200|100*100',//150*150|100*100|45*45
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


















<script type="text/javascript">

















    //   swfobject.addDomLoadEvent(function () {
    //           var swf = new fullAvatarEditor("swfContainer", {
    //         id: 'swf',
    //       upload_url: '/asp/Upload.asp',
    //       src_upload:2
    //     }, function (msg) {
    //       switch(msg.code)
    //       {
    //         case 1 : alert("页面成功加载了组件！");break;
    //         case 2 : alert("已成功加载默认指定的图片到编辑面板。");break;
    //         case 3 :
    //           if(msg.type == 0)
    //           {
    //             alert("摄像头已准备就绪且用户已允许使用。");
    //           }
    //           else if(msg.type == 1)
    //           {
    //             alert("摄像头已准备就绪但用户未允许使用！");
    //           }
    //           else
    //           {
    //             alert("摄像头被占用！");
    //           }
    //         break;
    //         case 5 : 
    //           if(msg.type == 0)
    //           {
    //             if(msg.content.sourceUrl)
    //             {
    //               alert("头像已成功保存至服务器，url为：\n" +　msg.content.sourceUrl);
    //             }
    //             alert("头像已成功保存至服务器，url为：\n" + msg.content.avatarUrls.join("\n"));
    //           }
    //         break;
    //       }
    //     }
    //   );
    //   document.getElementById("upload").onclick=function(){
    //     swf.call("upload");
    //   };
    //       });
    // var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    // document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F5f036dd99455cb8adc9de73e2f052f72' type='text/javascript'%3E%3C/script%3E"));
</script>