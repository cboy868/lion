<?php
/**
 * Created by cboy868
 * User: wansq
 * Date: 2017/5/10
 * Time: 13:09
 */
?>

<div id="main-content"><!-- main-content start -->
    <div id="myblog" class="">
        <h2>
            <a href="/home/blog/index">
                <img class="png" src="/theme/m2/static/images/center/my_video_tt.png" alt="我的日志">
            </a>
        </h2>
        <div id="myblog-container">
            <div class="myblog-content">
                <div class="blog-addbox">
                    <h4 class="blog-add">添加视频</h4>
                    <div class="blog-add-area">
                        <?= $this->render('_form', ['model'=>$model,'albums'=>$albums])?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>