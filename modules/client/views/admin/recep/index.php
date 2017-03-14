<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\client\models\ReceptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = $client->name . '的联系记录';
$this->params['breadcrumbs'][] = ['label' => '客户列表', 'url' => ['/client/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-content">
    <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-success">
            <div class="panel-heading">
                    <?=$client->name?>的基本信息 
            </div>
            <table class="table table-bordered">
               <tbody>
               <tr>
                 <th style="width:8em;">姓名</th>
                 <td><?=$client->name?></td>
                 <th style="width:8em;">性别</th>
                 <td><?=$client->genderText?></td>
               </tr>
               <tr>
                 <th>电话</th>
                 <td><?=$client->mobile?></td>
                 <th>信息来源</th>
                 <td><?=$client->from?></td>
               </tr>
               <tr>
                 <th>地 址</th>

                 <?php 
                    $addr = \app\core\models\Area::getText($client->province_id, $client->city_id, $client->zone_id);
                    $re = $addr .' '. $client->address;
                  ?>
                 <td rowspan="5"><?=$re?></td>
               </tr>
               </tbody>
            </table>
           </div>
        </div>

        <?php foreach ($client->receps as $recep): ?>
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        联系记录 [<code><?=date('Y-m-d H:i', $recep->created_at)?></code>]
                        <?php if ($deals): ?>
                          <small class="pull-right" rid = '<?=$recep->id?>'>
                            <select class="seldeal">
                              <option>选择成交记录</option>
                              <?php foreach ($deals as $k => $deal): ?>
                                <option value="<?=$deal->id?>"><?=$deal->name?></option>
                              <?php endforeach ?>
                            </select>
                          </small>
                        <?php endif ?>
                        
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                           <th style="width:8em;">接待员</th>
                           <td style="width:14em;"><?=$recep->guide->username?></td>
                           <th style="width:8em;">业务员</th>
                           <td style="width:14em;"><?=$recep->agent->username?></td>
                           <th style="width:8em;">联系时间</th>
                           <td>
                               <mark><?=substr($recep->start,0, 16)?></mark> 
                               至
                               <mark><?=substr($recep->end, 0, 16)?></mark>
                           </td>
                        </tr>
                        <tr>
                            <th>原因</th>
                            <td colspan="3">
                                <?=$recep->getReason()?>
                            </td>
                            <th>接待方式</th>
                            <td><?=$recep->gettype()?></td>
                        </tr>
                        <tr>
                           <th>是否成功</th>
                           <td><?=$recep->getIsSuccess()?></td>
                           <th>其他描述</th>
                           <td colspan="3"><?=$recep->note?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach ?>
        <div class="col-sm-12">
            <div class="panel panel-success">
            <div class="panel-heading">
                    新联系记录
            </div>
          <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            </div>
        </div>
        
    </div>
</div>

<?php $this->beginBlock('foo') ?>  
  $(function(){
    $('.seldeal').change(function(e){
      e.preventDefault();

      var recep_id = $(this).closest('small').attr('rid');
      var deal_id = $(this).val();

      var data = {recep_id:recep_id, deal_id:deal_id};

      $.post("<?=Url::toRoute(['/client/admin/recep/deal'])?>",data, function(xhr){
        if (xhr.status) {
          location.reload();
        } else {
          alert(xhr.info);
        }
      }, 'json');
    });
  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  