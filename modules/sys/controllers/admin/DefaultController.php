<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\Set;
use app\modules\sys\models\SetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\core\helpers\ArrayHelper;
use app\core\helpers\FileHelper;
use yii\base\Model;
use app\core\base\Upload;
/**
 * AdminController implements the CRUD actions for Set model.
 */
class DefaultController extends \app\core\web\BackController 
{
    /**
     * Lists all Set models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new SetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Set model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Set model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Set();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sname]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Set model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sname]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Set model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Set model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Set the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Set::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 设置
     */
    public function actionIndex()
    {
        $settings = Set::find()->indexBy('sname')->orderBy('sort asc')->all();

        if (Model::loadMultiple($settings, \Yii::$app->request->post()) && Model::validateMultiple($settings)) {


            $info = [];

            foreach ($settings as $setting) {

                // if ($setting->stype == 'file') {
                //     $upload = Upload::getInstanceByName('Set['.$setting->sname.'][svalue]');
                //     if (!$upload) {
                //         continue;
                //     } 

                //     $upload_info = $upload->save($setting->sname);
                //     $setting->svalue = '/'. $upload_info['path'];
                // }
                
                $setting->save(false);

                $info[$setting['sname']] = $setting['svalue'];
            }


            // $dbConfig = var_export($dbConfig, true);
            // $dbConfig = '<?php return ' . $dbConfig . ' ;';


            $content = var_export($info, true);
            $content = '<?php return ' . $content . ' ;';



            try {
                $path = Yii::getAlias('@app/config/setting.php');
                file_put_contents($path, $content);
            } catch (\Exception $e) {
                p($e->getMessage());die;
            }
            


            return $this->redirect(['index']);
        }

        $settings = ArrayHelper::group($settings, 'smodule');
        return $this->render('index', ['settings' => $settings]);
    }

    /**
     * @title 设置主题
     */
    public function actionTheme()
    {


        $theme = $this->view->theme;
        // $theme->pathMap = [
        //     '@app/modules/home/views' => '@app/web/theme/site'
        // ];

        $themeBasePath = $this->view->theme->getBasePath();

        $baseUrl = $this->view->theme->getBaseUrl();

        $themes = FileHelper::getThemes($themeBasePath, $baseUrl);


        $model = Set::find()->where(['sname'=>'theme'])->one();

        return $this->render('theme', [
            'themes' => $themes,
            'current' => $model
        ]);
    }

    public function actionSetTheme($theme)
    {

        if ($model = Set::find()->where(['sname'=>'theme'])->one()) {
            $model->svalue = $theme;
        } else {
            $model = new Set();
            $model->sname = 'theme';
            $model->smodule = 'other';
            $model->stype = 'input';
            $model->svalue = $theme;
            $model->sintro = '当前主题';
        }

        if ($model->save() !== false) {
            Yii::$app->session->setFlash('success', '主题设置成功');
        } else {
            Yii::$app->session->setFlash('error','主题设置失败');
        }

        return $this->redirect('theme');

    }

    /**
     * @title 预览
     */
    public function actionPre($theme)
    {

    }
}

