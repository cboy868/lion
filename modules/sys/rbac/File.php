<?php

namespace app\modules\sys\rbac;

use Yii;

class File{
    // DIRECTORY_SEPARATOR
    static $separate = '/';

    public static function combinPermission()
    {
        $methods = self::getAllMethods();
        $permissions = [];
        foreach ($methods as $key => $val) {
            $arr = explode(self::$separate, $key);


            foreach ($val as $k => $v) {
                $permissions[$arr[0]][$arr[1]][$key.self::$separate.$k] = [
                    'des' => $v['des'],
                    'action' => $k,
                    'menu' => $v['menu']
                ];
            }
        }

        return $permissions;
    }


    /**
     * @title 取得所有方法
     */
    public static function getAllMethods()
    {
        $namespaces = self::getClasses();

        foreach ($namespaces as $k => $v) {

            if (!is_array($v)) {
                continue;
            }

            $namespace = $k;

            $pre = strpos($k, '/') ? $k.self::$separate : $k.'/';
            $key_dir = Yii::getAlias('@'.$k);
            $key_dir = str_replace(DIRECTORY_SEPARATOR, '/', $key_dir);
            $dir_arr = explode('/' , $key_dir);


            if (($module_k = array_search('modules', $dir_arr)) !== false) {
                $key = $dir_arr[$module_k+1];
                $pre = strpos($key, '/') ? $key.self::$separate : $key.'/';
            }

            foreach ($v as $key => $val) {
                $controller_namespace = $namespace .'\\'.$val.'Controller';

                $val = self::uper2lower($val);
                $k = $pre . $val;

                $actions[$k] = self::getClassMethods($controller_namespace);
            }
        }

        return $actions;
    }

    /**
     * @title 取得某命名空间下的所有类
     */
    public static function getClasses()
    {

        // $module = \Yii::$app->controller->module;

        $namespaces = [];

        //不要接受控制的 module
        $sys_module = ['debug', 'gii', 'admin', 'home'];  //admin也不接受rbac控制，这里只有一个主页面，大家只要登录就都有使用权

        $modules = Yii::$app->getModules();

        foreach ($modules as $k => $v) {
            if (in_array($k, $sys_module)) {
                continue;
            }
            $mod = Yii::$app->getModule($k);
            $namespace = str_replace('/', '\\', $mod->controllerNamespace) . '\admin';
            array_push($namespaces, $namespace);
        }

        //当前所在命名空间的控制器
        // $currentNamespace = str_replace('/', '\\', \Yii::$app->controllerNamespace);
        // array_push($namespaces, $currentNamespace);

        foreach ($namespaces as $k=>$v) {
            $namespace = str_replace('\\', '/', $v);
            $dir = Yii::getAlias('@'.$namespace);

            $na = self::scan($dir);
            if ($na) {
                $classes[$namespace] = $na;
            }
        }

        return $classes;
    }

    /**
     * @name 取得一个类的所有公共方法
     */
    public static function getClassMethods($controller)
    {
        $actions = [];
        $controller = str_replace('/', '\\', $controller);

        $class = new \ReflectionClass($controller);//建立反射类
        $methods  = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $filter = ['actions', 'behaviors', 'init'];

        foreach ($methods as $method) {
            if ($method->class ==$controller && !in_array($method->name, $filter)) {
                preg_match('/\* @name(.*)/', $method->getDocComment(), $matches);
                preg_match('/\* @menu(.*)/', $method->getDocComment(), $menuMatches);

                $key =  substr($method->name, 0, 6) == 'action' ? substr($method->name,6) : $method->name;
                $key = self::uper2lower($key);
                $actions[$key]['des'] = isset($matches[1]) ? trim($matches[1]) : '';
                $actions[$key]['menu'] = isset($menuMatches[1]) ? 1 : 0;
            }
        }

        return $actions;
    }

    /**
     * @title 扫描目录文件
     */
    public static function scan($dir)
    {
        if (!is_dir($dir)) {
            return null;
        }
        $classes = array_diff(\scandir($dir), ['.','..']);

        foreach ($classes as $k => &$v) {
            if (substr($v, -14) != 'Controller.php') {
                unset($v);
                unset($classes[$k]);
                continue;
            }
            $v = substr($v, 0, -14);
            if (!$v) {
                unset($classes[$k]);
            }
        }unset($v);

        return $classes;
    }

    public static function uper2lower($action_id)
    {
        return ltrim(strtolower(preg_replace('/([A-Z])/', '-${1}', $action_id)),'-');
    }
}