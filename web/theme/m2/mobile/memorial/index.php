<?php
$this->title="公开的纪念馆列表";
$wid = Yii::$app->request->get('wid');
?>
<div class="weui-panel weui-panel_access" id="memorial-content">
    <div class="weui-panel__bd">
        <a :href="'/m/memorial/' + m.id + '.html?wid=<?=$wid?>'" class="weui-media-box weui-media-box_appmsg" v-for="m in memorials">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" :src="m.cover" alt="">
            </div>
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title" v-text="m.title"></h4>
                <p class="weui-media-box__desc" v-text="m.intro"></p>
            </div>
        </a>
    </div>

    <div class="button_load" v-show="pageCount>apiParams.page">
        <a href="javascript:;" @click="pullLoad" class="weui-btn weui-btn_default">加载更多</a>
    </div>
    <div class="weui-loadmore" v-show="loading"> <!--如有需要可增加style="display: none"-->
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载...*\(^_^)/*</span>
    </div>
</div>

<?php $this->beginBlock('memorial') ?>
    $(function(){
        var app = new Vue({
            el:'#memorial-content',
            data:{
                memorials:[],
                apiUrl:base_url +'memorial',
                apiParams : {page:1, pageSize:10,thumbSize:'50x50'},
                pageCount:1,
                loading:0
            },
            beforeMount: function() {
                this.getList();
            },
            methods:{
                getList(append=false){
                    this.$http.jsonp(this.apiUrl,{'jsonp':'lcb', params:this.apiParams}).then(function (response) {
                        if (append) {
                            this.$set(this, 'memorials', this.memorials.concat(response.data.items));
                        } else {
                            this.$set(this, 'memorials', response.data.items);
                        }

                        this.$set(this, 'pageCount', response.data._meta.pageCount);
                        this.$set(this, 'loading', 0);
                    }).catch(function () {

                    });
                },
                pullLoad:function(){
                    var p = this.apiParams.page + 1;
                    if (this.pageCount >= p) {
                        this.$set(this.apiParams, 'page', p);
                        this.getList(true);
                        this.$set(this, 'loading', 1);
                    }
                }
            }


        });
    })

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>

