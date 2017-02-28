<?php 

use app\web\theme\site\widgets\Zoom;
use yii\helpers\Url;


$this->title = $data['name'];
?>

<div class="main-container col1-layout home-content-container">
    <ol class="breadcrumb" style="margin-bottom:0;text-align:left;8px 5px 8px 20px;margin:0">
      <li><a href="<?=url(['/'])?>">HOME</a></li>
      <li><a href="<?=url(['/home/product'])?>">PRODUCTS</a></li>
      <li class="active"><?=$data['name']?></li>
    </ol>
    <div class="main home-content">
        <div class="row columns-layout nova-mg-pd">
            <div class="col-main col-md-12 nova-mg-pd">
                <div id="messages_product_view"></div>
                <div class="product-view">
                    <div class="product-essential">
                        <form action="" method="post" id="product_addtocart_form">
                            <div class="no-display">
                                <input type="hidden" name="product" value="1842">
                                <input type="hidden" name="related_product" id="related-products-field" value="">
                            </div>  
                              
                            <div class="row nova-mg-pd">
                                

                                <?php echo Zoom::widget(['imgs'=>$imgs]);?>
                                   
                                <div class="product-shop col-md-7 nova-mg-pd">
                                    <div class="row nova-mg-pd">
                                        <div class="col-md-8 nova-pd-right">
                                            <div class="product-name">
                                                <h1><?=$data['name']?><?=$data['serial']?>
                                                <small><a href="<?=Url::toRoute(['/home/product/msg','id'=>$data['id']])?>" style="font-size: 20px;background: #eee;padding: 5px;" target="_blank">留言咨询</a></small>
                                                </h1>
                                            </div>
                                            
                                               <!-- <p class="email-friend"><a href="/sendfriend/product/send/id/1842/cat_id/163/">Email to a Friend</a></p>-->
                                            <div style="height:20px; width:1px;"></div>      

                                            <ul class="nav nav-tabs" role="tablist">
                                              <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">Description</a></li>
                                              <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">Specifications</a></li>
                                              <li role="presentation"><a href="#messages" role="tab" data-toggle="tab">Installations + Maintenance</a></li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                              <div role="tabpanel" class="tab-pane active" id="home">
                                                    <div class="short-description" style="border-bottom:none;padding:10px">
                                                        <div class="std">
                                                        <?=$data['intro']?>
                                                        </div>
                                                    </div>
                                              </div>

                                              <div role="tabpanel" class="tab-pane" id="profile" style="padding:10px;">
                                                    <table class="data-table" id="product-attribute-specs-table" style="display: block; height: 490px; overflow-y: scroll;">
                                                        <colgroup><col width="40%">
                                                        <col>
                                                        </colgroup>
                                                        <tbody>
                                                                <tr class="first odd">
                                                                    <th class="label">SKU:</th>
                                                                    <td class="data last" style="vertical-align: middle;"><?=$data['serial']?></td>
                                                                </tr>
                                                            <?php foreach ($attr as $k => $v): ?>
                                                                <tr class="first odd">
                                                                    <th class="label"><?=$v['attr_name']?></th>
                                                                    <td class="data last" style="vertical-align: middle;"><?=$v['attr_val']?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                              </div>
                                              <div role="tabpanel" class="tab-pane" id="messages">
                                                <div class="short-description" style="border-bottom:none;padding:10px">
                                                    <?=$data['skill']?>
                                                </div>
                                              </div>
                                            </div>
                                                                        
                                        </div>                
                                    </div>
                                </div>
                            </div>
                            
                        </form>

                    </div>
        
                    <div class="product-collateral row nova-mg-pd">
                        <h2 style="border-bottom: 3px solid #DFDFDF; margin-bottom: 25px;">Products of the Series</h2>    
                        <div>
                            <div class="series-products">
                                <div class="products-grid row list-3col-4 nova-mg-pd" style="padding-bottom: 10px;">

                                <?php foreach ($series as $v): ?>
                                    <div class="item col-md-3 nova-mg-pd">
                                        <div class="nova-product-images"> 
                                            <div class="margin-image">
                                                <a href="<?=url(['/home/product/view', 'id'=>$v['id']])?>" title="<?=$v['name']?>" class="product-image">
                                                <img src="<?=$v['img']?>" alt="<?=$v['name']?>">
                                                </a>
                                            </div>
                                        </div>
                                        <h3 class="product-name"><?=$v['name']?> (SKU:<?=$v['serial']?>)</h3>
                                    </div> 
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


