<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\cms\models\Category;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公共方法';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 album-index">
        
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          Attachment & AttachmentRel
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				      <h4>use app\core\models\Attachment;</h4>
				      <ul>
				      	<li>
				      		Attachment::getImgByUserId($user_id, $offset=0, $limit=20); 
				      	</li>
				      	<li>
				      		Attachment::getById($id, $type='', $default='')      //$type="200x100"  $default='/upload/abc/ab.png'
				      	</li>
				      	<li>
				      		$attach->getImg($type='');      // $type="200x100"
				      		
				      	</li>
				      </ul>

				      	<hr>
				      	<h4>use app\core\models\AttachmentRel;</h4>
				      	<ul>
				      		<li>
				      			AttachmentRel::updateResId($res_name, $attach_id, $res_id, $res_title='');
				      		</li>
				      		<li>
				      			AttachmentRel::deleteRes($res_name, $res_id, $use, $out_attach_ids); // $out_attach_ids 这些不删除
				      		</li>
				      		<li>
				      			AttachmentRel::getByRes($res_name, $res_id, $type='', $use='', $out = []); // $out除外
				      		</li>
				      		<li>
				      			AttachmentRel::getModels($res_name, $res_id, $type='', $use='') //$type="100x200"
				      			
				      		</li>
				      	</ul>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          Tag & TagRel
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				      <h4>
				      	use app\core\models\Tag;
				      </h4>
				      <ul>
				      	<li>
				      		Tag::getTags($num); //获取若干tag 可用于标签云
				      	</li>
				      </ul>
				      <hr>

				      <h4>use app\core\models\TagRel;</h4>
				      <ul>
				      	<li>
				      		TagRel::getResByTag($tag_name, $res_name);
				      	</li>
				      	<li>
				      		TagRel::getTagsByRes($res_name, $res_id);
				      	</li>
				      	<li>
				      		TagRel::getReleted($res_name, $res_id);
				      	</li>
				      	<li>
				      		TagRel::addTagRel(array $tag_names, $res_name, $res_id);
				      	</li>
				      	<li>
				      		TagRel::delRes($res_id, $res_name, $tag_id);
				      	</li>
				      	<li>
				      		TagRel::addRel($res_id, $res_name, $tag_name);
				      	</li>
				      	<li>
				      		 TagRel::getRes($tag_id);
				      	</li>

				      </ul>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingThree">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				          Category
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				      <div class="panel-body">
				      <h4>
				      	use ......\Category;

				      </h4>
				      	<ul>
				      		<li>
				      			Category::selTree($condition=[], $id=0, $html='--')
				      		</li>
				      	</ul>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingWidget">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseWidget" aria-expanded="false" aria-controls="collapseWidget">
				          Widgets
				        </a>
				      </h4>
				    </div>
				    <div id="collapseWidget" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingWidget">
				      <div class="panel-body">
				      <ul>
				      	<li>
				      		$form->field($model,'body')->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post', 'use'=>'ue'] ]);
				      	</li>
				      	<li>
				      		echo \app\core\widgets\Webup\Webup::widget(['options'=>['res_name'=>'goods', 'id'=>'goods']]);
				      	</li>
				      </ul>
				      </div>
				    </div>
				  </div>
				</div>        
            <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

