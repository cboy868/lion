<?php
use yii\helpers\Url;
?>
<div class="content" id="portrait-box">

    <article class="weui-article">
        <section>
            <h3><?=$tomb->tomb_no?></h3>
            <?php $flag = 1;foreach ($models as $k => $v): ?>
                <?php if($v->status <= \app\modules\grave\models\Portrait::STATUS_CONFIRM) $flag=0;?>
            <div>
                <p style="text-align: center">
                    <?php foreach ($v->deads as $dead):?>
                        <?=$dead['dead_name']?>
                    <?php endforeach;?>
                </p>
                <img src="<?=$v->processedImg?>" alt="">
            </div>
            <?php endforeach;?>
            <div>
                <a v-show="<?=$flag?>==0" href="javascript:;" class="weui-btn weui-btn_plain-default" @click="confirm(<?=$tomb->id?>)">确认</a>
            </div>
            <div class="weui-loadmore weui-loadmore_line" v-show="<?=$flag?>==1">
                <span class="weui-loadmore__tips">您好 本瓷像已确认完成</span>
            </div>
        </section>
    </article>
</div>

<?php $this->beginBlock('news') ?>

var v = new Vue({
    el : '#portrait-box',
    data:{
        confirm_url:"<?=Url::toRoute(['confirm-portrait'])?>"
    },
    methods: {
        confirm(tomb_id){
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var data = {_csrf:csrf,id:tomb_id};
            this.$http.post(this.confirm_url, data,{emulateJSON:true}).then(function(response){
                if (response.data.status) {
                    $.toast("瓷像确定成功");
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
















