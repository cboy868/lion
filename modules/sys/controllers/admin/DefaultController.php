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
     * @name 网站配置项管理
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
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Set model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加配置项
     */
    public function actionCreate()
    {
        $model = new Set();

        if ($model->load(Yii::$app->request->post()) &&$model->validate()) {

            $sv = trim($model->svalues);
            $sv_arr = explode("\r\n", $sv);
            $result = [];
            if (is_array($sv_arr)) {
                foreach ($sv_arr as $v) {
                    $sub = explode('/', $v);
                    if (!isset($sub[0]) && !isset($sub[1])) continue;
                    if (isset($sub[0]) && !isset($sub[1])) $result[] = $sub[0];
                    if (isset($sub[0]) && isset($sub[1])) $result[$sub[0]] = $sub[1];
                }
                $model->svalues = json_encode($result);
            } else {
                $model->svalues = null;
            }

            $model->save();
            return $this->redirect(['list']);
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
     * @name 修改配置项
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $sv = trim($model->svalues);
            $sv_arr = explode("\r\n", $sv);
            $result = [];
            if (is_array($sv_arr)) {
                foreach ($sv_arr as $v) {
                    $sub = explode('/', $v);
                    if (!isset($sub[0]) && !isset($sub[1])) continue;
                    if (isset($sub[0]) && !isset($sub[1])) $result[] = $sub[0];
                    if (isset($sub[0]) && isset($sub[1])) $result[$sub[0]] = $sub[1];
                }
                $model->svalues = json_encode($result);
            } else {
                $model->svalues = null;
            }


            $model->save();
            return $this->redirect(['list']);
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
     * @name 删除配置项
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
     * @name 配置项设置主页
     */
    public function actionIndex()
    {
        $settings = Set::find()->indexBy('sname')->orderBy('sort asc')->all();

        if (Model::loadMultiple($settings, \Yii::$app->request->post()) && Model::validateMultiple($settings)) {

            foreach ($settings as $setting) {

                if ($setting->stype == 'file') {
                    $upload = Upload::getInstance($setting, $setting->sname.'[svalue]', 'sys_set');
                    if ($upload) {
                        $upload->save();

                        $img_info = $upload->getInfo();
                        $setting->svalue = $img_info['path'] . '/' . $img_info['fileName'];
                        $setting->save(false);
                    }
                } else {
                    if (is_array($setting->svalue)) {
                        $setting->svalue = json_encode($setting->svalue);//implode(',', $setting->svalue);
                    }
                    $setting->save(false);
                }

            }

            $this->updateSettings();
            
            return $this->redirect(['index']);
        }
        foreach ($settings as &$v) {
            if (in_array($v->stype, ['checkbox'])) {
                $v->svalue = json_decode($v->svalue);
            }
        }unset($v);
        $settings = ArrayHelper::group($settings, 'smodule');
        return $this->render('index', ['settings' => $settings]);
    }

    private function updateSettings()
    {
        $settings = Set::find()->indexBy('sname')->orderBy('sort asc')->all();
        foreach ($settings as $setting) {
            $info[$setting['sname']] = $setting['svalue'];
        }

        $content = var_export($info, true);
        $content = '<?php return ' . $content . ' ;';

        try {
            $path = Yii::getAlias('@app/config/setting.php');
            file_put_contents($path, $content);
        } catch (\Exception $e) {
        }

        return true;

    }

    /**
     * @name 主题列表
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

    /**
     * @param $theme
     * @return \yii\web\Response
     * @name 设置主题
     */
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

