<?php
$this->title="已购买的墓位";
?>
<div class="weui-panel weui-panel_access" id="tomb-content">
    <div class="weui-panel__bd">
        <a :href="'/m/grave/tomb/' + m.id + '.html'" class="weui-media-box weui-media-box_appmsg" v-for="m in tombs">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" :src="m.cover" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title" v-text="m.tomb_no"></h4>
                <p class="weui-media-box__desc" v-text="m.note"></p>
            </div>
        </a>
    </div>
</div>

<?php $this->beginBlock('memorial') ?>
    var wid="<?=Yii::$app->request->get('wid')?>";
    var uid = '<?=$wechat['user_id']?>';
    $(function(){
        var app = new Vue({
            el:'#tomb-content',
            data:{
                tombs:[],
                apiUrl:base_url +'tomb',
                apiParams : {thumbSize:'50x50',uid:uid},
            },
            beforeMount: function() {
                this.getList();
            },
            methods:{
                getList(append=false){
                    this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.apiParams}).then(function (response) {
                        if (response.body.errno) {
                            $.toast.prototype.defaults.duration = 3000;
                            $.toast(response.body.error, "error", function() {
                                location.href="/m/user?wid=" + wid ;
                            });
                        }
                        this.$set(this, 'tombs', response.data.items);
                    }).catch(function () {

                    });
                }
            }
        });
    })

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>

