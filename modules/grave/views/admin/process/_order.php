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
                      <td align="left"><?=$rel->title?></td>
                      <td align="left"><?=$rel->price?></td>
                      <td align="left"><?=$rel->num?></td>
                      
                      <td align="left"><?=$rel->user->username?></td>
                      <!-- <td align="center"></td> -->
                      <td align="left"><?=$rel->use_time?></td>
                      <td align="left"><?=$rel->note?></td>
                      <!-- <td align="center"><?=$rel->statusText?></td>   -->
                    </tr> 
                <?php endforeach ?>
            <tbody>
          </table>
      </div>
  </div>
  </div>

<?php endif ?>

