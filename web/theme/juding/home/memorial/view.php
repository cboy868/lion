<?php
use yii\widgets\LinkPager;
\app\assets\VueAsset::register($this);
?>
<link rel="stylesheet" href="/theme/m2/static/modules/memorial/css/<?=$model->tpl?>.css" type="text/css">
<div id="ink-hook"></div>
<div id="memorial-header">
    <a href="http://gls.gls024.com/home/profile/6003" target="_blank">
        <img src="/theme/m2/static/modules/memorial/images/common/in_btns.png" alt="进入馆主博客">
    </a>
</div>
<div id="memorial-content" class="cort12">

    <div id="memorial-main" class="left">
        <!--  info -->
        <div id="memorial-person" class="clearfix">
            <dl class="memorial-avatarbox left">
                <dt>
                <table style="width:100%;height:100%;border:none;">
                    <tbody><tr style="border:none;">
                        <td style="background-color:white;text-align:center;text-vertical:middle;border:none;">
                            <img src="/theme/m2/static/gls/img/common/general.gif">
                        </td>
                    </tr>
                    </tbody>
                </table>
                </dt>
            </dl>
            <dl class="memorial-info right">
                <dt class="png">
                    <img src="/theme/m2/static/modules/memorial/images/ink/jng_title.png" alt="永安大家庭纪念馆">
                </dt>
                <dd>
                    <?php foreach ($model->deads as $v):?>

                    <div class="pass-list">
                        <p class="pass-name">
                            <span class="fyh20"><?=$v->dead_name?></span>
                        </p>
                        <p><b>生于：</b><?=$v->birth?></p>
                        <p><b>卒于：</b><?=$v->fete?></p>
                        <p><b>享年：</b><?=$v->age?>岁</p>
                        <p><b>生平：</b><?=$v->desc?></p>
                    </div>
                    <?php endforeach;?>
                </dd>
            </dl>
            <div class="memorial_time">
                <div class="det clearfix">
