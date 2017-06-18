<?php
$this->title="修补金箔";

?>
<div class="content" id="repair-box">
    <div class="weui-cells">

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">墓位</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="select2">
                    <option value="1">墓位一</option>
                    <option value="2">墓位二</option>
                    <option value="3">墓位三</option>
                </select>
            </div>
        </div>

        <div class="swiper-container" style="height: 300px;">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/theme/site/static/images/s1.png" /></div>
                <div class="swiper-slide"><img src="/theme/site/static/images/s1.png" /></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="weui-cells weui-cells_radio">
            <label class="weui-cell weui-check__label" for="x11">
                <div class="weui-cell__bd">
                    <p>修整碑</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" class="weui-check" name="radio1" id="x11">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            <label class="weui-cell weui-check__label" for="x12">
                <div class="weui-cell__bd">
                    <p>修局部</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" name="radio1" class="weui-check" id="x12" checked="checked">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
        </div>


        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" placeholder="要修哪些字" rows="3"></textarea>
                <div class="weui-textarea-counter"><span>0</span>/200</div>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">费用</label>
            </div>
            <div class="weui-cell__bd">
                <input type="text" disabled="disabled" class="weui-input" value="2000">
            </div>
        </div>
        <div class="weui-cells__tips">费用由系统计算得出，多退少补</div>

        <div class="weui-btn-area">
            <a href="javascript:;" class="weui-btn weui-btn_primary">确定付款</a>
        </div>
    </div>





</div>


<?php $this->beginBlock('news') ?>
    var repair = new Vue({
        el: '#repair-box',
        data: {
        },
        beforeMount: function() {
        },
        mounted:function(){
            var mySwiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: 3000,
                pagination: '.swiper-pagination',
            })
        },
        methods: {
        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>
