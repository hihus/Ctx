<?php
//---测试demo--

ini_set('display_errors', 1);   //@todo 后边也有，这个要去掉
ini_set('error_reporting', E_ALL);  //@todo 后边也有，这个要去掉
define('BRR', '<br />' . "\n");
echo '--通用服务框架测试--start--' . BRR;
try {
    $rootDir = dirname(__FILE__);
    $configPath = $rootDir . '/security/config';
    $ctx = Ctx::getInstance($configPath);
    $ctx->user->getUserInfo(123123);
    $ctx->user->getUserInfo(22222);
} catch (CtxException $e) {
    echo '---框架错误:' . $e->getMessage() . BRR;
} catch (Exception $e) {
    echo $e->getMessage() . BRR;
}
exit( '--end--' );

/**
 * 通用context对象
 * @example 
    require_once(dirname(Tree6P_PATH) . DS . 'codebase' . DS . 'Ctx.php');
    try {
        $rootDir = dirname(__FILE__);
        $configPath = $rootDir . '/security/config';
        $ctx = Ctx::getInstance($configPath);
        $ctx->user->getUserInfo(123123);
        $ctx->user->getUserInfo(22222);
    } catch (CtxException $e) {
        echo '---框架错误:' . $e->getMessage() . BRR;
    } catch (Exception $e) {
        echo $e->getMessage() . BRR;
    }
 */
class Ctx
{
    /**
     * 私有克隆函数，防止外办克隆对象
     */
    private function __clone() {
    }

    /**
     * 框架单例，静态变量保存全局实例
     */
    private static $_instance = null;

    /**
     * 私有构造函数，防止外界实例化对象
     */
    private function __construct($configPath) {
        //加载系统框架必须文件 为了提高效率直接require
        defined('CODE_BASE') || define('CODE_BASE', dirname(__FILE__));
        spl_autoload_register(array(__CLASS__, 'autoload'));
        if (empty($configPath) || ! is_string($configPath)) {
            throw new CtxException('without app config file.');
        }
        $this->ctxConfigPath = $configPath;
        $this->setRuntime();
    }

    /**
     * 配置框架运行环境
     */
    private function setRuntime() {
    }

    /**
     * 框架的自动加载 在model才会用到
     * /只加载路由核心类/
     * @deprecated
     * spl_autoload_register(array(__CLASS__, 'autoload'));
     */
    public static function autoload($className) {
        if (false === strpos($className, '\\')) {  // class without namespace
            $classFile = CODE_BASE . '/ctx/' . $className . '.php'; 
            // if (0 === strpos($className, 'Ctx')) {
            // } else {
            // }
            if (is_file($classFile)) {  //file_exists 可能为文件夹
                include $classFile;
            }
            return class_exists($className,false);
            // return class_exists($className,false) || interface_exists($className,false);
        } else {    //命名空间
            return false;
        }
    }

    /**
     * 请求单例
     */
    public static function getInstance($config = null) {
        if (is_null(self::$_instance) || isset(self::$_instance)) {
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }

    // private $mods = array();

    /**
     * 单例
     */
    public function __get($m) {
        $className = ucfirst($m) . 'Model';
        echo '--初始化模块' . $className . '(一次)--' . BRR;    //@todo
        $file = CODE_BASE . '/app/model/' . $m . '/mod.php';
        if (file_exists($file)) {
            require $file;
            $this->$m = new $className();
            // $this->$m->ctx = new stdClass();
            $this->$m->ctx = $this;
            $this->$m->setModName($m);
            $this->$m->init();
            return $this->$m;
        } else {
            throw new CtxException('mod do not exist.');
        }
        return null;
    }
}
