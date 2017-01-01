<?php


use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use app\core\helpers\Url;


use app\modules\focus\models\Focus;
use app\modules\cms\models\Links;

//  按格式打印数组
function p($arr)
{
    // header("Content-type:text/html;charset=utf-8");
    echo '<pre>'.print_r($arr,true).'</pre>';
}

function getFullAction()
{
	$app = Yii::$app->id;
	$m = Yii::$app->controller->module->id;
	$c = Yii::$app->controller->id;
	$a = Yii::$app->controller->action->id;

	$currentPermission = str_replace('admin/', '', $m .'/'. $c .'/'. $a);

	return $currentPermission;
}

function focus($category_id, $limit, $imgSize=null)
{
	return Focus::getFocusByCategory($category_id, $limit, $imgSize);
}

function postList($mod, $category_id=0, $rows)
{
	$class = '\app\modules\cms\models\mods\Post' . $mod;

	$list = $class::find()->where(['category_id'=>$category_id])->limit($rows)->asArray()->all();
	$post_ids = ArrayHelper::getColumn($list, 'id');

	$dataClass = '\app\modules\cms\models\mods\PostData' . $mod;
	$datas = $dataClass::find()->where(['post_id'=>$post_ids])->indexBy('post_id')->asArray()->all();

	foreach ($list as &$v) {
		$v['body'] = $datas[$v['id']]['body'];
		$v['thumb'] = Attachment::getById($v['thumb'],'200x200');
		$v['url'] = Url::toRoute(['about/view', 'mod'=>$mod, 'id'=>$v['id']]);
	}unset($v);

	return $list;
}

function postDetail($mod, $id)
{
	$class = '\app\modules\cms\models\mods\Post' . $mod;
	$dataClass = '\app\modules\cms\models\mods\PostData' . $mod;

	$post = $class::findOne($id)->toArray();
	$data = $dataClass::findOne($id)->toArray();
	return array_merge($post, $data);
}

function links($rows)
{
	$list = Links::find()->asArray()->all();
	return $list;
}