<!--                    <div class="count right">-->
<!---->
<!--                        <table cellpadding="0" cellspacing="0" border="0">-->
<!--                            <tbody><tr>-->
<!---->
<!--                                <td class="txt">距离<span class="size">马桂芹</span>生日还有</td>-->
<!--                                <td class="count_det">1</td>-->
<!--                                <td class="count_det">1</td>-->
<!--                                <td class="count_det">6</td>-->
<!--                                <td class="day">天</td>-->
<!--                                <td class="count_det">0</td>-->
<!--                                <td class="count_det">9</td>-->
<!--                                <td class="hours">小时</td>                  </tr>                  <tr>-->
<!--                                <td class="txt">距离<span class="size">马桂芹</span>福日还有</td>-->
<!--                                <td class="count_det">3</td>-->
<!--                                <td class="count_det">3</td>-->
<!--                                <td class="count_det">1</td>-->
<!--                                <td class="day">天</td>-->
<!--                                <td class="count_det">0</td>-->
<!--                                <td class="count_det">9</td>-->
<!--                                <td class="hours">小时</td>-->
<!--                            </tr>-->
<!---->
<!--                            </tbody></table>-->
<!---->
<!--                    </div>          -->
                    <p class="first">位置：<?=$model->tomb->tomb_no?></p>
                    <p>访问次数：<?=$model->view_all?></p>
                </div>
                <table class="give_count" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th style="text-align: center; font-size: 15px; font-weight: 900;"
                            v-for="(item, index) in jisi"
                            :class="{'bgnone':index==jisi.length-1}">
                            <img :src="'/theme/m2/static/modules/memorial/images/ink/c'+item.type+'.png'" style="display: block;">
                            <span v-text="item.num"></span>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="flower-candle" class="cor12">
            <div class="flower-candlebox clearfix padlr0">
                <input name="flowers" value="0" type="hidden">
                <input name="candles" value="0" type="hidden">
                <div class="bgbox clearfix" style="padding: 0px 16px;">
                    <div class="pray-b send-flowers left marb50">
                        <h4>
                            <a data-type="0" class="pray" href="" @click.prevent="song('flower')" title="我要送花">
                                <img src="/theme/m2/static/modules/memorial/images/ink/send_flower.png" alt="我要送花">
                            </a>
                        </h4>
                        <div class="flower-pic">
                            <img class="png" src="/theme/m2/static/modules/memorial/images/ink/ink_flower.png" alt="我要送花">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                    <div class="pray-b send-candles right marb50">
                        <h4>
                            <a data-type="1" class="pray" href="#" title="我要点蜡" @click.prevent="song('candle')">
                                <img src="/theme/m2/static/modules/memorial/images/ink/send_candle.png" alt="我要点蜡">
                            </a>
                        </h4>
                        <div class="candle-pic">
                            <img class="png" src="/theme/m2/static/modules/memorial/images/ink/ink_candle.png" alt="我要点蜡">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                </div>
                <div class="bgbox clearfix odd" style="padding: 0px 16px;">
                    <div class="pray-b send-flowers left marb50">
                        <h4>
                            <a data-type="2" title="我送早餐" href="javascript:;" class="pray" @click.prevent="song('breakfast')">
                                <img alt="我送早餐" src="/theme/m2/static/modules/memorial/images/ink/give_btn1.png">
                            </a>
                        </h4>
                        <div class="give1">
                            <img alt="我送早餐" src="/theme/m2/static/modules/memorial/images/ink/give1.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                    <div class="pray-b send-candles right marb50">
                        <h4>
                            <a data-type="3" title="我送午餐" href="#" class="pray" @click.prevent="song('lunch')">
                                <img alt="我送午餐" src="/theme/m2/static/modules/memorial/images/ink/give_btn3.png">
                            </a>
                        </h4>
                        <div class="give3">
                            <img alt="我送午餐" src="/theme/m2/static/modules/memorial/images/ink/give3.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                </div>
                <div class="bgbox clearfix" style="padding: 0px 16px;">
                    <div class="pray-b send-flowers left marb50">
                        <h4>
                            <a data-type="4" title="我送晚餐" href="#" class="pray" @click.prevent="song('dinner')">
                                <img alt="我送晚餐" src="/theme/m2/static/modules/memorial/images/ink/give_btn2.png">
                            </a>
                        </h4>
                        <div class="give2">
                            <img alt="我送晚餐" src="/theme/m2/static/modules/memorial/images/ink/give2.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                    <div class="pray-b send-candles right marb50">
                        <h4>
                            <a data-type="5" title="我送棉被" href="#" class="pray" @click.prevent="song('bei')">
                                <img alt="我送棉被" src="/theme/m2/static/modules/memorial/images/ink/give_btn4.png">
                            </a>
                        </h4>
                        <div class="give4">
                            <img alt="我送棉被" src="/theme/m2/static/modules/memorial/images/ink/give4.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                </div>
                <div class="bgbox clearfix odd" style="padding: 0px 16px;">
                    <div class="pray-b send-flowers left marb50">
                        <h4>
                            <a data-type="6" title="我送水果" href="#" class="pray" @click.prevent="song('fruits')">
                                <img alt="我送水果" src="/theme/m2/static/modules/memorial/images/ink/give_btn5.png">
                            </a>
                        </h4>
                        <div class="give5">
                            <img alt="我送水果" src="/theme/m2/static/modules/memorial/images/ink/give5.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                    <div class="pray-b send-candles right marb50">
                        <h4>
                            <a data-type="7" title="我送衣服" href="#" class="pray" @click.prevent="song('clothes')">
                                <img alt="我送衣服" src="/theme/m2/static/modules/memorial/images/ink/give_btn6.png">
                            </a>
                        </h4>
                        <div class="give6">
                            <img alt="我送衣服" src="/theme/m2/static/modules/memorial/images/ink/give6.png" class="png">
                        </div>
                        <ul class="clearfix">
                        </ul>
                    </div>
                </div>
            </div>

            <div id="_tpl_pray" style="display:none;">
                <li>
                    <div class="left">
                        <a href="/theme/m2/static/modules/memorial/images/ink/2931"><img src="http://gls.gls024.com/home/memorial/detail/id/2931" alt=""></a>
                    </div>
                    <h6>
                        <a class="pray-username" href="http://gls.gls024.com/home/memorial/detail/id/2931"></a>
                    </h6>
                    <p class="desc"></p>
                    <p class="time"></p>
                </li>
            </div>
            <!-- candle end -->
            <a name="commentPost"></a>
            <div id="wish-msg" class="corb12">
                <h3>
                    <img src="/theme/m2/static/modules/memorial/images/ink/wish_msg.png" alt="祝福留言">
                </h3>
                <div id="wish-msgbox" class="module-memorial" style="padding-left:10px;">
                    <form action="#" method="post">
                        <p>
                            <label for="contact">发表人：
                                <input type="text" name="contact" id="contact" value="<?=Yii::$app->user->identity->username?>">
                            </label>
                        </p>
                        <?=\app\core\widgets\Ueditor\Ueditor::widget([
                            'name'=>'comment',
                            'id' => 'comment',
                            'jsOptions'=>[
                                'toolbars' => [[
                                    'source', '|', 'undo', 'redo', '|',
                                    'bold', 'italic', 'underline','strikethrough',
                                    'forecolor', 'backcolor',
                                     'insertorderedlist', 'insertunorderedlist', '|',
                                    'fontfamily', 'fontsize', '|',
                                    'indent', '|',
                                    'simpleupload', 'insertimage', 'emotion',

                                ]],
                                'initialFrameHeight' => '200',
                            ],
                            ])?>
                        <p class="submit-box" style="text-align:left;margin-top:10px;">
                            <input id="submit-comment" type="image"
                                   src="/theme/m2/static/modules/memorial/images/ink/publish_msg.png"
                                   alt="发表留言"
                                   @click.prevent="comment"
                            >
                        </p>
                    </form>
                </div>
                <div id="commentList">
                    <ol class="leave-msglist comList" id="comment-box">

                        <li class="clearfix aComment new" style="display:list-item" data-id="" v-for="cm in comments">
                            <a rel="avatar-a" href="#" target="_blank" class="left avatar">
                                <img rel="avatar" alt="#" :src="cm.avatar">
                            </a>
                            <div class="leave-msgbody">
                                <h6>
                                    <span class="ip right">
                                        <span rel="time" class="time">{{cm.date}}</span>
                                    </span>
                                    <!-- -- user ---->
                                    <span>
                                      <a class="green" rel="username" href="#" target="_blank" v-model="cm.username"></a>
                                    </span>说：
                                    <!-- user -->
                                </h6>

                                <div rel="content" class="leave-msgcontent main-comment-content">
                                    <span style="color:#413c29;">
                                        <span style="font-size:14px;">
                                            <span style="font-family:宋体;" v-html="cm.content">
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </li>

                    </ol>

                    <div class="commPager" style="float:right;">
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $comments['pagination'],
                            'nextPageLabel' => '下一页',
                            'prevPageLabel' => '上一页',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '尾页',
                        ]);
                        ?>
                    </div>
                </div>



                <div style="clear:both;margin-bottom:10px"></div>
            </div>
        </div>

    </div>

    <!-- 服务小组 -->
    <div id="memorial-aside" class="right">
        <div id="service-admin" class="corner14">
            <h4 class="cornert12">服务专员动态</h4>
            <!--  -->
            <ol class="clearfix cornerb12">
            </ol>
            <div class="more-box">
            </div>
        </div>

        <!-- 思念文章 -->
        <div id="wish-article" class="corner12">
            <a class="add-btns" href="#" target="_blank">添加文章</a>
            <h4 class="cornert12">思念文章</h4>
            <div class="friendly-tip cornerb12">暂时没有思念文章，点击
                <a class="gray" href="#" target="_blank">此处</a>添加</div>
        </div>

    </div>

    <style type="text/css">
        div.pray-b p.time{text-align:left;}
    </style>
    <div class="clear"></div>
