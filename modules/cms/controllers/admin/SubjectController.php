<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\core\helpers\ArrayHelper;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use app\core\helpers\Url;
use app\core\base\Upload;
/**
 * PostController implements the CRUD actions for Post model.
 */
class SubjectController extends BackController
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
     * @name 专题列表
     */
    public function actionIndex()
    {

    }

    /**
     * @name 添加专题
     */
    public function actionCreate()
    {

    }

    /**
     * @name 修改
     */
    public function actionUpdate()
    {

    }

    /**
     * @name 删除
     */
    public function actionDelete()
    {

    }

    protected function findModel($id)
    {
        if (($model = Subjcet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
