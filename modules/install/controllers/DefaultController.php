<?php

namespace app\modules\install\controllers;


use yii;
use yii\web\Response;

use app\modules\install\Helper;
use app\modules\install\models\Db;

class DefaultController extends \app\core\web\HomeController
{
	public $layout = "@app/modules/install/views/default/layout.php";

    public function init()
    {
        parent::init();

        Yii::$app->getResponse()->on(Response::EVENT_AFTER_SEND, [$this, 'afterResponse']);
    }

    public function beforeAction()
    {
        if (($this->action->id != 'finish') && !Db::checkInstall()) {
            Yii::$app->getSession()->setFlash('notice', '如想重新安装，请选删除 install.lock 文件');
            $this->redirect(['finish']);
        }

        return parent::beforeAction();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionEnv()
    {
    	return $this->render('env', $this->getEnvData());
    }

    public function actionDb()
    {
        $model = new Db;

    	return $this->render('db', ['model'=>$model]);
    }

    public function actionInstall()
    {
        return $this->render('install');
    }

    public function actionFinish()
    {
        return $this->render('finish');
    }

    public function afterResponse($event)
    {
        if(Yii::$app->requestedAction->id==='install')
        {
            $model = new Db;

            if ($model->load(Yii::$app->request->post())) {
                $model->install();
            }
        }
    }



    private function getEnvData()
    {
        $isWritable = [
            [
                '系统临时文件(runtime)',
                true,
                is_writable(Yii::getAlias('@runtime')),
                '系统核心',
                '必须可读写'
            ],
            [
                '附件上传目录(web/upload)',
                true,
                is_writable(Yii::getAlias('@app/web/upload')),
                '附件上传',
                '图片、文件存储位置'
            ],
            [
                '数据备份目录(web/backup)',
                true,
                is_writable(Yii::getAlias('@app/web/backup')),
                '数据库备份',
                '数据库备份目录'
            ],
            [
                '配置文件目录(config)',
                true,
                is_writable(Yii::getAlias('@app/config/db.php')),
                '数据库配置',
                '数据库配置文件必须可写'
            ],
            [
                '公共资源文件(web/assets)',
                true,
                is_writable(Yii::getAlias('@app/web/assets')),
                '系统核心',
                '必须可读写'
            ]
        ];
        
        $requirements = array(
            [
                'PHP版本',
                true,
                version_compare(PHP_VERSION, "5.4.0", ">="),
                '系统核心',
                'PHP 5.4.0 或更高版本是必须的.'
            ],
            // [
            //     '$_SERVER 服务器变量',
            //     true,
            //     'ok' === $message = Helper::checkServerVar(),
            //     '系统核心',
            //     $message
            // ],
            [
        
                'Reflection 扩展模块',
                true,
                class_exists('Reflection', false),
                '系统核心',
                ''
            ],
            [
                'PCRE 扩展模块',
                true,
                extension_loaded("pcre"),
                '系统核心',
                ''
            ],
            [
                'SPL 扩展模块',
                true,
                extension_loaded("SPL"),
                '系统核心',
                ''
            ],
            //[
            //    'DOM 扩展模块',
            //    false,
            //    class_exists("DOMDocument", false),
            //    'CHtmlPurifier, CWsdlGenerator',
            //    ''
            //],
            [
                'PDO 扩展模块',
                true,
                extension_loaded('pdo'),
                '所有和使用PDO数据库连接相关的类',
                ''
            ],
            [
                'PDO MySQL 扩展模块',
                true,
                extension_loaded('pdo_mysql'),
                'MySql数据库',
                '使用MySql数据库必须支持'
            ],
            [
                'OpenSSL 扩展模块',
                true,
                extension_loaded('openssl'),
                'Security',
                '加密和解密方法'
            ],
            //[
            //    'SOAP 扩展模块',
            //    false,
            //    extension_loaded("soap"),
            //    'CWebService, CWebServiceAction',
            //    ''
            //],
            [
                'GD 扩展模块',
                false,
                'ok' === $message = Helper::checkCaptchaSupport(),
                'CaptchaAction',
                $message
            ],
            //[
            //    'Ctype 扩展模块',
            //    false,
            //    extension_loaded("ctype"),
            //    'CDateFormatter, CDateFormatter, CTextHighlighter, CHtmlPurifier',
            //    ''
            //]
        );
        
        $requireResult = 1;
        foreach ($requirements as $i => $requirement)
        {
            if ($requirement[1] && ! $requirement[2])
                $requireResult = 0;
            else if ($requireResult > 0 && ! $requirement[1] && ! $requirement[2])
                $requireResult = - 1;
            if ($requirement[4] === '')
                $requirements[$i][4] = '&nbsp;';
        }
        
        $writeableResult = 1;
        foreach ($isWritable as $k => $val)
        {
            if ($val[1] && ! $val[2])
                $writeableResult = 0;
            else if ($requireResult > 0 && ! $val[1] && ! $val[2])
                $writeableResult = - 1;
            if ($val[4] === '')
                $isWritable[$i][4] = '&nbsp;';
        }
        $data = [
            'isWritable' => $isWritable,
            'writeableResult' => $writeableResult,
            'requireResult' => $requireResult,
            'requirements' => $requirements
        ];
        return $data;
    }



}
