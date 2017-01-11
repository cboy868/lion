<?php


use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use app\core\helpers\Url;
use app\core\helpers\StringHelper;


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

/**
 * @name 取焦点图
 */
function focus($category_id, $limit, $imgSize=null)
{
	return Focus::getFocusByCategory($category_id, $limit, $imgSize);
}

/**
 * @name 取文章列表 
 */
function postList($mod, $category_id=0, $rows=null)
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

	$model = $class::findOne($id);
	$model->view_all += 1;
	$model->save();
	$post = $model->toArray();
	$data = $dataClass::findOne($id)->toArray();

	return array_merge($post, $data);
}

function links($rows)
{
	$list = Links::find()->asArray()->all();
	return $list;
}

function url($params)
{
	return Url::toRoute($params);
}

function g($name)
{

	return Yii::$app->params[$name];
}

function utf8_strlen($string = null) {
     // 将字符串分解为单元
    preg_match_all("/./us", $string, $match);
     // 返回单元个数
    return count($match[0]);
}
/**
 * @name 截取 
 */
function truncate($string, $length, $suffix = '...', $encoding = null, $asHtml = false)
{
	return StringHelper::truncate($string, $length, $suffix, $encoding, $asHtml);
}

function defaultImg()
{
	return '/static/images/default.png';
}
