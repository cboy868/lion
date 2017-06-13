<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 post-update">
                <?php
                $view = '_' . Yii::$app->request->get('type') . 'form';
                ?>
                <?= $this->render($view, [
                    'model' => $model,
                    'attach'=> $attach,
                    'module' => $module,
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
