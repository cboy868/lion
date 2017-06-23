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
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <?=\app\core\widgets\Ueditor\Ueditor::widget([
                    'name'=>'comment',
                    'option' =>['res_name'=>'memorial'],
                     'jsOptions' => [
                         'toolbars' => [
                             [
                                 'emotion', '|', 'simpleupload'
                             ],
                         ],
                         'initialFrameHeight'=>'100px',
                         'maximumWords' => '10'
                     ]
                ])?>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
            </div>
            <div class="weui-btn-area" style="margin:0;">
                <a class="weui-btn weui-btn_primary" href="javascript:" @click.prevent="comment">送 上 祝 福</a>
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
                    <p class="right" v-text="cm.add_date">{{cm.date}}</p>
                    <h3><a href="#" v-text="cm.username"></a>送上祝福：</h3>
                    <p class="txt" v-html="cm.content"></p>
                </div>
            </li>
        </ul>
    </div>
    <div class="button_load" v-show="pageCount>commentParams.page">
        <a href="javascript:;" @click="pullLoad" class="weui-btn weui-btn_default">加载更多</a>
    </div>
    <!--
    <div class="weui-loadmore weui-loadmore_line" v-show="pageCount==commentParams.page">
        <span class="weui-loadmore__tips">暂无数据</span>
    </div>
    -->
    <div class="weui-loadmore" v-show="loading"> <!--如有需要可增加style="display: none"-->
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载...*\(^_^)/*</span>
    </div>
</div>
<?php $this->beginBlock('memorial') ?>
$(function(){
var id = "<?=Yii::$app->request->get('id');?>";
var uid = '<?=$wechat['user_id']?>';
var app = new Vue({
    el:'#memorial-content',
    data:{
        jisiNum:{candle:1,flower:2},
        jisiData:{uid:uid,id:id},
        jisiUrl: base_url +'memorial/jisi',
        jisiNumUrl: base_url +'memorial/jisi-num',


        commentUrl:base_url +'memorial/comment',
        commentsUrl:base_url +'comment',
        commentParams : {page:1, pageSize:10, res_id:id, res_name:'memorial',avatarSize:'50x50'},
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
            var data = {type:type,id:id,uid:uid};
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
            var content = editor_w0.getContent();
            if (!content) {return;}

            if (editor_w0.getContentLength(true)>10) {$.alert('字符串过长，请修改');return;}
            this.$http.post(this.commentUrl, {content:content,id:id,uid:1},{emulateJSON:true}).then(function(response){
                if (response.data.errno) {
                    $.alert(response.data.error);
                } else {
                    this.$set(this.commentParams, 'page', 1);
                    this.getComments(false);
                }
            }, function(response){

            });
            editor_w0.setContent('');
        },
        getComments(append=false){
            this.$http.jsonp(this.commentsUrl,{'jsonp':'lcb', params:this.commentParams}).then(function (response) {
                if (append) {
                    this.$set(this, 'comments', this.comments.concat(response.data.items));
                } else {
                    this.$set(this, 'comments', response.data.items);
                }

                this.$set(this, 'pageCount', response.data._meta.pageCount);
                this.$set(this, 'loading', 0);
            }).catch(function () {
                
            });
        },
        pullLoad:function(){
            var p = this.commentParams.page + 1;
            if (this.pageCount >= p) {
                this.$set(this.commentParams, 'page', p);
                this.getComments(true);
                this.$set(this, 'loading', 1);
            }
        }
    }

    });
})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>

