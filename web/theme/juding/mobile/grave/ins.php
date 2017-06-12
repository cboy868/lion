<?php
use yii\helpers\Url;

?>
<div class="content" id="ins-box">

    <article class="weui-article">
        <section>
            <h3><?=$model->tomb->tomb_no?>碑文</h3>
            <div>
                <p style="text-align: center">碑前文</p>
                <img src="<?=$model->front?>" alt="">
            </div>
            <div>
                <p style="text-align: center">碑后文</p>
                <img src="<?=$model->back?>" alt="">
            </div>
            <div>
                <a href="javascript:;" v-show="<?=$model->is_confirm?>==0" class="weui-btn weui-btn_plain-default" @click="confirm(<?=$model->id?>)">确认</a>
            </div>
            <div class="weui-loadmore weui-loadmore_line" v-show="<?=$model->is_confirm?>==1">
                <span class="weui-loadmore__tips">您好 本碑文已确认完成</span>
            </div>
        </section>

<!--        <section>-->
<!--            <h3>确认历史</h3>-->
<!--            <div class="weui-panel weui-panel_access zixun_list">-->
<!--                <div class="weui-panel__bd" id="listbox">-->
<!--                    <a href="#" class="weui-media-box weui-media-box_appmsg">-->
<!--                        <div class="weui-media-box__hd">-->
<!--                            <img class="weui-media-box__thumb" src="/static/images/default.bak.png">-->
<!--                        </div>-->
<!--                        <div class="weui-media-box__hd">-->
<!--                            <img class="weui-media-box__thumb" src="/static/images/default.bak.png">-->
<!--                        </div>-->
<!--                        <div class="weui-media-box__bd">-->
<!--                            <h4 class="weui-media-box__title">某区某排1号</h4>-->
<!--                            <p class="weui-media-box__desc">2015/08/01</p>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
    </article>

</div>


<?php $this->beginBlock('news') ?>


var v = new Vue({
    el : '#ins-box',
    data:{
        confirm_url:"<?=Url::toRoute(['confirm-ins'])?>"
    },
    methods: {
        confirm(ins_id){
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var data = {_csrf:csrf,id:ins_id};
            this.$http.post(this.confirm_url, data,{emulateJSON:true}).then(function(response){
                if (response.data.status) {
                    $.toast("碑文确定成功");
                    location.reload();
                } else {
                    $.toast(response.data.info, 'cancel');
                }
            }, function(response){

            });
        }
    }
});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>















