<?php

namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\Post;
use app\modules\mod\models\Module;
use app\modules\cms\models\PostImageSearch;
use yii\web\NotFoundHttpException;
use app\modules\mod\models\Code;

class CaseController extends \app\core\web\HomeController
{
    public $mid = 1;

    public function actionIndex($type=null, $cid=null)
    {
        $module = Module::findOne($this->mid);
        Code::createObj('post', $this->mid);

        $c = 'Post' . $this->mid . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;
        if ($cid) {
            $params[$c]['category_id'] = $cid;
        }

        if ($type) {
            $types = Post::types();
            $type_key = array_search($type, $types);
            $params[$c]['type'] = $type_key;
        }

        $dataProvider = $searchModel->search($params);
        $models = $dataProvider->getModels();
        $result = [];
        foreach ($models as $v) {
            $result[$v->id] = $v->toArray();
            $result[$v->id]['cover'] = $v->getCover('372x248');
        }


        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module->toArray(),
            'type'  => $type,
            'data' => $result,
            'pagination' => $dataProvider->getPagination()
        ];

        return $this->render('index', $data);

    }

    public function actionView($id)
    {
        $module = Module::findOne($this->mid);
        $model = $this->findModel($id);
        $method = '_' . Post::types($model->type) . 'View';

        return $this->$method($module, $model);
    }

    private function _textView($module, $model)
    {
        $data = [
            'model' => $model,
            'mInfo' => $module
        ];

        $data = array_merge($data, $this->preAndNext($module, $model));

        return $this->render('text', $data);
    }

    private function _imageView($module, $model)
    {
        $searchModel = new PostImageSearch();
        $params = Yii::$app->request->queryParams;
        $params['PostImageSearch']['mid'] = $module->id;
        $params['PostImageSearch']['post_id'] = $model->id;

        $dataProvider = $searchModel->search($params);

        return $this->render('image', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'module' => $module,
        ]);
    }

    /**
     * @name 单页面时 使用此方法
     */
    public function actionUs()
    {
        return $this->render('us');
    }

    private function preAndNext($model)
    {
        $module = Module::findOne($this->mid);
        Code::createObj('post', $this->mid);

        $c = 'Post' . $this->mid . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;


        $pre_id = $class::find()->where(['<', 'id', $model->id])->max('id');
        $next_id = $class::find()->where(['>', 'id', $model->id])->min('id');

        $data = [];
        if ($pre_id) {
            $data['pre'] = $this->findModel($pre_id)->toArray();
        }

        if ($next_id) {
            $data['next'] = $this->findModel($next_id)->toArray();
        }

        return $data;
    }

    protected function findModel($id)
    {
        Code::createObj('post', $this->mid);

        $class = '\app\modules\cms\models\mods\Post' . $this->mid;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
