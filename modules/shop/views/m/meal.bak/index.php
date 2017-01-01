<?php 
use app\core\helpers\Url;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\MixRel;

?>
<style type="text/css">
  div.panel a.selected{
    border: 1px solid #ff8a00;
    color: #ff8a00;
    background: white;
    font-size: 14px;
  }
  div.list-block .item-after{
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
  .hide{
    display: none;
  }

  .buttons-row .sel-sku{
    font-size:2rem;
    background-color:#ff8a00;
    color: #fff;
    border:none;
  }
  div.list-block .sku-info{
    margin-top: .5rem;
    margin-bottom: .5rem;
  }
 /* .sel-input{
    height: 1.35rem;
    border-radius: 0;
    border: 1px solid #aaa;
  }*/
  .list-block input[type=number].sel-input{
    height: 1.35rem;
    border-radius: 0;
    border: 1px solid #aaa;
    width: 0;
  }
</style>
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page page-current">
        <div class="content" scroll=no style="overflow:hidden;">
            <div class="buttons-tab hs-orange mytab">
            <p class="buttons-row">
              <?php foreach ($cates as $k => $v): ?>
              <a href="<?=Url::toRoute(['index', 'cate'=>$k])?>" class="<?php if($k==$get['cate']){echo 'active';}?> button external" rel="<?=$k?>"><?=$v['name']?></a>
              <?php endforeach ?>
            </p>  
            <a href="#" style="margin-top:0.5rem;padding-right:0.5rem;color:#fff;font-size:.7rem;" class="pull-right open-panel">
            主料<i class="fa fa-filter"></i>
            </a>

            </div>


            <div class="list-block">
    <ul>
      <li class="item-content">
        <div class="item-media"><i class="icon icon-f7"></i></div>
        <div class="item-inner">
          <div class="item-title">商品名称</div>
          <div class="item-after">杜蕾斯</div>
        </div>
      </li>
      <li class="item-content">
        <div class="item-media"><i class="icon icon-f7"></i></div>
        <div class="item-inner">
          <div class="item-title">型号</div>
          <div class="item-after">极致超薄型</div>
        </div>
      </li>
    </ul>
  </div>
            













            <div class="pointer hs-orange2">
                <span class="hd_icon"></span>
                <marquee class="font14 shop_hd_marq shop_hd_marq2" direction="left" behavior="scroll" scrollamount="2" style="width:82%;margin:0 9%;">
                这是一条测试通知
                <?php foreach ($notes as $k => $v): ?>
                  <span><?=$v['intro']?></span>
                <?php endforeach ?>
                </marquee>
            </div>
              <div class="row no-gutter">

                  <?php $attrs = AvRel::attrs($get['cate'], [3,2]);?>
                  <?php if (count($attrs) > 0): ?>
                    <div class="col-25" style="overflow:scroll;max-height:78vh">
                        <div class="list-block hs-nomargin">

                            <?php foreach ($attrs as $k => $attr): ?>

                              <ul>
                                <li class="list-group-title"><?=$attr['name']?></li>
                                  <?php foreach ($attr['child'] as $key => $val): ?>
                                    <li class="<?php if(isset($get['filter']) && $key == $get['filter']) echo 'active'; ?>" ><a href="<?=Url::toRoute(["index", 'filter'=>$key])?>" class="item-link"><?=$val['val']?></a></li>
                                  <?php endforeach ?>
                              </ul>
                            <?php endforeach ?>
                          

                        </div>
                    </div>


                    <div class="col-75 list-block media-list goods-list" style="margin-top:0;overflow:scroll;max-height:78vh" p='0'>
                  <?php else: ?>
                    <div class="list-block media-list goods-list" style="margin-top:0;overflow:scroll;max-height:78vh" p='0'>
                  <?php endif ?>
                    <ul>
                    <?php foreach ($goods as $k => $v): ?>
                      <li>
                        <div class="item-content">
                          <a href="<?=Url::toRoute(["/shop/default/view", 'id'=>$v['id']])?>" class="item-inner detail" style="width:30%">
                          <?php if ($v['img']): ?>
                            <img src="<?=$v['img']?>" style='width: 4rem;'>
                          <?php endif ?>
                          <div class="item-subtitle"><?=$v['name']?></div>
                          </a>
              
                          <div style="width: 70%;">
                          <?php if ($v['sku']): ?>
                            <?php foreach ($v['sku'] as $sku): ?>
                              <div class="item-after sku-info" goods-id="<?=$v['id']?>" sku-id="<?=$sku['id']?>">
                              <?php if ($sku['av'] == '0:0'): ?>
                                <span class="item-title"><?=$sku['price']?> </span>
                              <?php else: ?>
                                <span class="item-title"><?=$sku['name']?> <?=$sku['price']?> </span>
                              <?php endif ?>
                                <p class="buttons-row">
                                <a href="#" class="button button-warning minus sel-sku">-</a>
                                <input name="num" type="number" class="num hs-input sel-input" style="min-width: 2rem;" value="0" goods-id="<?=$v['id']?>" sku-id="<?=$sku['id']?>" price="<?=$sku['price']?>"/>
                                <a href="#" class="button button-warning plus sel-sku">+</a>
                                </p>
                              </div>
                            <?php endforeach ?>
                          <?php endif ?>
                              
                          </div>
                        </div>
                      </li>
                    <?php endforeach ?>
                    </ul>
                  </div>
            </div>
        </div>

        <div id="food_car" class="center clof pointer hide">
        <span class="left food_car_icon"></span>
        <p class="clof left car_all">￥<span id="price_count"></span></p>
        <p class="font12 left car_copies"><span id="sort_count"></span>样<span id="all_count"></span>份</p>
        <span class="font11 car_btn car_ok" ref="<?=Url::toRoute(['order/cart-create'])?>" rdi="<?=Url::toRoute(['order/cart'])?>">选好了</span>
        </div>
        <nav class="bar bar-tab">
          <a class="tab-item external active" href="<?=Url::toRoute(['default/index'])?>">
            <span class="icon icon-home"></span>
            <span class="tab-label">点餐</span>
          </a>
          <!-- <a class="tab-item external" href="<?=Url::toRoute(['default/seat'])?>">
            <span class="icon icon-star"></span>
            <span class="tab-label">订桌</span>
          </a> -->
         <a class="tab-item external" href="<?=Url::toRoute(['order/cart'])?>">
           <span class="icon icon-cart"></span>
            <span class="tab-label">购物车</span>
          </a>
          <a class="tab-item external" href="<?=Url::toRoute(['default/profile'])?>">
            <span class="icon icon-me"></span>
            <span class="tab-label">我</span>
          </a>
        </nav>
    </div>

    <div class="panel-overlay"></div>
    
    <div class="panel panel-right panel-reveal" id='panel-attr' style="background-color:#fff;color:#333;">
      <?php $attrs = MixRel::rels(Yii::$app->request->get('cate'));
        if ($attrs): 
        ?>
        <?php foreach ($attrs as $k => $attr): ?>
          <dl>
            <dt ><?=$k?></dt>
            <dd>
              <?php foreach ($attr as $key => $val): ?>
                <?=AvRel::attrFilter($val, $k ,$key)?>
              <?php endforeach ?>
            </dd>
          </dl>
        <?php endforeach ?>
      <?php endif ?>
      <div class="content-block">
      <div class="row">
        <div class="col-50"><a href="#" class="button button-fill button-danger close-panel">重置</a></div>
        <div class="col-50"><a href="#" class="button button-fill button-success  filter-ok">确定</a></div>
      </div>
    </div>
    </div>
</div>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<?php $this->registerJsFile('/static/site/sku.js',['position' => \yii\web\View::POS_END]);?>
<?php $this->beginBlock('cart') ?>  
      $(function(){
        //商品数量的加减，购物车中物品处理
        //数量的加减速
        Cart.reloadHtml();

        //数量的增减
        $('body').on('click', '.plus, .minus', function(){

          var obj = $(this).closest('li');
          var goods_id = $(this).closest('div').attr('goods-id');
          var sku_id = $(this).closest('div').attr('sku-id');
          var num = parseInt($(this).siblings('.num').val());
          var price = $(this).siblings('.num').attr('price');
          var title = $(this).siblings('.item-title').text();
          var cover = obj.find('img').attr('src');
          var intro = obj.find('.intro').text();
          var url = obj.find('.detail').attr('href');
          

          num = $(this).hasClass('plus') ? ++num : (num == 0 ? 0 : --num);
          $(this).siblings('.num').val(num);

          Cart.addItem(sku_id, goods_id, num, price, title, url, cover, intro);
          Cart.reloadHtml();

        });

        //选完了
        $('body').on('click', '.car_ok', function(){
          var csrf = $('meta[name="csrf-token"]').attr("content");
          var uri = $(this).attr('ref');
          var redirect = $(this).attr('rdi');

          var items = Cart.getList();
          if (items == '') {
            alert('请选择要购买的菜品');
            return false;
          }

          $.post(uri, {_csrf:csrf, items:items}, function(xhr){
            if (xhr.status) {
              Cart.clear();
              location.href=redirect;
            };
          }, 'json');
        })

        

      })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cart'], \yii\web\View::POS_END); ?>  


<?php $this->beginBlock('filter') ?>  
      $(function(){

        $(".attr-filter").click(function(e){
          e.preventDefault();
          $(this).hasClass('selected') ? $(this).removeClass('selected') : $(this).addClass('selected');;
        });

        $('.filter-ok').click(function(e){
          e.preventDefault();
          var attrs = [];
          $('a.attr-filter').each(function(){
            if($(this).hasClass('selected')) {
              //attrs.push($(this).data('attr')+'_'+$(this).data('av'));
              attrs.push($(this).data('av'));
            }
          });
          var so = attrs.join(',');

          location.href = '<?=Url::toRoute(['/shop/default/index', 'cate'=>$get['cate']])?>' + '&filter='+so;
        });

      })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['filter'], \yii\web\View::POS_END); ?>  
   