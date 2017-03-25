<div class="col-md-6">
    <div class="page-header">
        <h4><i class="fa fa-cubes"></i> 今日文章</h4>
    </div>
    <ul class="media-list">
      <?php foreach ($models as $k => $model): ?>
        <li class="media">
        <div class="media-left">
          <a href="#">
            <img class="media-object" src="<?=$model->getThumb('48x48')?>" alt="...">
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><a href="#"><?=$model->title?></a></h4>
          <p>
            <?=$model->summary?>...
          </p>
        </div>
      </li>
      <?php endforeach ?>
    </ul>
</div>