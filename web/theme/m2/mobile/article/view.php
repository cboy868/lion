<?php
$this->title="业务帮助须知";
?>
<div class="content" id="news-box">
    <article class="weui-article">
        <h1 class="sst_article" v-text="item.title"></h1>
        <div class="sst_article_meta" v-text="item.created_at"></div>
        <section v-html="item.body"></section>
    </article>
</div>

<?php $this->beginBlock('news') ?>
    var demo = new Vue({
        el: '#news-box',
        data: {
            item: [],
            sendData:{mid:<?=$mid?>,id:<?=$id?>},
            apiUrl: 'http://api.lion.cn/v1/post/view',
        },
        beforeMount: function() {
            this.getNews();
        },
        methods: {
            getNews: function() {
                this.$http.jsonp(this.apiUrl,{'jsonp':'lcb',params:this.sendData}).then((response) => {
                    var item = response.data;
                item.created_at = this.goodTime(item.created_at * 1000);
                this.$set(this, 'item', item);
            }).catch(function(response) {
                    console.log(response)
                })
            },
            goodTime: function(str){
                var now = new Date().getTime(),
                    oldTime = new Date(str).getTime(),
                    difference = now - oldTime,
                    result='',
                    minute = 1000 * 60,
                    hour = minute * 60,
                    day = hour * 24,
                    halfamonth = day * 15,
                    month = day * 30,
                    year = month * 12,

                    _year = difference/year,
                    _month =difference/month,
                    _week =difference/(7*day),
                    _day =difference/day,
                    _hour =difference/hour,
                    _min =difference/minute;
                if(_year>=1) {result= "发表于 " + ~~(_year) + " 年前"}
                else if(_month>=1) {result= "发表于 " + ~~(_month) + " 个月前"}
                else if(_week>=1) {result= "发表于 " + ~~(_week) + " 周前"}
                else if(_day>=1) {result= "发表于 " + ~~(_day) +" 天前"}
                else if(_hour>=1) {result= "发表于 " + ~~(_hour) +" 个小时前"}
                else if(_min>=1) {result= "发表于 " + ~~(_min) +" 分钟前"}
                else result="刚刚";
                return result;
            }
        }
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['news'], \yii\web\View::POS_END); ?>

