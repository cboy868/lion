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
                        <p><i v-text="jisiNum.candle"></i>次</p>
                    </li>
                    <li>
                        <a @click.prevent="song('flower')" href="#" data-mid="25590" data-flyimgsrc="/theme/m2/static/modules/memorial/images/ink/ink_flower.png" data-type="type_0" class="tap_state">献花</a>
                        <p><i v-text="jisiNum.flower"></i>次</p>
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
            <div class="weui-btn-area" style="margin:0">
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
        jisiNum:{candle:1,flower:2},
        jisiData:{uid:1,id:1},
        jisiUrl: 'http://api.lion.cn/v1/memorial/jisi',
        jisiNumUrl: 'http://api.lion.cn/v1/memorial/jisi-num',


        commentUrl:'http://api.lion.cn/v1/memorial/comment',
        commentsUrl:'http://api.lion.cn/v1/memorial/comments',
        commentParams : {page:1, pageSize:10, id:1},
        csrf : "<?=Yii::$app->request->getCsrfToken()?>",
        comments:[],
        pageCount:1,
        loading:0
    },
    beforeMount: function() {
        this.jisinum();
        this.getComments();
    },
    methods:{
        song(type){
            var data = {type:type,id:1,uid:1};
            this.$http.post(this.jisiUrl, data,{emulateJSON:true}).then(function(response){
                if (response.data.errno) {
                    $.alert(response.data.error);
                } else {
                    this.jisinum();
                }
            }, function(response){

            });
        },


        jisinum(){
            this.$http.jsonp(this.jisiNumUrl,{'jsonp':'lcb',params:{id:1,type:'candle,flower'}}).then((response) => {
                var d = {};
                var data = response.data;
                for(i in data) {
                    d[data[i].type] = data[i].num
                }
                this.$set(this,'jisiNum', d);
            }, function(response){

            });
        },


        comment(){
            var content = $('#comment').val();
            if (!content) {return;}
            this.$http.post(this.commentUrl, {content:content,id:1},{emulateJSON:true}).then(function(response){
                if (response.data.errno) {
                    $.alert(response.data.error);
                } else {
                    this.getComments(true);
                }
            }, function(response){

            });

            $('#comment').val('');
        },
        getComments(append=false){
            this.$http.jsonp(this.commentsUrl,{'jsonp':'lcb', params:this.commentParams}).then(function (response) {
                if (append) {
                    this.$set(this, 'comments', this.clist.concat(response.data.list));
                } else {
                    this.$set(this, 'comments', response.data.list);
                }
                //this.$set(this, 'pageCount', response.data.pageCount);
               // this.$set(this, 'loading', 0);
            }).catch(function () {
                
            });
        },
    }


    });
})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>

