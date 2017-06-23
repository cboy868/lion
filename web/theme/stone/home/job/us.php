<?php
$this->title = '人才招聘';
?>
<div class="inside-focus">
    <img src="<?=$module['logo']?>" alt="人才招聘" />
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置： <a href="/">网站首页</a> &gt
            <a href="#">人才招聘</a>
        </span>
    </div>
    <div class="inside-title">
        <h2 class="en">TALENT RECRUITMENT</h2>
        <h2 class="cn">人才招聘</h2>
    </div>
    <div class="talent wrap">

<?php $article = cmsArticle(5);?>
        <ul class="clearfix talent-body">
            <?php
            if (is_array($article['list']['child'])):
                foreach ($article['list']['child'] as $v):
            ?>
            <li>
                <h2><?=$v['title']?></h2>
                <h3>任职要求：</h3>
                <div class="text">
                    <?=$v['body']?>
                </div>
                <a target="_blank" href="javascript:void(0);" class="more ha" date="<?=date("Y-m-d H:i", $v['created_at'])?>">查看更多</a>
            </li>
            <?php
            endforeach;
            endif;
            ?>
        </ul>
    </div>


    <!-- 弹窗 -->

    <div class="talent-layout">
        <div class="talent-content">
            <a target="_blank" href="javascript:void(0);" class="talent-close">x</a>
            <div class="title">

            </div>
            <div class="body">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.ha').click(function(){
        var id = $(this).data("id");
        var title = $(this).siblings('h2').text();
        var body = $(this).siblings('.text').html();
        var date = $(this).attr('date');

        list= '<h2 >'+title+'</h2>'+'<div class="date">'+date+'</div>';
        $(".title").html(list);
        $(".body").html(body);

    });

</script>