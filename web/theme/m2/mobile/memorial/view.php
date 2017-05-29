<?php
\app\assets\VueAsset::register($this);
?>
<style>
    html body{
        padding-top:10px;
    }
</style>
<link rel="stylesheet" href="/theme/m2/static/mobile/global.css">
<div class="content" id="memorial-content">
    <div class="gradient">
        <!--  <a href="" class="avatar"><img src="/static/images/default/general.gif" alt=""></a> -->
        <a href="" class="avatar">
            <span>
                <img src="<?=$model->getCover('160x160')?>" alt="<?=$model->title?>">
            </span>
        </a>
        <div class="opc_black">
            <div class="btn_group">
                <ul class="clearfix">
                    <li>
                        <a @click.prevent="song('candle')" href="#" data-mid="25590" data-flyimgsrc="/theme/m2/static/modules/memorial/images/ink/ink_candle.png" data-type="type_1" class="tap_state">点烛</a>
                        <p><i v-text="jisi[0].num"></i>次</p>
                    </li>
                    <li>
                        <a @click.prevent="song('flower')" href="#" data-mid="25590" data-flyimgsrc="/theme/m2/static/modules/memorial/images/ink/ink_flower.png" data-type="type_0" class="tap_state">献花</a>
                        <p><i v-text="jisi[1].num"></i>次</p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" placeholder="这里填写您的祝福留言" rows="3" id="comment"></textarea>
<!--                <div class="weui-textarea-counter"><span>0</span>/200</div>-->
            </div>
            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" @click.prevent="comment">发送</a>
            </div>
        </div>
    </div>

    <div class="mess">
        <ul class="comment-list">
            <li class="clearfix" v-for="cm in comments">
                <div class="left">
                    <img :src="cm.avatar">
                </div>
                <div>
                    <p class="right">{{cm.date}}</p>
                    <h3><a href="#" v-model="cm.username"></a>说：</h3>
                    <p class="txt" v-html="cm.content">

                    </p>
                </div>
            </li>
        </ul>
    </div>
</div>

<?php $this->beginBlock('memorial') ?>

$(function(){
var app = new Vue({
    el:'#memorial-content',
    data:{
        jisi:<?=$prays?>,
        jisiUrl:"<?=\yii\helpers\Url::toRoute(['/memorial/m/default/jisi', 'id'=>$model->id])?>",
        commentUrl:"<?=\yii\helpers\Url::toRoute(['/memorial/home/default/comment', 'id'=>$model->id])?>",
        csrf : "<?=Yii::$app->request->getCsrfToken()?>",
        comments:<?=json_encode($comments['list'])?>
    },
    methods:{
        song(type){
            this.$http.post(this.jisiUrl, {type:type,_csrf:this.csrf},{emulateJSON:true}).then(function(response){
                this.$set(this, 'jisi',response.data.data);
            }, function(response){

            });
        },
        comment(){
            var content = $('#comment').val();
            if (!content) {return;}
            this.$http.post(this.commentUrl, {content:content,_csrf:this.csrf},{emulateJSON:true}).then(function(response){
                if (response.data.status) {
                    this.$set(this, 'comments', response.data.data.concat(this.comments));
                }
            }, function(response){

            });
            }
        }
    });
})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>


