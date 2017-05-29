<?php

namespace app\modules\install\models;

use Yii;
use yii\base\Model;
use yii\db\Connection;
use yii\helpers\Url;
use app\modules\user\models\User;

/**
 * Signup form
 */
class Db extends Model
{
    public $host;
    public $dbname;
    public $dbuser;
    public $dbpwd;

    public $username;
    public $password;
    public $repassword;
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host', 'dbname', 'dbuser', 'username', 'email'], 'filter', 'filter' => 'trim'],
            [['host', 'dbname', 'dbuser', 'dbpwd', 'username','password', 'email'], 'required'],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute'=>'password']

        ];
    }

    public function attributeLabels()
    {
      return array(
        'host' => '数据库服务器',
        'dbname' => '数据库名',
        'dbuser' => '数据库登录名',
        'dbpwd' => '数据库密码',

        'username'=> '管理员账号',
        'email' => '管理员邮箱',
        'password' => '管理员密码',
        'repassword' => '再次输入密码',
      );
    }



    public function install()
    {

        if ($this->load(Yii::$app->request->post()) && $this->validate()) {

            if ($this->_checkConfig() === false) {
                return ;
            }


            if ($this->_writeConfig() === false) {
                return ;
            }

            $db = Yii::$app->db;


            $transaction = $db->beginTransaction();
            try
            {
                self::showMsg('创建数据库表。。。');
                if(self::execSql('install')!==true)
                {
                    $transaction->rollBack();
                    return;
                }
                self::showMsg('数据库表创建成功');
            
                self::showMsg('生成管理员。。。');
                $this->initAdmin();
                self::showMsg('管理员生成成功');
            
                $transaction->commit();
            
                $file = Yii::getAlias('@app/web/install.lock');
                @touch($file);
            
                self::showMsg('安装完成');
                echo '<script>window.location="' . Url::to(['finish']) . '"</script>';
            } catch (\Exception $e) {

                self::showMsg('安装失败');

                $msg = $this->_getDbError($e->getMessage());

                self::showMsg($msg, true);

                $transaction->rollBack();

            }
        }

    }


    /**
     * @name 初始化管理员
     */
    public function initAdmin()
    {
        $user = new User;

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();

    }


    private function _getDbError($message)
    {
        Yii::info($message,__METHOD__);
        
        if (preg_match('/SQLSTATE\[HY000\] \[2002\]/', $message))
        {
            $message = '连接失败，请检查数据库配置';
        }
        elseif (preg_match('/Unknown/', $message))
        {
            $message = '未找到数据库: ' . $this->dbname . ' 请先创建该库';
        }
        elseif (preg_match('/failed to open the DB/', $message))
        {
            $message = '连接失败，请检查数据库配置: ' . $this->host;
        }
        elseif (preg_match('/1044/', $message))
        {
            $message = '当前用户没有访问数据库的权限';
        }
        else
        {
            //$ret = false;
        }
        return $message;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
//     public function create()
//     {
//         if ($this->validate()) {

//             $this->checkConfig();

//             //数组形式，看上去更巧一点
//             // $dbConfig = [
//             //     'class' => 'yii\db\Connection',
//             //     'dsn' => "mysql:host={$this->host};dbname={$this->dbname}",
//             //     'username' => "{$this->dbuser}",
//             //     'password' => "{$this->dbpwd}",
//             //     'charset' => 'utf8'
//             // ];


//             // $dbConfig = var_export($dbConfig, true);
//             // $dbConfig = '<?php return ' . $dbConfig . ' ;';

//             $dbconfig = <<<'CONF'
// <?php
// return [
//     'class' => 'yii\db\Connection',
//     'dsn' => 'mysql:host=%s;dbname=%s',
//     'username' => '%s',
//     'password' => '%s',
//     'charset' => 'utf8'
// ];
// CONF;
//             $dbconfig = sprintf($dbconfig, $this->host, $this->dbname, $this->dbuser, $this->dbpwd);

//             $path = Yii::getAlias('@app/config/dba.php');


//             try {
//                 file_put_contents($path, $dbconfig);

//                 return $this;

//             } catch (\Exception $e) {
//                 return false;
//             }

//         }

//         return null;
//     }

    private function _writeConfig()
    {
        $dbconfig = <<<'CONF'
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=%s;dbname=%s',
    'username' => '%s',
    'password' => '%s',
    'charset' => 'utf8'
];
CONF;
        $dbconfig = sprintf($dbconfig, $this->host, $this->dbname, $this->dbuser, $this->dbpwd);

        $path = Yii::getAlias('@app/config/db.php');

        try {
            @file_put_contents($path, $dbconfig);

            self::showMsg('配置文件写入成功');
            return $this;
        } catch (\Exception $e) {
            self::showMsg('配置文件写入失败');
            return false;
        }

    }


    public static function execSql($file)
    {
        $file = Yii::getAlias('@app/modules/install/data') . '/' . $file . '.sql';

        if(!file_exists($file))
        {
            self::showMsg('SQL文件：'.$file.'不存在',true);
            return false;
        }

        $db = Yii::$app->db;
        
        $tbPre = $db->tablePrefix;
        $content = @file_get_contents($file);
        $sqls = self::parseSql($content);


        if (is_array($sqls))
        {
            foreach ($sqls as $sql)
            {
                if (trim($sql) != '')
                {
                    if(substr($sql, 0, 12) == 'CREATE TABLE') {
                        $name = preg_replace("/CREATE TABLE IF NOT EXISTS ([a-z0-9_`]+) .*/is", "\\1", $sql);

                        self::showjsmessage('create_table '.$name.' ... succeed');
                    }

                    $db->createCommand(str_replace('#@__', $tbPre, $sql))->execute();
                }
            }
        }
        else
        {
            $db->createCommand(str_replace('#@__', $tbPre, $sql))->execute();
        }
        return true;
    }

    public static function showjsmessage($msg) {
        echo '<script type="text/javascript">showmessage(\''.addslashes($msg).' \');</script>'."\r\n";
        flush();
        ob_flush();
    }

    public static function parseSql($sql)
    {
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=UTF8", $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query)
        {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query)
            {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num ++;
        }
        return ($ret);
    }

    /**
     * @name  检查install.lock文件是不是存在 
     */
    public static function checkInstall()
    {
        $file = Yii::getAlias('@app/web/install.lock');

        return !file_exists($file);
    }



    private function _checkConfig()
    {
        self::showMsg('检查数据库连接...');

       
        if (empty($this->host) || empty($this->dbname) || empty($this->dbuser)) {
            $msg = '数据库信息必须填写完整';
            self::showMsg($msg, true);
            return false;
        }
      
        $config = [
            'dsn' => "mysql:host={$this->host};dbname={$this->dbname}", 
            'username' => $this->dbuser, 
            'password' => $this->dbpwd
        ];
        
        $result = false;
        $msg = '';
        $db = new Connection($config);
        
        try
        {
            $db->open();
            if (!$db->isActive)
            {
                $msg = '连接失败，请检查数据库配置';
                $result = false;
            }
            else 
            {
                $msg = '数据库连接成功';
                $result = true;
            }

            self::showMsg($msg);

        } catch (\Exception $e) {
            $db->close();
            $msg = $this->_getDbError($e->getMessage());
            self::showMsg($msg,true);
            $result = false;
        }

        return $result;
    }

    public static function showMsg($msg, $return = false)
    {
        if ($return)
        {
            $msg .= "<br> <a href='" . Url::to(['db']) . "' class='red'>返回检查</a>";
        }
        $msg = json_encode($msg);
        echo '<script>var msg = '.$msg.'; $("#msg").append(msg + "<br />");</script>';
        ob_flush();
        flush();
        // sleep(1);

    }
}
