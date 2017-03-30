<?php 
use app\core\helpers\Url;
?>
<?php if ($notes): ?>
  <div class="col-xs-12">


  <?php foreach ($notes as $key => $res): ?>
    <div class="item table-responsive" id="describe" loc="loc4">
    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">墓位备注</span>
        <a href="<?=Url::toRoute(['/sys/admin/note/create', 'res_name'=>'tomb', 'res_id'=>Yii::$app->request->get('id')])?>" class="mAddButton btn btn-info btn-xs" onclick="return false">添加备注</a>
    </div>
      <?php foreach ($res as $k => $note): ?>
          <table class="table table-bordered table-condensed table-striped">
                <tbody>

                <tr>
                    <th width="150"><?=$note->user->username?><br> </th>
                    <td class="note">
                        <span>添加时间：<?=date('Y-m-d H:i', $note->created_at)?></span>
                        <a href="<?=Url::toRoute(['/sys/admin/note/update', 'id'=>$note->id])?>" class='mEditButton', onclick="return false">修改</a>
                        <a target="_blank" href="<?=Url::toRoute(['/sys/admin/note/history', 'id'=>$note->id])?>">查看更改记录</a>
                        <p><?=$note->content?></p>
                    </td>
                </tr>                    </tbody>
            </table>
      <?php endforeach ?>
    </div>
  <?php endforeach ?>
        
            
    </div>  
<?php endif ?>
