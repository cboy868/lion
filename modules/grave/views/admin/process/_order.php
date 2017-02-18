<?php if ($order): ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-info dead">
           <div class="dhandler panel-heading">订单情况</div>
           <table class="table table-striped table-hover table-bordered table-condensed" style="text-align:center">
              <tr>
                  <th align="center">名称</th>
                  <th align="center">总价</th>
                  <th align="center">数量</th>
                  <th align="center">下单用户</th>
                  <!-- <th align="center">操作员</th> -->
                  <th align="center">使用时间</th>
                  <!-- <th align="center">状态</th>  -->
                  <th align="center" width="200">备注</th>
                  <!-- <th align="center"></th>  -->
                </tr>
                <?php foreach ($order->rels as $rel): ?>
                    <tr>
                      <td align="center"><?=$rel->title?></td>
                      <td align="center"><?=$rel->price?></td>
                      <td align="center"><?=$rel->num?></td>
                      <td align="center"><?=$rel->user->username?></td>
                      <!-- <td align="center"></td> -->
                      <td align="center"><?=$rel->use_time?></td>
                      <td align="center"><?=$rel->note?></td>
                      <!-- <td align="center"><?=$rel->statusText?></td>   -->
                      <td></td>  
                    </tr> 
                <?php endforeach ?>
            <tbody>
          </table>
      </div>
  </div>
  </div>

<?php endif ?>

