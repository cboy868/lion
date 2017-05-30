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
     * @name 图片上传配置
     */
    public function actionIndex()
    {

        $models = ImageConfig::find()->where(['res_name'=>array_keys(ImageConfig::$resname)])->indexBy('res_name')->all();

        $request = Yii::$app->request;

        foreach (ImageConfig::$resname as $k => $v) {
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
                 } else {
                    unset($models[$res_name]->water_image);
                 }
                 
                 if ($models[$res_name]->save()) {
                    ImageConfig::writeFile();

                    Yii::$app->session->setFlash('success', '恭喜 参数配置成功。');

                    return $this->redirect(['index']);
                 }
            }

        }


        return $this->render('index', [
            'models' => $models,
            'res'    => ImageConfig::$resname
        ]);
    }
    
}
