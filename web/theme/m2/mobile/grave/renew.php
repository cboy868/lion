<?php
$this->title="维护费";

?>
<div class="content" id="renew">
    <div class="weui-cells">

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">墓位</label>
            </div>
            <div class="weui-cell__bd">





                <select class="weui-select" name="select2" v-model="selected" @change="selTomb">
                    <option v-for="tomb in tombs" v-bind:value="tomb.id" v-text="tomb.tomb_no"></option>
                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">续费时长</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="select2" v-model="nums" @change="selTomb">
                    <option value="1">1期(20年)</option>
                    <option value="2">2期(40年)</option>
                    <option value="3">3期(60年)</option>
                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">费用</label>
            </div>
            <div class="weui-cell__bd">
                <input type="text" disabled="disabled" class="weui-input" v-model="renewPrice">
            </div>
        </div>

        <div class="weui-btn-area">
            <a href="javascript:;" class="weui-btn weui-btn_primary" @click="buy">确定付款</a>
        </div>

    </div>

</div>


<?php $this->beginBlock('news') ?>
    var demo = new Vue({
        el: '#renew',
        data: {
            selected:0,
            uid:1,
            nums:1,
            renewPrice:0,
            tombs: [],
            sendData:{uid:1,expand:'card,renew_fee'},
            apiUrl: 'http://api.lion.cn/api/v1/tomb',
            renewUrl: 'http://api.lion.cn/api/v1/tomb/renew'
        },
        beforeMount: function() {
            this.ts();
        },
        methods: {
            ts: function () {
                this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.sendData}).then((response) => {
                    if (response.body.errno == 1) {
                        $.toast(response.body.error, "error", function() {
                            location.href="/m/user";
                        });
                    }
                    this.$set(this, 'tombs', response.data.items)
                    this.$set(this, 'selected', response.data.items[0].id)
                    this.selTomb();

                }).catch(function(response) {
                    console.log(response)
                })
            },
            selTomb:function(){
                var tombs = this.tombs;
                for(i in tombs){
                    if (tombs[i].id == this.selected) {
                        this.renewPrice = tombs[i].price * tombs[i].renew_fee * this.nums;
                    }
                }
            },
            buy:function(){
                var data={id:this.selected,num:this.nums,uid:this.uid};

                this.$http.post(this.renewUrl, data,{emulateJSON:true}).then(function(response){

                    if (response.body.errno) {
                        $.toast(response.body.error, "error", function() {
                            location.href="/m/user";
                        });
                    }


                    if (response.body.order.id) {
                        $.toast.prototype.defaults.duration = 3000;
                        $.toast("订单已生成，正在为您跳转到支付页面", "success", function() {
                            location.href="/m/order/" + response.body.order.id;
                        });
                    }
                }, function(response){

                });
            }

        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>
