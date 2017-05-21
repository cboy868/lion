<?php


use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use app\core\helpers\Url;
use app\core\helpers\StringHelper;


use app\modules\focus\models\Focus;
use app\modules\cms\models\Links;
use app\modules\cms\models\Subject;
use app\modules\mod\models\Code;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\news\models\News;
use app\modules\news\models\Category as NewsCategory;
use app\core\models\TagRel;
use app\modules\memorial\models\Memorial;
use app\modules\blog\models\Blog;
//  按格式打印数组
function p($arr)
{
     header("Content-type:text/html;charset=utf-8");
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
 * @param null $category_id
 * @param int $limit
 * @param $thumb
 */
function news($category_id=null, $limit=10, $thumb=null, $type=null)
{

    $query = News::find()->where(['status'=>News::STATUS_NORMAL]);
    if ($category_id !== null) {
        $query->andWhere(['category_id'=>$category_id]);
    }

    if ($type !== null) {
        $t = array_search($type, News::types());
        $query->andWhere(['type'=>$t]);
    }
    $list = $query->limit($limit)->all();

    $result = [];

    foreach ($list as $k => $v) {
        $result[$v['id']] = $v->toArray();
        $result[$v['id']]['cover'] = $v->getCover($thumb);
    }

    return $result;
}


/**
 * @return array
 */
function newsCates($cates, $limit=10, $thumb=null, $type=null)
{
    if (!is_array($cates)) {
        return [];
    }

    $result = NewsCategory::find()->where(['status'=>NewsCategory::STATUS_ACTIVE])
                                        ->andWhere(['id'=>$cates])
                                        ->indexBy('id')
                                        ->asArray()
                                        ->all();
    if ($type !== null) {
        $type = array_search($type, News::types());
    }

    foreach ($cates as $k => $v) {
        $tmp = News::find()->where(['status'=>News::STATUS_NORMAL])
                            ->andWhere(['category_id'=>$v])
                            ->andFilterWhere(['type'=>$type])
                            ->limit($limit)
                            ->all();
        $tp = [];
        foreach ($tmp as $val) {
            $tp[$val['id']] = $val->toArray();
            $tp[$val['id']]['cover'] = $val->getCover($thumb);
        }
        $result[$v]['child'] = $tp;
    }


    return $result;
}
/**
 * @name 取焦点图
 */
function focus($category_id, $limit, $imgSize=null)
{
	return Focus::getFocusByCategory($category_id, $limit, $imgSize);
}

function subject($cate, $rows, $thumbSize=null)
{
    $list = Subject::find()->where(['status'=>Subject::STATUS_NORMAL])
                            ->andWhere(['cate'=>$cate])
                            ->asArray()
                            ->all();

    foreach ($list as $k => &$v) {
        $v['cover'] = Attachment::getById($v['cover'], $thumbSize);
    }unset($v);



    return $list;

}

function productCateList($rows=5, $thumb='')
{
	$list = Category::find()->where(['is_show'=>1])->limit($rows)->asArray()->all();

	foreach ($list as $k => &$v) {
		$v['cover'] = Attachment::getById($v['thumb'], $thumb);
	}unset($v);
	return $list;
}

/**
 * @param $type_id
 * @param int $rows
 * @param string $thumb
 * @return array|\yii\db\ActiveRecord[]
 */
function productByType($type_id, $rows=10, $thumb='')
{
    $cates = Category::find()->where(['status'=>Category::STATUS_ACTIVE])
        ->andWhere(['type_id'=>$type_id])
        ->andWhere(['is_leaf'=>1, 'is_show'=>1])
        ->asArray()
        ->all();

    $cids = ArrayHelper::getColumn($cates, 'id');

    $goods = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE])
                            ->andWhere(['category_id'=>$cids])
                            ->andWhere(['is_show'=>1])
                            ->limit($rows)
                            ->asArray()
                            ->all();

    foreach ($goods as $k => &$v) {
        $v['cover'] = Attachment::getById($v['thumb'], $thumb);
    }unset($v);

    return $goods;
}

