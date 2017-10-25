<?php

namespace app\modules\task\controllers\admin;

use Yii;
use app\modules\task\models\Task;
use app\modules\task\models\search\TaskSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Task model.
 */
class ProfileController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $params = Yii::$app->request->queryParams;
        $params['TaskSearch']['op_id'] = Yii::$app->user->id;


        if (isset($params['t']) && $params['t'] == 1) {
            $params['TaskSearch']['start'] = $params['TaskSearch']['end'] = date("Y-m-d");
        }

        if (isset($params['t']) && $params['t'] == 2) {
            $params['TaskSearch']['start'] = $params['TaskSearch']['end'] = date("Y-m-d",strtotime('+1 day'));
        }

        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->excel($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {
        $columns = [
            'info.name',
            'user.username',
            'op.username',
            'title',
            'content:ntext',
            'pre_finish:date',
            'finish',
            'statusText',
        ];

        $options = [
            'title'=>'任务',
            'filename'=>'task',
            'pageTitle'=>'任务'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
