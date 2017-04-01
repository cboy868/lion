<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\LinkPager;
?>



<?php if ($goods): ?>
  <div class="panel-group" >
    <?php foreach ($goods as $k => $v): ?>
        <div class="panel panel-default">
            <div class="panel-heading" >
              <h4 class="panel-title">
                <a role="button" >
                  <?=$v->name?>
                </a>
              </h4>

            </div>
            <?php if ($v->sku): ?>
                <div>
                  <table class="table table-striped table-hover table-bordered table-condensed sku-sel">
                      <tbody>
                      <?php foreach ($v->sku as $k => $v): ?>
                          <tr data-rid="<?=$v->id?>" data-name="<?=$v->getName()?>" data-price="<?=$v->price?>" data-gid="<?=$v->id?>">
                            <td><?=$v->name?></td>
                            <td><?=$v->price?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>

                </div>
            <?php endif ?>
        </div>
    <?php endforeach ?>
</div>
<?php 
  echo LinkPager::widget([
      'pagination' => $pagination,
  ]);
?>
<?php else: ?>
  <p>
    没有找到数据
  </p>
<?php endif ?>




