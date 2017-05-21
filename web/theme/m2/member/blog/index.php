<?php
use yii\widgets\LinkPager;
use app\core\helpers\Url;
use app\core\helpers\Html;
?>
<link rel="stylesheet" href="/theme/m2/static/css/profile.css">
   <div id="main-content" class="plus-width-hook"><!-- main-content start -->
        <div id="myblog" class="">
            <h2>
                    日志
            </h2>
            <div id="myblog-container">
                <div class="myblog-content left">
                    <ol>
                        <?php foreach ($list as $v):?>
                        <li>
                            <div class="myblog-hdskin">
                                <h6>
                                    <a href="<?=Url::toRoute(['/blog/member/default/view', 'id'=>$v['id']])?>">
                                        <?=$v['title']?></a>
                                </h6>
                                <div class="blog-t-tool">
                                    <div class="blog-msg">
                                        <span class="time"><?=date('Y-m-d H:i', $v['created_at'])?> 发表</span>
                                    </div>
                                    <?php if ($v->isOwn()):?>
                                        <div class="toolbar">
                                            <span class="cursor edit-blog">
                                                <a href="<?=Url::toRoute(['/blog/member/default/update', 'id'=>$v['id']])?>">编辑</a>
                                            </span>
                                            <span><img src="/theme/m2/static/images/blog/v_dotted.png" alt=""></span>
                                            <span class="cursor del-myblog">
                                                <a id="delete-68" class="delete-btn" href="<?=Url::toRoute(['/blog/member/default/del', 'id'=>$v['id']])?>">删除</a>
                                            </span>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="myblog-body">
                                <?= Html::cutstr_html($v['body'], '100')?>
                            </div>
                            <div class="myblog-foot">
                                <a href="#">阅读(<?=$v['view_all']?>)</a>
                                <span>|</span>
                                <a href="#">评论(<?=$v['com_all']?>)</a>
                            </div>
                        </li>
                        <?php endforeach;?>
                    </ol>
                    <div style="text-align:center">
                        <ul class="pagination">
                            <?php
                            echo LinkPager::widget([
                                'pagination' => $pagination,
                                'nextPageLabel' => '下一页',
                                'prevPageLabel' => '上一页',
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',
                            ]);
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div><!-- main-content end -->
<script>
    $('.delete-btn').click(function(e){
        e.preventDefault();
        if (!confirm('确定要删除此博客吗？')) { return false;}
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
        var url = $(this).attr('href');
        var that = this;
        $.post(url,{_csrf:csrf},function(xhr){
            if (xhr.status) {
                $(that).closest('li').remove();
            } else {
                alert(xhr.info);
            }

        }, 'json')
    });
</script>