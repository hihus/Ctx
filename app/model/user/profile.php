<?php
/**
 *
 */
class UserProfileModel extends CtxModel
{
    private $uid = 0;
    public function __construct($uid, $ext) {
        $this->params = array(
            'uid'   => $uid,
            'ext'   => $ext,
        );
    }
    public function getInfo() {
        return '--modName:' . $this->getModName() . '--invoke:' . __METHOD__ . '@' . get_class($this) . '拥有参数:' . print_r($this->params, true);
    }
}
