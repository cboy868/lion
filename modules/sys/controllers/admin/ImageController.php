<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\ImageConfig;
use app\modules\sys\models\ImageConfigSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use app\core\base\Upload;
/**
 * ImageController implements the CRUD actions for ImageConfig model.
 */
class ImageController extends BackController
{
    public static $resname = [
        'goods' => '商品',
        'focus' => '焦点图'
    ];

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
     * Lists all ImageConfig models.
     * @return mixed
     */
    public function actionIndex()
    {

        

        $models = ImageConfig::find()->where(['res_name'=>array_keys(self::$resname)])->indexBy('res_name')->all();

        $request = Yii::$app->request;

        foreach (self::$resname as $k => $v) {
            if (!isset($models[$k])) {
                $models[$k] = new ImageConfig();
                $models[$k]->loadDefaultValues();
            }
        }

        if ($request->isPost) {

            $data = $request->post('ImageConfig');
            $res_name = $data['res_name'];

            if ($models[$res_name]->load($request->post())) {
                $upload = Upload::getInstance($models[$res_name], 'water_image', 'imgconfig');
                if ($upload) {
                    $upload->save();
                    $info = $upload->getInfo();
                    $models[$res_name]->water_image = $info['path'] . '/' . $info['fileName'];
                 }
                 
                 if ($models[$res_name]->save()) {

                    ImageConfig::writeFile();
                    
                    return $this->redirect(['index']);
                 }
            }

        }

        return $this->render('index', [
            'models' => $models,
            'res'    => self::$resname
        ]);
    }
    
}
