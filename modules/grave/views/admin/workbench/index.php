<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;


\app\assets\ExtAsset::register($this);


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

<!-- Modal -->


    <div class="page-content-area">
        <div class="row">

            <div class="col-md-12">
                <div class="page-header">
                    <h4><i class="fa fa-cubes"></i> 业务操作</h4>
                </div>

                <div class="shortcut clearfix">

                    <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal">
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


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">墓位业务</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin();?>

        <?= $form->field($model, 'grave_id')->dropDownList( Grave::selTree(['is_leaf'=>1], 0, ''), ['class'=>'sel-ize selg'])->label(false) ?>

        <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow', 'placeholder'=>'排'])->label(false) ?>

        <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol', 'placeholder'=>'号'])->label(false) ?>

        <div class="form-group">
          <div class="col-md-10">
            <button class="btn btn-primary btn-sm " type="button"><i class="fa fa-search"></i> 预定</button>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> 办理业务</button>
              <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> 续费</button>

              <button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 查找</button>
              <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm modalAddButton']);?>
          </div>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
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