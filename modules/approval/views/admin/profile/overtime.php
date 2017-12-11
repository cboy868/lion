<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
$this->params['profile_nav'] = 'work';

?>
<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=$this->render('nav')?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-md-12">
                <div class="left-side">
                    <div class="panel panel-sm">
                        <div class="panel-body">
                            <ul class="tree treeview" data-collapsed="true">
                                <li class="active collapsable lastCollapsable"><div class="hitarea active-hitarea collapsable-hitarea lastCollapsable-hitarea"></div>
                                    <a href="/oa/leave-personal-2017.html">2017</a>
                                    <ul style="display: block;">
                                        <li class="active">
                                            <a href="/oa/leave-personal-201712.html" class="">201712</a>
                                        </li>
                                        <li class="last">
                                            <a href="/oa/leave-personal-201711.html" class="">201711</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
