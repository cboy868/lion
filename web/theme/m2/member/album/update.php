<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 13:57
 */
?>

<div id="main-content"><!-- main-content start -->
    <div id="myblog" class="">
        <h2><a href="/home/blog/index"><img class="png" src="/theme/m2/static/images/blog/my_blog_tt.png" alt="我的日志"></a></h2>
        <div id="myblog-container">
            <div class="myblog-content left">
                <div class="blog-addbox">
                    <h4 class="blog-add">修改日志</h4>
                    <div class="blog-add-area">
                        <?= $this->render('_form', ['model'=>$model])?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
