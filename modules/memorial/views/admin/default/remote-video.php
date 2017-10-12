<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;

$this->title = '远程祭祀记录';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\CkPlayerAsset::register($this);
?>
    <style>
        embed{
            min-height:500px;
        }
    </style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'remote', 'model'=>$memorial])?>
            <div class="col-md-10">
                <div id="a1" style="min-height:500px;"></div>
                <div id="nowTime"></div>
            </div>


        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('cate') ?>
    $(function(){


        var flashvars={
            f:'<?=$remote->video?>',
            c:0,
            i:'/static/images/remote.png',
            h:3,
            my_url:encodeURIComponent(window.location.href),
            my_title:encodeURIComponent(document.title),
        };
        var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always',wmode:'transparent'};
        var video=['<?=$remote->video?>'];
        CKobject.embed('/static/libs/ckplayer6.8/ckplayer/ckplayer.swf','a1','ckplayer_a1','100%','100%',false,flashvars,video,params);

    })
    function ckmarqueeadv(){return ''}//清空广告内容

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>