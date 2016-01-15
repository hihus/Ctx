<?php
/**
 * 模块配置
 * @todo 待思考
 */
class UserConfigModel extends CtxModel
{
    public function test() {
        return '--modName:' . $this->getModName() . '--invoke:' . __METHOD__ . '@' . get_class($this);
    }
}
