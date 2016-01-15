<?php

/**
 * 所有的模型处理父类
 */
class CtxModel
{
    /**
     * 是否已经初始化了
     */
    // private $inited = false;

    /**
     * 执行父类
     */
    // public function init() {
    // }

    private $modName = '';
    // protected function import($class) {
    //     if (! empty($this->modName)) {
    //         require_once CODE_BASE . '/base/' . $this->modName . '/' . $class . '.php';
    //         // $this->$class = new ucfirst($this->modName . $class . Model);
    //     }
    // }
    public function setModName($modName) {
        if ($modName && is_string($modName) && empty($this->modName)) {
            $this->modName = $modName;
        }
    }
    public function getModName() {
        return $this->modName;
    }

    public function init() {
    }
    protected function loadC() {
        $args = func_get_args();
        $class = array_shift($args);
        echo '--初始化子对象' . $class . '(可以多次)--' . BRR;
        // print_r($args);exit;
        if (! empty($this->modName)) {
            require_once CODE_BASE . '/app/model/' . $this->modName . '/' . $class . '.php';
            $className = ucfirst($this->modName . $class . 'Model');
            $class = new ReflectionClass($className);
            $obj = $class->newInstanceArgs($args);
            $obj->setModName($this->modName);
            return $obj;

            // $this->controllerReflection = new ReflectionClass($controller);
            // $this->controllerReflection->isAbstract() //不能为抽象类
            // $this->controllerReflection->isInterface()    //不能为接口
            // !$this->controllerReflection->isSubclassOf('CController') 必须为子控制器
            // $this->controllerReflection->hasMethod('action名')    action必须存在
            // $this->controllerReflection->getMethod('action名')->isPublic() action必须为public
        }
    }
}
