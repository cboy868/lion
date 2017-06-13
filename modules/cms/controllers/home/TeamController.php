<?php

namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\Post;
use app\modules\mod\models\Module;
use app\modules\cms\models\PostImageSearch;
use yii\web\NotFoundHttpException;
use app\modules\mod\models\Code;

class TeamController extends \app\core\web\HomeController
{
    public $mid = 7;

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

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module,
            'type'  => $type
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
        return $this->render('text', [
            'model' => $model,
            'mInfo' => $module
        ]);
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