function getTagGoods($res_id,$limit=null, $thumb=null)
{
    $goods_ids = TagRel::getReleted('goods', $res_id, $limit);
    $goods = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE])
                            ->andWhere(['id'=>$goods_ids])
                            ->andWhere(['is_show'=>1])
                            ->asArray()
                            ->all();
    foreach ($goods as $k => &$v) {
        $v['cover'] = Attachment::getById($v['thumb'], $thumb);
    }unset($v);

    return $goods;

}

/**
 * @name 按类型取商品
 * @des 并按分类整理
 */
function productCateByType($type_id, $rows=10, $thumb='')
{
    $cates = Category::find()->where(['status'=>Category::STATUS_ACTIVE])
                            ->andWhere(['type_id'=>$type_id])
                            ->andWhere(['is_leaf'=>1, 'is_show'=>1])
                            ->asArray()
                            ->all();

    foreach ($cates as $k =>&$v) {
        $goods = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE])
                            ->andWhere(['category_id'=>$v['id']])
                            ->andWhere(['is_show'=>1])
                            ->limit($rows)
                            ->asArray()
                            ->all();
        foreach ($goods as $key => $val) {
            $v['child'][$val['id']]= $val;
            $v['child'][$val['id']]['cover'] = Attachment::getById($val['thumb'], $thumb);
        }
    }unset($v);

    return $cates;

}

function productList($category_id=null,$rows=10, $thumb='')
{

    $query = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE])
                            ->andWhere(['is_show'=>1]);

    if ($category_id !== null) {
        $query->andWhere(['category_id'=>$category_id]);
    }

    $list = $query->limit($rows)->asArray()->all();

	foreach ($list as $k => &$v) {
		$v['cover'] = Attachment::getById($v['thumb'], $thumb);
	}unset($v);

	return $list;
}

/**
 * @name 取文章列表 
 */
//function postList($mod, $category_id=null, $rows=null)
//{
//	Code::createObj('post', $mod);
//	$class = '\app\modules\cms\models\mods\Post' . $mod;
//
//	if ($category_id !== null) {
//		$list = $class::find()->where(['category_id'=>$category_id])->limit($rows)->asArray()->all();
//	} else {
//		$list = $class::find()->limit($rows)->asArray()->all();
//	}
//
//	$post_ids = ArrayHelper::getColumn($list, 'id');
//
//	$dataClass = '\app\modules\cms\models\mods\PostData' . $mod;
//	$datas = $dataClass::find()->where(['post_id'=>$post_ids])->indexBy('post_id')->asArray()->all();
//
//	foreach ($list as &$v) {
//		$v['body'] = $datas[$v['id']]['body'];
//		$v['thumb'] = Attachment::getById($v['thumb'],'200x200');
//		$v['url'] = Url::toRoute(['about-view', 'mod'=>$mod, 'id'=>$v['id']]);
//	}unset($v);
//
//	return $list;
//}

//function postDetail($mod, $id)
//{
//	Code::createObj('post', $mod);
//	$class = '\app\modules\cms\models\mods\Post' . $mod;
//	$dataClass = '\app\modules\cms\models\mods\PostData' . $mod;
//
//	$model = $class::findOne($id);
//	$model->view_all += 1;
//	$model->save();
//	$post = $model->toArray();
//	$data = $dataClass::findOne($id)->toArray();
//
//	return array_merge($post, $data);
//}

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
	return isset(Yii::$app->params[$name]) ? Yii::$app->params[$name] : '';
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

function getMemorialByUser($user_id, $rows=5)
{
    $memorials = Memorial::find()->where(['status'=>Memorial::STATUS_NORMAL])
                                ->andWhere(['user_id'=>$user_id])
                                ->limit($rows)
                                ->all();
    return $memorials;
}

function getBlogsByUser($user_id, $rows=10)
{
    $blogs = Blog::find()->where(['status'=>Memorial::STATUS_NORMAL])
            ->andWhere(['created_by'=>$user_id])
            ->limit($rows)
            ->all();
    return $blogs;
}

function  filelog($word, $file='log', $other='')
{

    if (is_array($word)) {
        $str = '';
        foreach ($word as $k=>$v) {
            $str .= $k.'=' . $v.'&';
        }

        $word = $str;
    }
    $word = $other . ' ' . $word;
    $log_name="./logs/" . $file . ".log";//log文件路径
    $fp = fopen($log_name,"a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,"执行日期：" . date("Y-m-d H:i:s")."\n".$word."\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}
