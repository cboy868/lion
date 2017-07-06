<?php

namespace app\modules\ashes\controllers\admin;

use app\modules\ashes\models\Box;
use app\modules\ashes\models\Log;
use yii;
use app\core\helpers\Url;
use app\modules\ashes\models\Area;
use app\modules\ashes\models\BoxSearch;

class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        $cates = $this->getAreas();
        $searchModel = new BoxSearch();
        $params = Yii::$app->request->queryParams;

        $params['BoxSearch']['area_id'] = isset($params['aid']) ? $params['aid'] : false;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates,
            'params' => $params
        ]);
    }

    public function actionView($box_id)
    {
        $box = Box::findOne($box_id);

        return $this->render('view', ['model'=>$box]);
    }

    private function getAreas()
    {
        $tree = Area::sortTree();

        foreach ($tree as $k => &$v) {
            if ($v['is_leaf']) {
                $v['url'] =Url::toRoute(['index', 'aid'=>$v['id']]);
            } else {
                $v['url'] = '#';
            }
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }
}
