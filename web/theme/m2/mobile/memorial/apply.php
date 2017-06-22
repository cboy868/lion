<?php
$this->title="纪念馆建馆申请";

?>
<div class="content" id="memorial-content">

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">馆名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" v-model="params.title"  type="text" placeholder="请输入纪念馆名称">
            </div>
        </div>
    </div>
    <div class="weui-cells__tips">本墓园购墓纪念馆自动生成，无需申请</div>


    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">安葬位置</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" v-model="params.address" placeholder="安葬位置">
            </div>
        </div>
    </div>
    <div class="weui-cells__tips">安葬在哪个墓园</div>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" placeholder="纪念馆介绍" rows="3" v-model="params.intro"></textarea>
                <div class="weui-textarea-counter"><span>0</span>/200</div>
            </div>
        </div>
    </div>
    <div class="weui-cells__tips">可以是生平介绍等</div>

    <div class="weui-btn-area">
        <a href="javascript:;" class="weui-btn weui-btn_primary" @click="apply">提交申请</a>
    </div>

</div>


<?php $this->beginBlock('memorial') ?>
var wid="<?=Yii::$app->request->get('wid')?>";
var app = new Vue({
    el:'#memorial-content',
    data:{
        apiUrl:base_url +'memorial/apply',
        params : {uid:1},
    },
    beforeMount: function() {
    },
    methods:{
        apply(){
            if(!this.params.title) {$.toptip('纪念馆名称不可为空', 'error');return;}
            if(!this.params.intro) {$.toptip('请输入简介或生平', 'error');return;}
            if(!this.params.address) {$.toptip('请输入安葬地址', 'error');return;}

            this.$http.post(this.apiUrl, this.params,{emulateJSON:true}).then(function(response){

                if (response.body.errno) {
                    $.toast(response.body.error, "error", function() {
                        location.href="/m/user?wid=" + wid;
                    });
                }

                if (response.body == true) {
                    $.toast.prototype.defaults.duration = 3000;
                    $.toast("纪念馆申请完成，等待审核", "success", function() {
                        location.href="/m/user";
                    });
                }
            }, function(response){

            });
        }
    }


});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>

