<?php


use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use app\core\helpers\Url;
use app\core\helpers\StringHelper;


use app\modules\focus\models\Focus;
use app\modules\focus\models\Category as FocusCategory;
use app\modules\cms\models\Links;
use app\modules\cms\models\Subject;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\news\models\News;
use app\modules\news\models\Category as NewsCategory;
use app\modules\cms\models\Category as cmsCategory;
use app\core\models\TagRel;
use app\modules\memorial\models\Memorial;
use app\modules\blog\models\Blog;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;


//  按格式打印数组
function p($arr)
{
     header("Content-type:text/html;charset=utf-8");
    echo '<pre>'.print_r($arr,true).'</pre>';
}

function getParam($key=null)
{
    if ($key===null) {
        return Yii::$app->request->get();
    }
    return Yii::$app->request->get($key);
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


function tagnews($id, $rows)
{
    $rels = TagRel::getReleted('news', $id, $rows);
    $news = News::find()->where(['id'=>$rels])
        ->andWhere(['status'=>News::STATUS_NORMAL])
        ->asArray()
        ->all();

    return $news;
}

function tags($res_name, $limit=10)
{
    return TagRel::resTags($res_name, $limit);
}


/**
 * @param null $category_id
 * @param int $limit
 * @param $thumb
 */
function news($category_id=null, $limit=10, $thumb=null, $type=null, $recommend=false)
{
    $query = News::find()->where(['status'=>News::STATUS_NORMAL]);

    if ($category_id !== null) {
        $query->andWhere(['category_id'=>$category_id]);
    }

    if ($recommend) {
        $query->andWhere(['recommend'=>1]);
    }

    if ($type !== null) {
        $t = array_search($type, News::types());
        $query->andWhere(['type'=>$t]);
    }
    $list = $query->orderBy('id desc')->limit($limit)->all();

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
function newsCates($cates=null, $limit=10, $thumb=null, $type=null)
{

    $result = NewsCategory::find()->where(['status'=>NewsCategory::STATUS_ACTIVE])
        ->andFilterWhere(['id'=>$cates])
        ->indexBy('id')
        ->asArray()
        ->all();
    if ($type !== null) {
        $type = array_search($type, News::types());
    }

    if ($limit) {
        foreach ($result as $k => $v) {
            $tmp = News::find()->where(['status'=>News::STATUS_NORMAL])
                ->andWhere(['category_id'=>$v['id']])
                ->andFilterWhere(['type'=>$type])
                ->limit($limit)
                ->all();
            $tp = [];
            foreach ($tmp as $val) {
                $tp[$val['id']] = $val->toArray();
                $tp[$val['id']]['cover'] = $val->getCover($thumb);
            }
            $result[$v['id']]['child'] = $tp;
        }
    }
    return $result;
}

/**
 * @name 取焦点图
 */
function focus($category_id, $limit, $imgSize=null)
{
    return [
        'cate' => FocusCategory::findOne($category_id)->toArray(),
        'focus' => Focus::getFocusByCategory($category_id, $limit, $imgSize)
    ];
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

function productCateTree($thumb='')
{
    $list = Category::find()->where(['is_show'=>1])->asArray()->all();
    foreach ($list as &$v) {
        $v['cover'] = Attachment::getById($v['thumb'], $thumb);
    }

    return Category::makeTree($list);
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

function cmsRand($mid, $category_id=null, $limit=10, $thumb=null)
{
    $module = Module::findOne($mid);
    Code::createObj('post', $mid);

    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;


    $article = $class::find()->orderBy('rand()')
        ->limit($limit)
        ->asArray()
        ->all();

    foreach ($article as $key => &$v) {
        $v['cover'] = \app\modules\cms\models\PostImage::getById($v['thumb'], $thumb);
    }unset($v);

    return $article;
}

function cmsNewArticle($mid, $limit=10, $thumb=null)
{
    $module = Module::findOne($mid);
    Code::createObj('post', $mid);

    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;

    $article = $class::find()->orderBy('id desc')
        ->limit($limit)
        ->asArray()
        ->all();

    foreach ($article as $key => &$v) {
        $v['cover'] = \app\modules\cms\models\PostImage::getById($v['thumb'], $thumb);
    }unset($v);

    return $article;
}

function cmsCates($mid, $category_id=null, $thumb=null)
{
    $cates = cmsCategory::find()->where(['mid'=>$mid])
                                ->andFilterWhere(['id'=>$category_id])
                                ->asArray()
                                ->all();
    return $cates;

}


function cmsCateAndArticle($mid, $category_id=null, $limit=10, $thumb=null)
{
    $module = Module::findOne($mid);
    Code::createObj('post', $mid);


    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;


    $query = cmsCategory::find()->where(['mid'=>$mid])
        ->andFilterWhere(['id'=>$category_id]);

    if (is_numeric($category_id)) {
        $cates = $query->one()->toArray();
        $category_ids = $category_id;
    } else {
        $cates = $query->asArray()->all();
        $category_ids = ArrayHelper::getColumn($cates, 'id');
    }

    $article = $class::find()->where(['category_id'=>$category_ids])
        ->orderBy('id desc')
        ->limit($limit)
        ->asArray()
        ->all();

    foreach ($article as &$v) {
        $v['cover'] = \app\modules\cms\models\PostImage::getById($v['thumb'], $thumb);
    }unset($v);

    return ['cates'=>$cates, 'posts'=>$article,'modInfo'=>$module->toArray()];

}
/**
 * @return null
 * @name 文章
 */
function cmsArticle($mid, $category_id=null, $limit=10, $thumb=null)
{
    $module = Module::findOne($mid);
    Code::createObj('post', $mid);


    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;


    $query = cmsCategory::find()->where(['mid'=>$mid])
        ->andFilterWhere(['id'=>$category_id]);

    if (!is_numeric($category_id)) {
        $cates = $query->asArray()->all();
        foreach ($cates as &$v) {
            $article = $class::find()->where(['category_id'=>$v['id']])
                ->orderBy('id desc')
                ->limit($limit)
                ->asArray()
                ->all();

            foreach ($article as $key => $val) {
                $v['child'][$val['id']]= $val;
                $v['child'][$val['id']]['cover'] = \app\modules\cms\models\PostImage::getById($val['thumb'], $thumb);
            }
        }unset($v);
    } else if(is_numeric($category_id)) {
        $cates = $query->one()->toArray();
        $article = $class::find()->where(['category_id'=>$cates['id']])
            ->orderBy('id desc')
            ->limit($limit)
            ->asArray()
            ->all();

        foreach ($article as $key => $val) {
            $cates['child'][$val['id']]= $val;
            $cates['child'][$val['id']]['cover'] = \app\modules\cms\models\PostImage::getById($val['thumb'], $thumb);
        }
    }

    if(is_null($category_id)) {

        $article = $class::find()->andFilterWhere(['category_id'=>0])
            ->orderBy('id desc')
            ->limit($limit)
            ->asArray()
            ->all();

        foreach ($article as $key => $val) {
            $cates['child'][$val['id']]= $val;
            $cates['child'][$val['id']]['cover'] = \app\modules\cms\models\PostImage::getById($val['thumb'], $thumb);
        }
    }

    return ['modInfo'=>$module->toArray(),'list'=>$cates];
}
function cmsArticleDetail($mid, $id, $thumb)
{
    Code::createObj('post', $mid);
    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;
    $article = $class::findOne($id)->toArray();
    $article['cover'] = \app\modules\cms\models\PostImage::getById($article['thumb'], $thumb);

    return $article;
}

function cmsImages($mid, $category_id=null, $limit=10, $thumb=null)
{
    $module = Module::findOne($mid);
    Code::createObj('post', $mid);

    $cate = cmsCategory::find()->where(['mid'=>$mid])
        ->andFilterWhere(['id'=>$category_id])
        ->asArray()
        ->one();

    $c = 'Post' . $mid;
    $class = '\app\modules\cms\models\mods\\' . $c;


    $article = $class::find()->where(['category_id'=>$cate['id']])
        ->limit($limit)
//            ->asArray()
        ->all();

    foreach ($article as $key => $val) {
        $cate['child'][$val->id]= $val->toArray();
        $cate['child'][$val->id]['images'] = $val->getImages($thumb);
    }

    return ['modInfo'=>$module->toArray(),'list'=>$cate];
}

/**
 * @return null
 * @name 图集
 */
function cmsAlbum()
{
    return null;
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

function memorialBlogs($memorial_id=null, $rows)
{
    $query = Blog::find()->where(['status'=>Blog::STATUS_NORMAL]);
    if ($memorial_id) {
        $query->andWhere(['memorial_id'=>$memorial_id]);
    } else {
        $query->andWhere(['>', 'memorial_id', 0]);
    }

    $list = $query->orderBy('id desc')->limit($rows)->all();


    return $list;
}

function getBlogsByUser($user_id, $rows=10)
{
    $blogs = Blog::find()->where(['status'=>Memorial::STATUS_NORMAL])
            ->andWhere(['created_by'=>$user_id])
            ->limit($rows)
            ->all();
    return $blogs;
}

function formatterNtext($body)
{
    return Yii::$app->formatter->asNtext($body);
}

function formatterText($body)
{
    return Yii::$app->formatter->asText($body);
}
function formatterParagraphs($body)
{
    return Yii::$app->formatter->asParagraphs($body);
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