</div>


<?php $this->beginBlock('memorial') ?>

$(function(){
    var app = new Vue({
        el:'#memorial-content',
        data:{
            jisi:<?=$prays?>,
            jisiUrl:"<?=\yii\helpers\Url::toRoute(['/memorial/home/default/jisi', 'id'=>$model->id])?>",
            commentUrl:"<?=\yii\helpers\Url::toRoute(['/memorial/home/default/comment', 'id'=>$model->id])?>",
            csrf : "<?=Yii::$app->request->getCsrfToken()?>",
            comments:<?=json_encode($comments['list'])?>
        },
        methods:{
            song(type){
                this.$http.post(this.jisiUrl, {type:type,_csrf:this.csrf},{emulateJSON:true}).then(function(response){
                    this.$set(this, 'jisi',response.data.data);
                }, function(response){

                });
            },
            comment(){
                var content = editor_comment.getContent();
                if (!content) {return;}
                this.$http.post(this.commentUrl, {content:content,_csrf:this.csrf},{emulateJSON:true}).then(function(response){
                    if (response.data.status) {
                        this.$set(this, 'comments', response.data.data.concat(this.comments));
                    }
                }, function(response){

                });
                editor_comment.setContent('');
            }
        }
    });
})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['memorial'], \yii\web\View::POS_END); ?>



