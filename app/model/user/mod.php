<?php

class UserModel extends CtxModel
{
    private $user = array();
    public function init() {
        //测试初始化同时测试单例的方式拥有子对象，直接赋值给ctx节点
        $this->ctx->user->config = $this->loadC('config');
    }
    private function getUser($uid) {
        //非单例的方式拥有子对象，方便复用
        if (! isset($user[$uid])) {
            $user[$uid] = $this->loadC('profile', $uid, array('a', 2));
        }
        return $user[$uid];
    }
    public function getUserInfo($uid) {
        //测试框架内连贯写法，单例的方式运行
        echo $this->ctx->user->config->test() . BRR;
        //测试非单例的方式调用，方便复用对象
        echo $this->getUser($uid)->getInfo() . BRR;
        //测试调用其他模块
        echo $this->ctx->club->make() . BRR;
    }
}
