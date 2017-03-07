<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

use yii\bootstrap\Modal;

$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .task .btns{
        display: none;
    }
</style>

<div class="page-content">
    <!-- /section:settings.box -->

    <?php 
        Modal::begin([
            'header' => '快捷操作',
            'id' => 'modalAdd',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
    ?>
    <div class="page-content-area">
        <div class="row">

            <div class="col-md-12">
                <div class="page-header">
                    <h4><i class="fa fa-cubes"></i> 业务操作</h4>
                </div>

                <div class="shortcut clearfix">
                    <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
                        <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                        墓位业务
                        <!-- <span class="badge badge-pink">+3</span> -->
                    </a>

                    <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
                        <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                        这业务
                        <!-- <span class="badge badge-pink">+3</span> -->
                    </a>

                    <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
                        <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                        那业务
                        <!-- <span class="badge badge-pink">+3</span> -->
                    </a>

                    <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
                        <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
                        ok业务
                        <!-- <span class="badge badge-pink">+3</span> -->
                    </a>

                </div>
                

            </div>

            <div class="col-md-6 task">
                <div class="page-header">
                    <h4><i class="fa fa-cubes"></i> 今日工作</h4>
                </div>
                <ul class="media-list">
                  <li class="media">
                    <div class="media-body">
                      <h4 class="media-heading">1､列表组是灵活又强大的组件 <small class="btns"><a href="#" class="pull-right btn btn-xs btn-info btn-ok">ok</a><a href="#" class="pull-right btn btn-xs btn-del btn-danger">del</a></small></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-body">
                      <h4 class="media-heading">2､列表组是灵活又强大的组件<small class="btns"><a href="#" class="pull-right btn btn-xs btn-info">ok</a><a href="#" class="pull-right btn btn-xs btn-danger">del</a></small></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>


                  <li class="media">
                    <div class="media-body">
                      <h4 class="media-heading">3､列表组是灵活又强大的组件<small class="btns"><a href="#" class="pull-right btn btn-xs btn-info">ok</a><a href="#" class="pull-right btn btn-xs btn-danger">del</a></small></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-body">
                      <h4 class="media-heading">4､列表组是灵活又强大的组件<small class="btns"><a href="#" class="pull-right btn btn-xs btn-info">ok</a><a href="#" class="pull-right btn btn-xs btn-danger">del</a></small></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-body">
                      <h4 class="media-heading">5､列表组是灵活又强大的组件<small class="btns"><a href="#" class="pull-right btn btn-xs btn-info">ok</a><a href="#" class="pull-right btn btn-xs btn-danger">del</a></small></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>
                </ul>
            </div>

            <div class="col-md-6">
                <div class="page-header">
                    <h4><i class="fa fa-cubes"></i> 今日文章</h4>
                </div>
                <ul class="media-list">
                  <li class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object" src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="#">列表组是灵活又强大的组件</a></h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object" src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">列表组是灵活又强大的组件</h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>


                  <li class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object" src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">列表组是灵活又强大的组件</h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object" src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">列表组是灵活又强大的组件</h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>

                  <li class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object" src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">列表组是灵活又强大的组件</h4>
                      <p>
                        一部分内容，列表组是灵活又强大的组件，不仅能用于显示一组简单的元素，还能用于复杂的定制的内容
                      </p>
                    </div>
                  </li>
                </ul>
            </div>
            
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
    
   $('.task li').mouseover(function(){
    $('.btns', this).show();
   });
   $('.task li').mouseleave(function(){
    $('.btns', this).hide();
   });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  